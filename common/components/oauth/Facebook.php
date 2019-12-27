<?php
namespace common\components\oauth;

use Yii;
use common\models\User;
use common\models\UserOauth;
use common\models\SiteSettings;

/**
 * Class Facebook
 * @package common\components\oauth
 */
class Facebook extends \yii\authclient\clients\Facebook
{
    /**
     * @inheritdoc
     */
    public function init() {
        $client_id = SiteSettings::findOne(['text_key' => 'facebook_client_id']);
        $client_secret = SiteSettings::findOne(['text_key' => 'facebook_client_secret']);
        $this->clientId = $client_id->string_value;
        $this->clientSecret = $client_secret->string_value;
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function getViewOptions() {
        $innerContent = '<svg class="flat__social_icon icon-social-fb" width="51px" height="51px"><use xlink:href="#icon-social-fb"></use></svg>';
        return [
            'popupWidth' => 900,
            'popupHeight' => 600,
            'class' => 'block_social__item block_social__item--fb',
            'content' => $innerContent,
        ];
    }

    /**
     * @return array
     */
    public function normalizeSex() {
        return [
            'male' => User::GENDER_MALE,
            'female' => User::GENDER_FEMALE,
        ];
    }

    /**
     * @inheritdoc
     */
    protected function initUserAttributes() {
        $attributes = $this->api('me', 'GET', [
            'fields' => implode(',', [
                'id',
                'email',
                'name',
                'picture.height(200).width(200)',
                'gender'
            ]),
        ]);


        $return_attributes = [
            'User' => [
                'email' => $attributes['email'],
                'username' => $attributes['email'],
                //'photo' => $attributes['picture']['data']['url'],
                'first_name' => $attributes['name'],
                'gender' => $this->normalizeSex()[$attributes['gender']]
            ],
            'provider_user_id' => $attributes['id'],
            'provider_id' => UserOauth::getAvailableClients()['facebook'],
        ];

        return $return_attributes;
    }
}