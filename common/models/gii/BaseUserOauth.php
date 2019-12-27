<?php
namespace common\models\gii;

use Yii;
use common\models\User;

/**
 * This is the model class for table "user_oauth".
 * Class BaseUserOauth
 * @package common\models\gii
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $provider_id
 * @property string $provider_user_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $user
 */
class BaseUserOauth extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_oauth';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'provider_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['provider_user_id'], 'string', 'max' => 255],
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
            'user_id' => 'User ID',
            'provider_id' => 'Provider ID',
            'provider_user_id' => 'Provider User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
