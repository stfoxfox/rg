<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use common\components\controllers\BackendController;
use common\components\MyExtensions\MyWidget;
use common\components\MyExtensions\WidgetModel;
use common\models\File;
use common\models\Page;
use common\models\PageBlock;
use common\models\PageBlockImage;
use backend\models\forms\PagePictureForm;

/**
 * Class PageController
 * @package backend\controllers
 */
class PageController extends BackendController
{
    public function behaviors()
    {
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

    public function actions()
    {
        return [
            'dell' => [
                'class' => 'common\components\actions\Dell',
                '_model' => Page::className(),
            ],
            'edit' => [
                'class' => 'common\components\actions\Edit',
                '_editForm' => 'backend\models\forms\PageForm',
                '_model' => Page::className(),
                'page_header'=>"Изменение страницы",
                'breadcrumbs'=>[
                    ['label' => 'Управление страницами', 'url' => ['page/index']],
                    ['label' => 'Редактировать']
                ]
            ],
            'add' => [
                'class' => 'common\components\actions\Add',
                '_form' => 'backend\models\forms\PageForm',
                'page_header'=>"Добавление страницы",
                'breadcrumbs'=>[
                    ['label' => 'Управление страницами', 'url' => ['page/index']],
                    ['label' => 'Добавить']
                ]


            ],

            'block-sort' => [
                'class' => 'common\components\actions\Sort',
                '_model' => PageBlock::className(),
            ],
            'block-editable' => [


                'class' => 'common\components\actions\SaveBlockData',

                '_model' => PageBlock::className() ,



            ],

            'save-image-data' => [
                'class' => 'common\components\actions\SaveBlockData',
                '_model' => File::className(),
            ],

            'gallery-sort' => [
            'class' => 'common\components\actions\Sort',
            '_model' => File::className(),
                 ],

            'dell-gallery-item' => [
            'class' => 'common\components\actions\Dell',
            '_model' => File::className(),

            ],

            'dell-block' => [
                'class' => 'common\components\actions\Dell',
                '_model' => PageBlock::className(),
            ],
            'block-add-picture' => [
                'class' => 'common\components\actions\BlockAddPicture',
                '_model' => File::className(),
                '_form' => 'backend\models\forms\PagePictureForm',
            ],
        ];
    }

    public function actionIndex()
    {
        $this->setTitleAndBreadcrumbs('Управление страницами', [
            ['label' => 'Страницы']
        ]);

        $query = Page::find()->where(['is_internal' => false]);
        //$query = Page::find()->where(['not in', 'id', Page::pageIdsWithModels()]);
        $countQuery = clone $query;
        $pages = new \yii\data\Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'items' => $models,
            'pages' => $pages,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionBlocks($id) {
        if ($item = Page::findOne($id)) {

            $this->setTitleAndBreadcrumbs('Управление блоками страницы: ' . $item->title, [
                ['label' => 'Управление страницами', 'url' => ['index']],
                ['label' => $item->title, 'url' => ['edit', 'id' => $item->id]],
                ['label' => 'Блоки']
            ]);

            return $this->render('blocks', [
                'item' => $item,
                'menu' => PageBlock::getRootBlocksList(),
                'blocks' => $item->rootBlocks,
                'possible_parent_id' => null,
            ]);
        }
        throw new NotFoundHttpException("Страница не найдена");
    }

    /**
     * @param $parent_id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionManageBlocks($parent_id) {
        if ($block = PageBlock::findOne($parent_id)) {

            $this->setTitleAndBreadcrumbs('Управление блоками блока ' . $block->block_name, [
                ['label' => 'Управление страницами', 'url' => ['index']],
                ['label' => $block->page->title, 'url' => ['edit', 'id' => $block->page_id]],
                ['label' => 'Управление блоками', 'url' => ['blocks', 'id' => $block->page_id]],
                ['label' => 'Блоки ' . $block->block_name]
            ]);

            return $this->render('blocks', [
                'item' => $block->page,
                'menu' => PageBlock::getChildBlocksList($block->type),
                'blocks' => $block->childBlocks,
                'possible_parent_id' => $block->id,
            ]);
        }
        throw new NotFoundHttpException("Страница не найдена");
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionManageGallery($id) {
        if ($item = PageBlock::findOne($id)) {

            $addPictureForm = new PagePictureForm();
            $addPictureForm->block_id = $item->id;

            $title = 'Управление галереей блока ' . $item->block_name;
            $breadcrumbs = [
                ['label' => 'Управление страницами', 'url' => ['index']],
                ['label' => $item->page->title, 'url' => ['edit', 'id' => $item->page_id]],
                ['label'=> 'Управление блоками', 'url' => ['blocks', 'id' => $item->page_id]]
            ];

            if ($item->parent) {
                $breadcrumbs []= [
                    'label' => 'Блоки ' . $item->parent->block_name,
                    'url' => ['manage-blocks', 'parent_id' => $item->parent->id]
                ];
            }

            $breadcrumbs []= ['label' => 'Галерея'];
            $this->setTitleAndBreadcrumbs($title, $breadcrumbs);

            return $this->render('manage-gallery', ['item' => $item, 'addPictureForm' => $addPictureForm]);
        }

        throw new NotFoundHttpException("Запись не найдена");
    }

    /**
     * @return mixed|string
     * @throws BadRequestHttpException
     */
    public function actionSaveWidget() {
        $formClass = Yii::$app->request->post('model_class_name');
        $widgetClass = Yii::$app->request->post('widget_class_name');
        $page_id = Yii::$app->request->post('page_id');
        $page_block_id = Yii::$app->request->post('page_block_id');
        $parent_id = Yii::$app->request->post('parent_id');

        /** @var WidgetModel $itemForm */
        $itemForm = new $formClass();

        if ($itemForm->load(Yii::$app->request->post())){
            if ($itemForm->validate()) {
                if($page_block = $itemForm->saveJson($widgetClass, $page_id, $page_block_id, $parent_id))
                    return $this->renderAjax('view_widget',[
                        'model' => $itemForm,
                        'class_name' => $widgetClass,
                        'page_block' => $page_block
                    ]);
                else
                    return $this->sendJSONResponse($itemForm->getErrors());
            } else {
                return $this->sendJSONResponse($itemForm->getErrors());
            }
        }
        throw new BadRequestHttpException();
    }

    /**
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionEditWidget() {
        $item_id = Yii::$app->request->post('item_id');
        $added_id = Yii::$app->request->post('added_id');
        $parent_id = Yii::$app->request->post('parent_id');

        $page_block = PageBlock::findOne($item_id);
        $widgetClass = $page_block->widgetClassName;
        $formClass = $page_block->modelClassName;

        /** @var WidgetModel $itemForm */
        $itemForm = new $formClass();
        $itemForm->attributes = get_object_vars($page_block->dataParams);

        if($itemForm->validate()){
//            \Yii::$app->assetManager->bundles = false;
            return $this->renderAjax('add_widget',[
                'model' => $itemForm,
                'class_name' => $widgetClass,
                'page_id' => $page_block->page_id,
                'parent_id' => $parent_id,
                'added_id' => $added_id,
                'page_block' => $page_block
            ]);
        }

        throw new BadRequestHttpException();
    }

    /**
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionGetWidget(){
        $type_id = Yii::$app->request->post('type_id');
        $blocks = PageBlock::BLOCKS;
        $widget = $blocks[$type_id]['widgetClass'];

        /** @var MyWidget $block_widget */
        $block_widget = new $widget([
            'added_id' => Yii::$app->request->post('added_block_idx'),
            'page_id' => Yii::$app->request->post('page_id'),
            'parent_id' => Yii::$app->request->post('parent_id'),
            'params' => ['title' => 'hello']
        ]);
        if($block_widget){
            return $block_widget->backendCreate();
        }
        throw  new BadRequestHttpException();
    }

    public function actionDeleteImageField(){
        $imageField = \Yii::$app->request->post('imageField');
        $block_id = \Yii::$app->request->post('block_id');
        $block = PageBlock::findOne($block_id);

        if($block->deleteBlockImageField($imageField)){
            $widgetClass = $block->widgetClassName;
            $params = $block->dataParams;
            $house = new $widgetClass(['page_id' => $block->page_id, 'params' => $params]);
            if($house){
                return $house->backendView($block);
            }
        }
        throw  new BadRequestHttpException();
    }

    public function actionDeletePageBlockGalleryImage(){
        $gallry_image_id = \Yii::$app->request->post('gallry_image_id');
        $block_id = \Yii::$app->request->post('block_id');
        $block = PageBlock::findOne($block_id);

        $model = \common\models\PageBlockImage::findOne($gallry_image_id);
        if($model->delete()){
            $widgetClass = $block->widgetClassName;
            $params = $block->dataParams;
            $house = new $widgetClass(['page_id' => $block->page_id, 'params' => $params]);
            if($house){
                return $house->backendView($block);
            }
        }
        throw  new BadRequestHttpException();
    }

}