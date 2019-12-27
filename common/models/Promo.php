<?php
namespace common\models;

use Yii;
use common\models\gii\BasePromo;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * Class Promo
 * @package common\models
 * @inheritdoc
 */
class Promo extends BasePromo
{
    const STATUS_EMPTY = 0;
    const STATUS_DISABLED = 10;
    const STATUS_ENABLED = 20;

    const TYPE_ALL = 10;
    const TYPE_LK = 20;

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
     * @param $type
     * @return ActiveQuery
     */
    public static function getByTypeQuery($type) {
        $query = self::find()->orderBy('sort');

        switch ($type) {
            case static::TYPE_ALL:
                $query->andWhere(['<>', 'type', static::TYPE_LK]);
                break;

            default:
                break;
        }

        return $query;
    }

    /**
     * @param $type
     * @return Promo[]
     */
    public static function getByType($type) {
        return self::getByTypeQuery($type)->all();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'title' => 'Название',
            'file_id' => 'Изображение',
            'description' => 'Описание',
            'external_id' => 'External ID',
            'date_to' => 'Истекает',
            'status' => 'Статус',
            'sort' => 'Порядок',
            'type' => 'Где отображать',
            'avatar_id' => 'Аватар менеджера',
            'manager' => 'Менеджер',
            'manager_phone' => 'Телефон менеджера',
            'button_text' => 'Текст на кнопке',
            'button_link' => 'URL кнопки',
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert) {
        $this->date_to && $this->date_to = Yii::$app->formatter->asDate($this->date_to, 'php:Y-m-d');
        return parent::beforeSave($insert);
    }

    /**
     * @param $id
     * @param $type
     * @return Promo[]
     */
    public static function getOthers($id, $type) {
        return self::getByTypeQuery($type)->andWhere(['<>', 'id', $id])
            ->limit(5)->all();
    }
}
