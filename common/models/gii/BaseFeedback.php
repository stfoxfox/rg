<?php
namespace common\models\gii;

use Yii;
use common\models\Flat;
use common\models\User;

/**
 * This is the model class for table "feedback".
 * Class BaseFeedback
 * @package common\models\gii
 *
 * @property integer $id
 * @property integer $type
 * @property integer $status
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $message
 * @property string $extra
 * @property integer $flat_id
 * @property integer $user_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Flat $flat
 * @property User $user
 */
class BaseFeedback extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feedback';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'status', 'flat_id', 'user_id'], 'integer'],
            [['message', 'extra'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'email'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 50],
            [['flat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Flat::className(), 'targetAttribute' => ['flat_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'status' => 'Status',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'message' => 'Message',
            'extra' => 'Extra',
            'flat_id' => 'Flat ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlat()
    {
        return $this->hasOne(Flat::className(), ['id' => 'flat_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
