<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use common\components\controllers\BackendController;
use backend\widgets\editable\EditableAction;
use backend\models\forms\DocForm;
use backend\models\forms\DocVersionForm;
use common\components\actions\Delete;
use common\components\actions\Sortable;
use common\models\Complex;
use common\models\Doc;
use common\models\DocCategory;
use common\models\DocSearch;
use common\models\DocVersion;
use common\models\DocVersionSearch;
use common\models\Section;

/**
 * Class DocController
 * @package backend\controllers
 */
class DocController extends BackendController
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
            'delete-doc' => [
                'class' => Delete::className(),
                'modelClass' => Doc::className(),
            ],
            'delete-doc-category' => [
                'class' => Delete::className(),
                'modelClass' => DocCategory::className(),
            ],
            'delete-doc-version' => [
                'class' => Delete::className(),
                'modelClass' => DocVersion::className(),
            ],
            'editable' => [
                'class' => EditableAction::className(),
                'modelClass' => Doc::className(),
                'formClass' => DocForm::className(),
            ],
            'editable-version' => [
                'class' => EditableAction::className(),
                'modelClass' => DocVersion::className(),
                'formClass' => DocVersionForm::className(),
            ],
            'sort-items' => [
                'class' => Sortable::className(),
            ],
        ]);
    }

    /**
     * @return string
     */
    public function actionIndex() {
        $categories = DocCategory::find()->orderBy('sort')->all();
        $this->setTitleAndBreadcrumbs('Документы', [
            'label' => 'Список'
        ]);

        return $this->render('index', ['categories' => $categories]);
    }

    /**
     * @return mixed|string
     */
    public function actionViewDocGrid() {
        if (!Yii::$app->request->isPjax || empty(Yii::$app->request->get('category_id')))
            return $this->sendJSONResponse('Данных нет');

        $models = (new DocSearch())->search(Yii::$app->request->queryParams);
        return $this->renderAjax('_doc_grid', ['models' => $models]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionEditDoc($id) {
        $doc = $this->findDoc($id);
        $form = new DocForm();
        $versions = (new DocVersionSearch())->search(['doc_id' => $doc->id]);
        $this->setTitleAndBreadcrumbs($doc->category->title . ', ' . $doc->title, [
            ['label' => 'Список', 'url' => ['index']],
            ['label' => 'Редактировать'],
        ]);

        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post())) {
            if ($form->edit($doc)) {
                return $this->redirect(['index']);
            }
        }

        $form->loadFrom($doc);
        return $this->render('edit-doc', ['edit_form' => $form, 'model' => $doc, 'versions' => $versions]);
    }

    /**
     * @return mixed|\yii\web\Response
     */
    public function actionAddDocRedirect() {
        if (!Yii::$app->request->isAjax || empty(Yii::$app->request->post('id')))
            return $this->sendJSONResponse(['error' => true]);

        return $this->redirect(['add-doc', 'id' => Yii::$app->request->post('id')]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionAddDoc($id) {
        $category = $this->findDocCategory($id);
        $form = new DocForm(['category_id' => $category->id]);
        $this->setTitleAndBreadcrumbs($category->title . ', Новый документ', [
            ['label' => 'Список', 'url' => ['index']],
            ['label' => 'Создать'],
        ]);

        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post())) {
            $doc = $form->create();
            if ($doc) {
                return $this->redirect(['edit-doc', 'id' => $doc->id]);
            }
        }

        return $this->render('edit-doc', ['edit_form' => $form, 'model' => null, 'versions' => null]);
    }

    /**
     * @return mixed
     */
    public function actionAddDocCategory() {
        if (!Yii::$app->request->isAjax)
            return $this->sendJSONResponse(['error' => true]);

        $item = new DocCategory([
            'title' => Yii::$app->request->post('title'),
        ]);

        if ($item->save()) {
            $link = Html::a($item->title, 'javascript:void(0)', [
                'class' => 'view-doc-grid',
                'data-id' => $item->id,
            ]);
            $del_link = Html::a('<i class="fa fa-close"></i>', 'javascript:void(0)', [
                'class' => 'label label-info pull-right delete-doc-category',
                'data-id' => $item->id,
                'data-name' => $item->title,
                'data-url' => Url::to(['delete-doc-category']),
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
            ]);
        }

        return $this->sendJSONResponse(['error' => true]);
    }

    /**
     * @return mixed
     */
    public function actionChangeSelection() {
        if (!Yii::$app->request->isAjax || empty(Yii::$app->request->post('value'))
            || empty(Yii::$app->request->post('type')))
            return $this->sendJSONResponse(['success' => false]);

        $tag_options = ['prompt' => ''];
        $type = Yii::$app->request->post('type');
        switch ($type) {
            case 'complex':
                $complex = Complex::findOne(Yii::$app->request->post('value'));
                if ($complex == null) {
                    return $this->sendJSONResponse(['success' => false]);
                }
                return $this->sendJSONResponse([
                    'success' => true,
                    'corpus' => Html::renderSelectOptions(null, Section::getCorpusesList($complex->id), $tag_options),
                    'section' => Html::renderSelectOptions(null, [], $tag_options),
                ]);

            case 'corpus':
                if (empty(Yii::$app->request->post('complex_id'))) {
                    return $this->sendJSONResponse(['success' => false]);
                }
                $complex_id = Yii::$app->request->post('complex_id');
                $corpus_num = Yii::$app->request->post('value');

                return $this->sendJSONResponse([
                    'success' => true,
                    'section' => Html::renderSelectOptions(null, Section::getSectionsList($complex_id, $corpus_num), $tag_options),
                ]);
        }
        return $this->sendJSONResponse(['success' => false]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionAddDocVersion($id) {
        $doc = $this->findDoc($id);
        $form = new DocVersionForm(['doc_id' => $doc->id]);
        $this->setTitleAndBreadcrumbs($doc->title . ', Новая версия', [
            ['label' => 'Список', 'url' => ['index']],
            ['label' => $doc->category->title . ', ' . $doc->title, 'url' => ['edit-doc', 'id' => $doc->id]],
            ['label' => 'Создать'],
        ]);

        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post())) {
            $version = $form->create();
            if ($version) {
                return $this->redirect(['edit-doc', 'id' => $version->doc->id]);
            }
        }

        return $this->render('edit-doc-version', ['edit_form' => $form, 'model' => null]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionEditDocVersion($id) {
        $version = $this->findDocVersion($id);
        $form = new DocVersionForm();
        $this->setTitleAndBreadcrumbs($version->doc->title . ', ' . $version->version, [
            ['label' => 'Список', 'url' => ['index']],
            ['label' => $version->doc->category->title . ', ' . $version->doc->title, 'url' => ['edit-doc', 'id' => $version->doc->id]],
            ['label' => 'Редактировать'],
        ]);

        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post())) {
            if ($form->edit($version)) {
                return $this->redirect(['edit-doc', 'id' => $version->doc->id]);
            }
        }

        $form->loadFrom($version);
        return $this->render('edit-doc-version', ['edit_form' => $form, 'model' => $version]);
    }


    /**
     * @param $id
     * @return Doc
     * @throws NotFoundHttpException
     */
    protected function findDoc($id) {
        $model = Doc::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('Документ не найден');
        }

        return $model;
    }

    /**
     * @param $id
     * @return DocCategory
     * @throws NotFoundHttpException
     */
    protected function findDocCategory($id) {
        $model = DocCategory::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('Категория документа не найдена');
        }

        return $model;
    }

    /**
     * @param $id
     * @return DocVersion
     * @throws NotFoundHttpException
     */
    protected function findDocVersion($id) {
        $model = DocVersion::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('Версия документа не найдена');
        }

        return $model;
    }
}