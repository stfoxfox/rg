<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use common\components\controllers\BackendController;
use common\models\Complex;
use common\models\Flat;
use common\models\FlatSearch;
use common\models\Floor;
use common\models\Section;
use backend\models\forms\FlatForm;
use common\components\actions\Delete;

/**
 * Class FlatsController
 * @package backend\controllers
 */
class FlatsController extends BackendController
{
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return ArrayHelper::merge(parent::actions(), [
            'delete-flat' => [
                'class' => Delete::className(),
                'modelClass' => Flat::className(),
            ],
        ]);
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex() {
        $complex = $this->findComplex();
        $params = ArrayHelper::merge(Yii::$app->request->queryParams, ['complex-id' => $this->complex_id]);
        $dataProvider = (new FlatSearch())->search($params);

        $this->setTitleAndBreadcrumbs($complex->title, [
            'label' => 'Список квартир'
        ]);

        $corpus_title = isset($params['data-corpus']) ? $params['data-corpus'] : null;
        $corpus_url = isset($params['data-corpus-url']) ? $params['data-corpus-url'] : null;

        return $this->render('index', [
            'flats' => $dataProvider,
            'corpus_title' => $corpus_title,
            'corpus_url' => $corpus_url,
        ]);
    }

    /**
     * @return mixed
     */
    public function actionGetTree() {
        $data = []; $i = 0;
        $corpuses = Section::getCorpuses($this->complex_id);

        if (!empty($corpuses)) {
            foreach ($corpuses as $corpus) {
                /** @var $corpus Section */
                $sections = Section::find()
                    ->where(['complex_id' => $this->complex_id, 'corpus_num' => $corpus->corpus_num])
                    ->joinWith('floors')->all();

                $corpus_title = ''; $corpus_url = '';
                if ($corpus->page) {
                    $corpus_title = 'Корпус ' . $corpus->corpus_num;
                    $corpus_url = Url::to(['page/blocks', 'id' => $corpus->page->id]);
                }

                $data []= [
                    'id' => 'corpus_' . $corpus->corpus_num,
                    'parent' => '#',
                    'text' => 'Корпус ' . $corpus->corpus_num,
                    'icon' => 'fa fa-folder',
                    'a_atr' => [
                        'data-id' => $corpus->corpus_num,
                        'data-type' => FlatSearch::SEARCH_WITH_CORPUS,
                        'data-corpus' => $corpus_title,
                        'data-corpus-url' => $corpus_url,
                    ],
                    'state' => [
                        'opened' => true,
                        //'selected' => $i == 0 ? true : false,
                    ],
                ];

                if (!empty($sections)) {
                    foreach ($sections as $section) {
                        /** @var $section Section */
                        $data []= [
                            'id' => 'section_' . $section->id,
                            'parent' => 'corpus_' . $corpus->corpus_num,
                            'text' => 'Секция №' . $section->number,
                            'icon' => 'fa fa-folder-o',
                            'a_atr' => [
                                'data-id' => $section->id,
                                'data-type' => FlatSearch::SEARCH_WITH_SECTION,
                                'data-corpus' => $corpus_title,
                                'data-corpus-url' => $corpus_url,
                            ],
                            'state' => [
                                'opened' => false //$i == 0 ? true : false,
                            ],
                        ];

                        if (!empty($section->floors)) {
                            foreach ($section->floors as $floor) {
                                /** @var $floor Floor */
                                $data []= [
                                    'id' => 'floor_' . $floor->id,
                                    'parent' => 'section_' . $section->id,
                                    'text' => 'Этаж ' . $floor->number,
                                    'icon' => 'fa fa-building',
                                    'a_atr' => [
                                        'data-id' => $floor->id,
                                        'data-type' => FlatSearch::SEARCH_WITH_FLOOR,
                                        'data-corpus' => $corpus_title,
                                        'data-corpus-url' => $corpus_url,
                                    ],
                                    'state' => [
                                        'opened' => false //$i == 0 ? true : false,
                                    ],
                                ];
                            }
                        }
                    }
                }
                $i++;
            }
        }

        return $this->sendJSONResponse(['data' => $data]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionEditFlat($id) {
        $flat = $this->findFlat($id);
        $form = new FlatForm();
        $this->setTitleAndBreadcrumbs('Кваритра №' . $flat->number, [
            ['label' => 'Список квартир', 'url' => ['index']],
            ['label' => 'Корпус ' . $flat->section->corpus_num],
            ['label' => 'Секция №' . $flat->section->number],
            ['label' => 'Этаж ' . $flat->floor->number],
        ]);

        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post())) {
            if ($form->edit($flat)) {
                return $this->redirect(['index']);
            }
        }

        $form->loadFrom($flat);

        return $this->render('edit-flat', ['form' => $form, 'flat' => $flat]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionAddFlat() {
        $form = new FlatForm();
        $this->setTitleAndBreadcrumbs('Новая кваритра', [
            ['label' => 'Список квартир', 'url' => ['index']],
        ]);

        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post())) {
            $flat = $form->create();
            if ($flat) {
                return $this->redirect(['edit-flat', 'id' => $flat->id]);
            }
        }

        return $this->render('edit-flat', ['form' => $form]);
    }

    /**
     * @return static
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