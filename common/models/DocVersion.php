<?php
namespace common\models;

use Yii;
use common\models\gii\BaseDocVersion;
use yii\helpers\ArrayHelper;

/**
 * Class DocVersion
 * @package common\models
 * @inheritdoc
 */
class DocVersion extends BaseDocVersion
{
    /**
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return array
     */
    public static function getList() {
        return ArrayHelper::map(self::find()->all(), 'id', 'version');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'version' => 'Версия',
            'doc_date' => 'Дата документа',
            'doc_id' => 'Документ',
            'file_id' => 'Файл',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert) {
        $this->doc_date && $this->doc_date = Yii::$app->formatter->asDate($this->doc_date, 'php:Y-m-d');
        return parent::beforeSave($insert);
    }

    /**
     * @param $doc_id
     * @return int|mixed|string
     */
    public static function getLatestVersion($doc_id) {
        $version = self::find()->where(['doc_id' => $doc_id])
            ->orderBy(['created_at' => SORT_DESC])->one();
        if ($version) {
            return intval($version->version) + 1;
        }

        return '';
    }
}
