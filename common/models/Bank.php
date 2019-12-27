<?php
namespace common\models;

use Yii;
use common\models\gii\BaseBank;
use yii\helpers\ArrayHelper;

/**
 * Class Bank
 * @package common\models
 * @inheritdoc
 */
class Bank extends BaseBank
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
        return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'license' => 'Номер лицензии банка',
            'date_license' => 'Дата лицензии банка',
            'sort' => 'Sort',
            'external_id' => 'External ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert) {
        $this->date_license && $this->date_license = Yii::$app->formatter->asDate($this->date_license, 'php:Y-m-d');
        return parent::beforeSave($insert);
    }
}
