<?php
namespace common\components\oauth;

use Yii;
use yii\authclient\OAuth2;
use common\models\User;
use common\models\UserOauth;
use common\models\SiteSettings;

/**
 * Class Odnoklassniki
 * @package common\components\oauth
 */
class Odnoklassniki extends OAuth2
{
    /**
     * @var string
     */
    public $applicationKey;

    /**
     * @inheritdoc
     */
    public $authUrl = 'http://www.odnoklassniki.ru/oauth/authorize';

    /**
     * @inheritdoc
     */
    public $tokenUrl = 'https://api.odnoklassniki.ru/oauth/token.do';

    /**
     * @inheritdoc
     */
    public $apiBaseUrl = 'http://api.odnoklassniki.ru';

    /**
     * @inheritdoc
     */
    public $scope = 'VALUABLE_ACCESS';

    /**
     * @inheritdoc
     */
    public function init() {
        $client_id = SiteSettings::findOne(['text_key' => 'ok_client_id']);
        $client_secret = SiteSettings::findOne(['text_key' => 'ok_client_secret']);
        $pub_key = SiteSettings::findOne(['text_key' => 'ok_application_key']);
        $this->clientId = $client_id->string_value;
        $this->clientSecret = $client_secret->string_value;
        $this->applicationKey = $pub_key->string_value;
        parent::init();
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
    public function getViewOptions() {
        $innerContent = '<svg class="flat__social_icon icon-social-ok" width="51px" height="51px"><use xlink:href="#icon-social-ok"></use></svg>';
        return [
            'popupWidth' => 900,
            'popupHeight' => 600,
            'class' => 'block_social__item block_social__item--ok',
            'content' => $innerContent,
        ];
    }

    /**
     * @inheritdoc
     */
    protected function initUserAttributes() {
        $token = $this->accessToken->getToken();
        $params = [
            'access_token' => $token,
            'application_key' => $this->applicationKey,
        ];
        $params['sig'] = $this->sig($params, $token, $this->clientSecret);

        $attributes = $this->api('api/users/getCurrentUser', 'GET', $params);
        $user_str = (isset($attributes['email']))
            ? $attributes['email'] : $attributes['uid'] . '@ok.ru';

        $return_attributes = [
            'User' => [
                'email' => $user_str,
                'username' => $user_str,
                'first_name' => isset($attributes['first_name']) ? $attributes['first_name'] : $attributes['name'],
                'last_name' => isset($attributes['last_name']) ? $attributes['last_name'] : '',
                'birthday' => isset($attributes['birthday']) ? $attributes['birthday'] : null,
                'gender' => $this->normalizeSex()[$attributes['gender']],
            ],
            'provider_user_id' => $attributes['uid'],
            'provider_id' => UserOauth::getAvailableClients()['odnoklassniki'],
        ];

        return $return_attributes;
    }

    /**
     * @inheritdoc
     */
    protected function apiInternal($accessToken, $url, $method, array $params, array $headers) {
        $params['access_token'] = $accessToken->getToken();
        $params['application_key'] = $this->applicationKey;
        $params['method'] = str_replace('/', '.', str_replace('api/', '', $url));
        $params['sig'] = $this->sig($params, $params['access_token'], $this->clientSecret);

        return $this->sendRequest($method, $url, $params, $headers);
    }

    /**
     * Generates a signature
     * @param $vars array
     * @param $accessToken string
     * @param $secret string
     * @return string
     */
    protected function sig($vars, $accessToken, $secret) {
        ksort($vars);
        $params = '';
        foreach ($vars as $key => $value) {
            if (in_array($key, ['sig', 'access_token'])) {
                continue;
            }
            $params .= "$key=$value";
        }
        return md5($params . md5($accessToken . $secret));
    }

    /**
     * @inheritdoc
     */
    protected function defaultName() {
        return 'odnoklassniki';
    }

    /**
     * @inheritdoc
     */
    protected function defaultTitle() {
        return 'Odnoklassniki';
    }

    /**
     * @inheritdoc
     */
    protected function defaultNormalizeUserAttributeMap() {
        return [
            'id' => 'uid'
        ];
    }
}