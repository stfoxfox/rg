<?php
namespace common\components\oauth;

use Yii;
use common\models\User;
use common\models\UserOauth;
use common\models\SiteSettings;

/**
 * Class VKontakte
 * @package common\components\oauth
 */
class VKontakte extends \yii\authclient\clients\VKontakte
{
    /**
     * @inheritdoc
     */
    public function init() {
        $client_id = SiteSettings::findOne(['text_key' => 'vk_client_id']);
        $client_secret = SiteSettings::findOne(['text_key' => 'vk_client_secret']);
        $this->clientId = $client_id->string_value;
        $this->clientSecret = $client_secret->string_value;
        $this->scope = 'email';
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function getViewOptions() {
        $innerContent = '<svg class="flat__social_icon icon-social-vk" width="51px" height="51px"><use xlink:href="#icon-social-vk"></use></svg>';
        return [
            'popupWidth' => 900,
            'popupHeight' => 500,
            'class' => 'block_social__item block_social__item--vk',
            'content' => $innerContent,
        ];
    }

    /**
     * @return array
     */
    public function normalizeSex() {
        return [
            '1' => User::GENDER_MALE,
            '2' => User::GENDER_FEMALE,
        ];
    }

    /**
     * @inheritdoc
     */
    protected function initUserAttributes() {
        $attributes = $this->api('users.get.json', 'GET', [
            'fields' => implode(',', [
                'uid',
                'first_name',
                'last_name',
                'photo_200',
                'sex'
            ]),
        ]);

        $user_str = (isset($this->accessToken->params['email'])) ? $this->accessToken->params['email'] : null;
        $attributes = array_shift($attributes['response']);

        $return_attributes = [
            'User' => [
                'username' => $user_str,
                'email' => $user_str,
                'first_name' => $attributes['first_name'],
                'last_name' => $attributes['last_name'],
                //'photo' => $attributes['photo_200'],
                'gender' => $this->normalizeSex()[$attributes['sex']]
            ],
            'provider_user_id' => $attributes['uid'],
            'provider_id' => UserOauth::getAvailableClients()['vkontakte'],
        ];

        return $return_attributes;
    }
}