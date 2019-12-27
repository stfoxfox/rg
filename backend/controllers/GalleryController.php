<?php
namespace backend\controllers;

use Yii;
use yii\bootstrap\Html;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use common\components\controllers\BackendController;
use backend\widgets\editable\EditableAction;
use backend\models\forms\GalleryForm;
use common\models\Gallery;
use common\models\GalleryItem;
use common\models\GalleryItemSearch;
use common\models\GallerySearch;
use common\models\File;
use common\models\Complex;
use common\models\Section;
use backend\models\forms\FileForm;
use backend\models\forms\GalleryItemForm;
use common\components\actions\Delete;
use common\components\actions\Sortable;

/**
 * Class GalleryController
 * @package backend\controllers
 */
class GalleryController extends BackendController
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
                'modelClass' => Gallery::className(),
                'formClass' => GalleryForm::className(),
            ],
            'editable-item' => [
                'class' => EditableAction::className(),
                'modelClass' => File::className(),
                'formClass' => FileForm::className(),
            ],
            'delete-gallery' => [
                'class' => Delete::className(),
                'modelClass' => Gallery::className(),
            ],
            'delete-item' => [
                'class' => Delete::className(),
                'modelClass' => GalleryItem::className(),
            ],
            'sort-items' => [
                'class' => Sortable::className(),
                'modelClass' => GalleryItem::className(),
            ],
        ]);
    }

    /**
     * @return string
     */
    public function actionIndex() {
        $models = (new GallerySearch())->search(Yii::$app->request->queryParams);
        $this->setTitleAndBreadcrumbs('Галереи', [
            'label' => 'Список'
        ]);

        return $this->render('index', ['models' => $models]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionItems($id) {
        $gallery = $this->findGallery($id);
        $form = new GalleryItemForm();
        $form->gallery_id = $id;

        $this->setTitleAndBreadcrumbs('Файлы галереи', [
            ['label' => 'Галереи', 'url' => ['index']],
            ['label' => $gallery->title, 'url' => ['edit-gallery', 'id' => $gallery->id]],
            ['label' => 'Список'],
        ]);

        return $this->render('items', ['picture_form' => $form]);
    }

    /**
     * @return mixed|string
     */
    public function actionViewGrid() {
        if (!Yii::$app->request->isPjax || empty(Yii::$app->request->get('gallery_id')))
            return $this->sendJSONResponse('Данных нет');

        $models = (new GalleryItemSearch())->search(Yii::$app->request->queryParams);
        return $this->renderAjax('_items_grid', ['models' => $models]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionAddGallery() {
        $form = new GalleryForm();
        $this->setTitleAndBreadcrumbs('Новая галерея', [
            ['label' => 'Галереи', 'url' => ['index']],
            ['label' => 'Создать'],
        ]);

        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post())) {
            $gallery = $form->create();
            if ($gallery) {
                return $this->redirect(['items', 'id' => $gallery->id]);
            }
        }

        return $this->render('edit-gallery', ['form' => $form, 'model' => null]);
    }

    /**
     * @return mixed
     */
    public function actionAddItem() {
        if (!Yii::$app->request->isAjax || empty(Yii::$app->request->post()))
            return $this->sendJSONResponse(['error' => true]);

        $form = new GalleryItemForm();
        if ($form->load(Yii::$app->request->post())) {
            if ($form->create()) {
                return $this->sendJSONResponse(['success' => true]);
            }
        }

        return $this->sendJSONResponse(['error' => true]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionEditItem($id) {
        $item = $this->findGalleryItem($id);
        $form = new GalleryItemForm();
        $this->setTitleAndBreadcrumbs('Файл', [
            ['label' => 'Галереи', 'url' => ['index']],
            ['label' => $item->gallery->title, 'url' => ['edit-gallery', 'id' => $item->gallery->id]],
            ['label' => 'Файлы галереи', 'url' => ['items', 'id' => $item->gallery->id]],
            ['label' => 'Редактировать'],
        ]);

        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post())) {
            if ($form->edit($item)) {
                return $this->redirect(['items', 'id' => $item->gallery->id]);
            }
        }

        $form->loadFrom($item);
        return $this->render('edit-item', ['edit_form' => $form, 'model' => $item]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionEditGallery($id) {
        $gallery = $this->findGallery($id);
        $form = new GalleryForm();
        $this->setTitleAndBreadcrumbs($gallery->title, [
            ['label' => 'Галереи', 'url' => ['index']],
            ['label' => 'Редактировать'],
        ]);

        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post())) {
            if ($form->edit($gallery)) {
                return $this->redirect(['items', 'id' => $gallery->id]);
            }
        }

        $form->loadFrom($gallery);
        return $this->render('edit-gallery', ['form' => $form]);
    }

    /**
     * @return mixed
     */
    public function actionGetCorpusList() {
        if (!Yii::$app->request->isAjax || empty(Yii::$app->request->post('id')))
            return $this->sendJSONResponse(['success' => false]);

        $tag_options = ['prompt' => ''];
        $complex = Complex::findOne(Yii::$app->request->post('id'));
        if ($complex == null) {
            return $this->sendJSONResponse(['success' => false]);
        }

        $items = Html::renderSelectOptions(null, Section::getCorpusesList($complex->id), $tag_options);
        return $this->sendJSONResponse(['success' => true, 'options' => $items]);
    }

    /**
     * @param $id
     * @return Gallery
     * @throws NotFoundHttpException
     */
    protected function findGallery($id) {
        $model = Gallery::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('Галерея не найдена');
        }

        return $model;
    }

    /**
     * @param $id
     * @return GalleryItem
     * @throws NotFoundHttpException
     */
    protected function findGalleryItem($id) {
        $model = GalleryItem::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('Элемент галереи не найден');
        }

        return $model;
    }

}