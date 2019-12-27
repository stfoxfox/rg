<?php
namespace common\components\oauth;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\authclient\ClientInterface;
use yii\authclient\widgets\AuthChoice as yiiAuthChoice;
use yii\authclient\widgets\AuthChoiceItem;
use yii\authclient\widgets\AuthChoiceAsset;

/**
 * Class AuthChoice
 * @package common\components\oauth
 */
class AuthChoice extends yiiAuthChoice
{
    public $clientCssClass = 'block_social block_social--auth_info';

    /**
     * @var string name of the auth client collection application component.
     * This component will be used to fetch services value if it is not set.
     */
    public $clientCollection = 'authClientCollection';

    /**
     * @var string name of the GET param , which should be used to passed auth client id to URL
     * defined by [[baseAuthUrl]].
     */
    public $clientIdGetParamName = 'authclient';

    /**
     * @var array configuration for the external clients base authentication URL.
     */
    private $_baseAuthUrl;

    /**
     * @var ClientInterface[] auth providers list.
     */
    private $_clients;

    /**
     * @param ClientInterface[] $clients auth providers
     */
    public function setClients(array $clients) {
        $this->_clients = $clients;
    }

    /**
     * @return ClientInterface[] auth providers
     */
    public function getClients() {
        if ($this->_clients === null) {
            $this->_clients = $this->defaultClients();
        }

        return $this->_clients;
    }

    /**
     * @param array $baseAuthUrl base auth URL configuration.
     */
    public function setBaseAuthUrl(array $baseAuthUrl) {
        $this->_baseAuthUrl = $baseAuthUrl;
    }

    /**
     * @return array base auth URL configuration.
     */
    public function getBaseAuthUrl() {
        if (!is_array($this->_baseAuthUrl)) {
            $this->_baseAuthUrl = $this->defaultBaseAuthUrl();
        }

        return $this->_baseAuthUrl;
    }

    /**
     * Returns default auth clients list.
     * @return ClientInterface[] auth clients list.
     */
    protected function defaultClients() {
        /* @var $collection \yii\authclient\Collection */
        $collection = Yii::$app->get($this->clientCollection);

        return $collection->getClients();
    }

    /**
     * Composes default base auth URL configuration.
     * @return array base auth URL configuration.
     */
    protected function defaultBaseAuthUrl() {
        $baseAuthUrl = [
            Yii::$app->controller->getRoute()
        ];
        $params = $_GET;
        unset($params[$this->clientIdGetParamName]);
        $baseAuthUrl = array_merge($baseAuthUrl, $params);

        return $baseAuthUrl;
    }

    /**
     * Outputs client auth link.
     * @param ClientInterface $client external auth client instance.
     * @throws InvalidConfigException on wrong configuration.
     * @return string
     */
    public function clientLink($client) {
        $viewOptions = $client->getViewOptions();
        $viewOptions['class'] = isset($viewOptions['class'])
            ? $viewOptions['class'] . ' auth-link'
            :  'block_social__item block_social__item--' . $client->getName() . ' auth-link';
        $htmlOptions = [
            'class' => $viewOptions['class']
        ];

        if (empty($viewOptions['widget'])) {
            if (isset($viewOptions['popupWidth'])) {
                $htmlOptions['data-popup-width'] = $viewOptions['popupWidth'];
            }

            if (isset($viewOptions['popupHeight'])) {
                $htmlOptions['data-popup-height'] = $viewOptions['popupHeight'];
            }

            echo Html::a($viewOptions['content'], $this->createClientUrl($client), $htmlOptions);

        } else {
            $widgetConfig = $viewOptions['widget'];
            if (!isset($widgetConfig['class'])) {
                throw new InvalidConfigException('Widget config "class" parameter is missing');
            }

            /* @var $widgetClass Widget */
            $widgetClass = $widgetConfig['class'];
            if (!(is_subclass_of($widgetClass, AuthChoiceItem::className()))) {
                throw new InvalidConfigException('Item widget class must be subclass of "' . AuthChoiceItem::className() . '"');
            }

            unset($widgetConfig['class']);
            $widgetConfig['client'] = $client;
            $widgetConfig['authChoice'] = $this;
            echo $widgetClass::widget($widgetConfig);
        }
    }

    /**
     * Composes client auth URL.
     * @param ClientInterface $provider external auth client instance.
     * @return string auth URL.
     */
    public function createClientUrl($provider) {
        $url = $this->getBaseAuthUrl();
        $url[$this->clientIdGetParamName] = $provider->getId();

        return Url::to($url);
    }


    /**
     * Initializes the widget.
     */
    public function init() {
        $view = Yii::$app->getView();
        $this->options['id'] = $this->getId();
        $this->options['class'] = $this->clientCssClass;

        AuthChoiceAsset::register($view);
        $view->registerJs("\$('#" . $this->getId() . "').authchoice();");
    }

    /**
     * Runs the widget.
     */
    public function run() {
        echo Html::beginTag('div', $this->options);

        foreach ($this->getClients() as $externalService) {
            $this->clientLink($externalService);
        }

        echo Html::endTag('div');
    }
}