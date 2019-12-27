<?php
namespace common\components\controllers;

use common\models\SiteSettings;
use Yii;
use yii\web\Controller;
use yii\web\Cookie;
use common\components\MyExtensions\MyImagePublisher;
use common\models\Complex;

/**
 * Class BackendController
 * @package common\components\controllers
 */
class BackendController extends Controller {

    public $pageHeader;
    public $show_header = true;
    public $forceActive = false;
    /** @var MyImagePublisher $image_publisher */
    public $image_publisher;
    public $complex_id;

    /**
     * @inheritdoc
     */
    public function init() {
        $cookies = Yii::$app->request->cookies;

        if ($cookies->has('complex_id')) {
            $this->complex_id = $cookies->getValue('complex_id');

        } else {

            $complex_settings = SiteSettings::find()->where(['text_key'=>'complexId'])->one();


            $new_cookies = Yii::$app->response->cookies;
            $complex = Complex::find()->where(['external_id'=>$complex_settings->string_value])->one();

            if (empty($complex)) {
                $complex = new Complex(['title' => 'Temp Complex']);
                $complex->save();
            }

            $new_cookies->add(new Cookie([
                'name' => 'complex_id',
                'value' => $complex->id,
            ]));
            $this->complex_id = $complex->id;
        }

        parent::init();
    }

    /**
     * @param $data
     * @param int $httpStatus
     * @param null $isError
     * @return mixed
     */
    public function sendJSONResponse($data, $httpStatus=200, $isError=null) {
        Yii::$app->response->format = 'json';
        return $data;
    }

    /**
     * @param $data
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    public  function serializeData($data) {
        return Yii::createObject($this->serializer)->serialize($data);
    }

    /**
     * @param $title
     * @param null $breadcrumbs
     * @param null $header
     */
    public function setTitleAndBreadcrumbs($title, $breadcrumbs=null, $header=null) {
        $this->view->title=$title;

        if (isset($header)) {
            $this->view->params['pageHeader'] = $header;
        } else {
            $this->view->params['pageHeader'] = $title;
        }

        if (isset($breadcrumbs)) {
            foreach ($breadcrumbs as $breadcrumb) {
                $this->view->params['breadcrumbs'][] = $breadcrumb;
            }
        }
    }



}