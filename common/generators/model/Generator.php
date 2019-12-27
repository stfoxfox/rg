<?php

namespace common\generators\model;
use yii\gii\generators\model\Generator as BaseGenerator;
use yii\gii\CodeFile;
use Yii;
use yii\helpers\ArrayHelper;

class Generator extends BaseGenerator
{
    public $ns = 'common\models';

    public $formNs = 'backend\models\forms';

    public $exceptColumns = ['created_at', 'updated_at', 'id'];

    public $baseClass = '\common\components\MyExtensions\MyActiveRecord';

    /**
     * @param \yii\db\TableSchema $table the table schema
     * @return array
     */
    public function getTableColumns($table) {
        $cols = array_values($table->getColumnNames());
        return array_diff($cols, $this->exceptColumns);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'formNs' => 'Form namespace'
        ]);
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['formNs'], 'filter', 'filter' => 'trim'],
            [['formNs'], 'match', 'pattern' => '/^[\w\\\\]+$/', 'message' => 'Only word characters and backslashes are allowed.'],
            [['formNs'], 'validateNamespace'],
        ]);
    }

    public function generate()
    {
        $files = [];
        $relations = $this->generateRelations();
        $db = $this->getDbConnection();
        foreach ($this->getTableNames() as $tableName) {
            // model :
            $modelClassName = $this->generateClassName($tableName);
            $queryClassName = ($this->generateQuery) ? $this->generateQueryClassName($modelClassName) : false;
            $tableSchema = $db->getTableSchema($tableName);
            $columns = $this->getTableColumns($tableSchema);
            $params = [
                'tableName' => $tableName,
                'className' => $modelClassName,
                'queryClassName' => $queryClassName,
                'tableSchema' => $tableSchema,
                'labels' => $this->generateLabels($tableSchema),
                'rules' => $this->generateRules($tableSchema),
                'relations' => isset($relations[$tableName]) ? $relations[$tableName] : [],
            ];
            $files[] = new CodeFile(
                Yii::getAlias('@' . str_replace('\\', '/', $this->ns)) . '/gii/Base' . $modelClassName . '.php',
                $this->render('baseModel.php', $params)
            );
            $files[] = new CodeFile(
                Yii::getAlias('@' . str_replace('\\', '/', $this->ns)) . '/' . $modelClassName . '.php',
                $this->render('model.php', $params)
            );
            $files[] = new CodeFile(
                Yii::getAlias('@' . str_replace('\\', '/', $this->formNs)) . '/' . $modelClassName . 'Form.php',
                $this->render('form.php', array_merge($params, ['columns' => $columns]))
            );

            // query :
            if ($queryClassName) {
                $params['className'] = $queryClassName;
                $params['modelClassName'] = $modelClassName;
                $files[] = new CodeFile(
                    Yii::getAlias('@' . str_replace('\\', '/', $this->queryNs)) . '/' . $queryClassName . '.php',
                    $this->render('query.php', $params)
                );
            }
        }

        return $files;
    }
}