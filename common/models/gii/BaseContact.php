<?php
namespace common\models\gii;

use Yii;

/**
 * This is the model class for table "contact".
 * Class BaseContact
 * @package common\models\gii
 *
 * @property integer $id
 * @property string $title
 * @property string $address
 * @property string $hours
 * @property string $phones
 * @property string $email
 * @property integer $sort
 * @property string $created_at
 * @property string $updated_at
 */
class BaseContact extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'address', 'hours', 'phones', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'address' => 'Address',
            'hours' => 'Hours',
            'phones' => 'Phones',
            'email' => 'Email',
            'sort' => 'Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
