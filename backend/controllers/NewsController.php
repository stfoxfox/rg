<?php
namespace backend\controllers;

use common\models\NewsTag;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use common\components\controllers\BackendController;
use backend\widgets\editable\EditableAction;
use common\components\actions\Delete;
use common\components\actions\Sortable;
use common\models\News;
use backend\models\forms\NewsForm;
use common\models\NewsSearch;

/**
 * Class NewsController
 * @package backend\controllers
 */
class NewsController extends BackendController
{
    /** @inheritdoc */
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
            'editable' => [
                'class' => EditableAction::className(),
                'modelClass' => News::className(),
                'formClass' => NewsForm::className(),
            ],
            'delete-news' => [
                'class' => Delete::className(),
                'modelClass' => News::className(),
            ],
            'delete-tag' => [
                'class' => Delete::className(),
                'modelClass' => NewsTag::className(),
            ],
            'sort-tag' => [
                'class' => Sortable::className(),
                'modelClass' => NewsTag::className(),
            ],
        ]);
    }

    /**
     * @return string
     */
    public function actionIndex() {
        $models = (new NewsSearch())->search(Yii::$app->request->queryParams);
        $this->setTitleAndBreadcrumbs('Новости', [
            'label' => 'Список'
        ]);

        return $this->render('index', ['models' => $models]);
    }

    /**
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionAddNews() {
        if (!Yii::$app->request->isAjax)
            return $this->sendJSONResponse(['error' => true]);

        $form = new NewsForm([
            'title' => Yii::$app->request->post('title')
        ]);
        $news = $form->create();
        if ($news) {
            return $this->redirect(['edit-news', 'id' => $news->id]);
        }

        throw new NotFoundHttpException('Новость не найдена');
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionEditNews($id) {
        $news = $this->findNews($id);
        $form = new NewsForm();
        $this->setTitleAndBreadcrumbs($news->title, [
            ['label' => 'Новости', 'url' => ['index']],
            ['label' => 'Редактировать'],
        ]);

        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post())) {
            if ($form->edit($news)) {
                return $this->redirect(['index']);
            }
        }

        $form->loadFrom($news);
        return $this->render('edit-news', [
            'edit_form' => $form,
            'model' => $news,
            'tags' => NewsTag::find()->orderBy('sort')->all(),
        ]);
    }

    /**
     * @return mixed
     */
    public function actionAddTag() {
        if (!Yii::$app->request->isAjax)
            return $this->sendJSONResponse(['error' => true]);

        $item = new NewsTag([
            'title' => Yii::$app->request->post('title'),
        ]);

        if ($item->save()) {
            $link = Html::a($item->title, 'javascript:void(0)', [
                'class' => '',
                'data-id' => $item->id,
            ]);
            $del_link = Html::a('<i class="fa fa-close"></i>', 'javascript:void(0)', [
                'class' => 'label label-info pull-right delete-tag',
                'data-id' => $item->id,
                'data-name' => $item->title,
                'data-url' => Url::to(['delete-tag']),
            ]);
            $item = Html::tag('li', $del_link
                . Html::tag('div', Html::tag('span', '<i class="fa fa-bars"></i> ') . $link, [
                    'class' => 'dd-handle'
                ]), [
                'id' => 'item_id_' . $item->id, 'class' => 'dd-item', 'data-id' => $item->id, 'data-title' => $item->title
            ]);

            return $this->sendJSONResponse([
                'error' => false,
                'item' => $item,
                'tags' => Html::renderSelectOptions(null, NewsTag::getList()),
            ]);
        }

        return $this->sendJSONResponse(['error' => true]);
    }

    /**
     * @return mixed
     */
    public function actionLoadTags() {
        if (!Yii::$app->request->isAjax)
            return $this->sendJSONResponse(['error' => true]);

        return $this->sendJSONResponse([
            'error' => false,
            'tags' => Html::renderSelectOptions(null, NewsTag::getList()),
        ]);
    }

    /**
     * @param $id
     * @return News
     * @throws NotFoundHttpException
     */
    protected function findNews($id) {
        $model = News::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('Новость не найдена');
        }

        return $model;
    }
}