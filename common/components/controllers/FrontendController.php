<?php
namespace common\components\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Cookie;
use common\models\Complex;
use common\models\SiteSettings;

/**
 * Class FrontendController
 * @package common\components\controllers
 */
class FrontendController extends Controller {

	public $darkHeader = false;
	public $pageHeader;
	public $show_header = true;
    public $complex_id;

    /**
     * @inheritdoc
     */
    public function init() {
        $cookies = Yii::$app->request->cookies;

        if ($cookies->has('complex_id')) {
            $this->complex_id = $cookies->getValue('complex_id');

        } else {

            $complex_settings = SiteSettings::findOne(['text_key' => 'complexId']);

            $new_cookies = Yii::$app->response->cookies;
            $complex = Complex::findOne(['external_id' => $complex_settings->string_value]);

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

    public function beforeAction($action)
	{
	    // your custom code here, if you want the code to run before action filters,
	    // which are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl
		$this->view->params['darkHeader'] = $this->darkHeader;

	    if (!parent::beforeAction($action)) {
	        return false;
	    }

	    // other custom code here

	    return true; // or false to not run the action
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
}
