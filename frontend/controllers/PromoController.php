<?php
namespace frontend\controllers;

use common\models\Page;
use Yii;
use common\components\controllers\FrontendController;
use yii\helpers\Inflector;
use yii\web\NotFoundHttpException;
use common\models\Promo;

/**
 * Class PromoController
 * @package frontend\controllers
 */
class PromoController extends FrontendController
{
    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex() {
        $promos = Promo::getByType(Promo::TYPE_ALL);
        if (!$promos)
            throw new NotFoundHttpException('Спецпредложений не найдено');

        $this->setTitleAndBreadcrumbs('Специальные предложения', [
            ['label' => 'Специальные предложения'],
        ]);

        return $this->render('index', ['promos' => $promos]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id) {
        $promo = $this->findPromo($id);
        $this->setTitleAndBreadcrumbs($promo->title, [
            ['label' => 'Специальные предложения', 'url' => ['index']],
            ['label' => $promo->title]
        ]);

        $page = $promo->page;
        if (!$page) {
            $page = $this->createPromoPage($promo);
        }

        return $this->render('view', [
            'model' => $promo,
            'page' => $page,
            'promos' => Promo::getOthers($promo->id, Promo::TYPE_ALL),
        ]);
    }

    /**
     * @param $id
     * @return Promo
     * @throws NotFoundHttpException
     */
    protected function findPromo($id) {
        $model = Promo::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('Спецпредложение не найдено');
        }

        return $model;
    }

    /**
     * @param Promo $promo
     * @return Page
     */
    protected function createPromoPage($promo) {
        $page = new Page([
            'title' => 'Спецпредложение ' . $promo->title,
            'slug' => Inflector::slug('Промо ' . $promo->title),
            'is_internal' => true,
        ]);

        $page->save(false);
        $promo->link('page', $page);
        return $page;
    }

}