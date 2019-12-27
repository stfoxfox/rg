<?php
namespace common\components\oauth;

use Yii;
use common\models\User;
use common\models\UserOauth;
use common\models\SiteSettings;
use yii\helpers\ArrayHelper;

/**
 * Class Twitter
 * @package common\components\oauth
 */
class Twitter extends \yii\authclient\clients\Twitter
{
    /**
     * @inheritdoc
     */
    public function init() {
        $client_key = SiteSettings::findOne(['text_key' => 'twitter_consumer_key']);
        $client_secret = SiteSettings::findOne(['text_key' => 'twitter_consumer_secret']);
        $this->consumerKey = $client_key->string_value;
        $this->consumerSecret = $client_secret->string_value;
        $this->attributeParams = ArrayHelper::merge($this->attributeParams, [
            'include_email' => 'true'
        ]);
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function getViewOptions() {
        $innerContent = '<svg class="flat__social_icon icon-social-tw" width="51px" height="51px"><use xlink:href="#icon-social-tw"></use></svg>';
        return [
            'popupWidth' => 900,
            'popupHeight' => 500,
            'class' => 'block_social__item block_social__item--tw',
            'content' => $innerContent,
        ];
    }

    /**
     * @inheritdoc
     */
    protected function initUserAttributes() {
        $attributes = $this->api('account/verify_credentials.json', 'GET');

        $user_str = (isset($this->accessToken->params['email']))
            ? $this->accessToken->params['email'] : $this->accessToken->params['screen_name'] . '@twitter.com';

        $return_attributes = [
            'User' => [
                'email' => $user_str,
                'username' => $user_str,
                'first_name' => $attributes['name'],
                'gender' => User::GENDER_MALE
            ],
            'provider_user_id' => strval($attributes['id']),
            'provider_id' => UserOauth::getAvailableClients()['twitter'],
        ];

        return $return_attributes;
    }
}