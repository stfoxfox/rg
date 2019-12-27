<?php
namespace frontend\controllers;

use common\models\Section;
use Yii;
use common\components\controllers\FrontendController;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use common\models\Complex;
use common\models\Flat;
use common\models\FlatSearch;

/**
 * Class FlatsController
 * @package frontend\controllers
 */
class FlatsController extends FrontendController
{
    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex() {
        $complex = $this->findComplex();
        $model = new FlatSearch();

        $this->setTitleAndBreadcrumbs('Подбор квартиры в ' . $complex->title, [
            ['label' => 'Подбор квартиры'],
        ]);

        return $this->render('index', [
            'model' => $model,
            'complex' => $complex,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id) {
        $flat = $this->findFlat($id);
        $page = $flat->section->corpus->page;
        $this->setTitleAndBreadcrumbs($flat->complex->title . ', Корпус ' . $flat->section->corpus_num, [
            ['label' => 'Подбор квартиры', 'url' => ['flats/index']],
            ['label' => 'Квартира ' . $flat->number]
        ]);

        return $this->render('view', ['model' => $flat, 'page' => $page]);
    }

    /**
     * @param null $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionCorpus($id = null) {
        $complex = $this->findComplex();
        $model = new FlatSearch();

        /** @var Section $section */
        $query = Section::find()->andWhere(['complex_id' => $complex->id]);
        if ($id) {
            $query->andWhere(['corpus_num' => $id]);
        }
        $section = $query->one();
        if (!$section) {
            throw new NotFoundHttpException('Корпус не найден');
        }

        $content = $this->renderPartial('header', [
            'complex' => $complex,
            'section' => $section,
            'corpuses' => Section::getOtherCorpusesInComplex($section->id, $complex->id)
        ]);

        $this->setTitleAndBreadcrumbs('', [
            ['label' => 'Подбор квартиры в ' . $complex->title, 'url' => ['index']],
            ['label' => 'Корпус ' . $section->corpus_num],
        ], $content);

        return $this->render('corpus', [
            'model' => $model,
            'section' => $section,
        ]);
    }

    /**
     * @return Complex
     * @throws NotFoundHttpException
     */
    protected function findComplex() {
        $model = Complex::findOne($this->complex_id);
        if ($model === null) {
            throw new NotFoundHttpException('Комплекс не найден');
        }

        return $model;
    }

    /**
     * @param $id
     * @return Flat
     * @throws NotFoundHttpException
     */
    protected function findFlat($id) {
        $model = Flat::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('Квартира не найдена');
        }

        return $model;
    }
}
