<?php
namespace common\models;

use Yii;
use common\models\gii\BaseUserOauth;

/**
* This is the model class for table "user_oauth".
* Class UserOauth
* @package common\models
* @inheritdoc
*/
class UserOauth extends BaseUserOauth
{
    /**
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public static function getAvailableClients() {
        return [
            'vkontakte' => 1,
            'facebook' => 2,
            'twitter' => 3,
            'odnoklassniki' => 4,
        ];
    }
}
