<?php
namespace common\models\gii;

use Yii;
use common\components\MyExtensions\MyActiveRecord;

/**
 * Class BaseMenu
 * @package common\models\gii
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $type
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class BaseMenu extends MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['description'], 'string'],
            [['type', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'description' => 'Описание',
            'type' => 'Тип меню',
            'status' => 'Статус',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
