<?php
namespace backend\controllers;

use common\components\actions\Delete;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use common\components\controllers\BackendController;
use backend\widgets\editable\EditableAction;
use common\models\Menu;
use common\models\MenuSearch;
use backend\models\forms\MenuForm;
use common\models\MenuItem;
use backend\models\forms\MenuItemForm;
use yii\widgets\ActiveForm;

/**
 * Class MenuController
 * @package backend\controllers
 */
class MenuController extends BackendController
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
                'modelClass' => Menu::className(),
                'formClass' => MenuForm::className(),
            ],
            'editable-item' => [
                'class' => EditableAction::className(),
                'modelClass' => MenuItem::className(),
                'formClass' => MenuItemForm::className(),
            ],
            'delete-menu' => [
                'class' => Delete::className(),
                'modelClass' => Menu::className(),
            ],
            'delete-item' => [
                'class' => Delete::className(),
                'modelClass' => MenuItem::className(),
            ],
        ]);
    }

    /**
     * @return string
     */
    public function actionIndex() {
        $menus = (new MenuSearch())->search(Yii::$app->request->queryParams);
        $this->setTitleAndBreadcrumbs('Меню', [
            'label' => 'Список'
        ]);

        return $this->render('index', ['menus' => $menus]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionItems($id) {
        $menu = $this->findMenu($id);
        $this->setTitleAndBreadcrumbs('Элементы меню', [
            ['label' => 'Меню', 'url' => ['index']],
            ['label' => $menu->title, 'url' => ['edit-menu', 'id' => $menu->id]],
            ['label' => 'Список'],
        ]);

        return $this->render('items', ['menu' => $menu]);
    }

    /**
     * @return mixed|string
     * @throws NotFoundHttpException
     */
    public function actionViewItem() {
        if (!Yii::$app->request->isPjax || empty(Yii::$app->request->get('id')))
            return $this->sendJSONResponse('Данных нет');

        $model = $this->findMenuItem(Yii::$app->request->get('id'));

        if (Yii::$app->request->get('controller')) {
            $model->controller = Yii::$app->request->get('controller');
            $model->action = null;
            $model->params = null;
        }

        if (Yii::$app->request->get('action')) {
            $model->action = Yii::$app->request->get('action');
            $model->params = null;
        }

        $form = new MenuItemForm();
        $form->loadFrom($model);

        return $this->renderAjax('_form_item', ['edit_form' => $form]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionEditMenu($id) {
        $menu = $this->findMenu($id);
        $form = new MenuForm();
        $this->setTitleAndBreadcrumbs('Меню: ' . $menu->title, [
            ['label' => 'Меню', 'url' => ['index']],
        ]);

        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post())) {
            if ($form->edit($menu)) {
                return $this->redirect(['items', 'id' => $menu->id]);
            }
        }

        $form->loadFrom($menu);
        return $this->render('edit-menu', ['form' => $form, 'model' => $menu]);
    }

    /**
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionEditItem() {
        if (empty(Yii::$app->request->post('MenuItemForm')))
            return $this->sendJSONResponse(['error' => true]);

        $post = Yii::$app->request->post('MenuItemForm');
        $item = $this->findMenuItem($post['id']);
        $form = new MenuItemForm();

        if ($form->load(Yii::$app->request->post())) {
            if ($form->edit($item)) {
                return $this->redirect(['items', 'id' => $item->menu_id]);
                //return $this->sendJSONResponse(['error' => false, 'id' => $item->id, 'title' => $item->title]);
            }
        }

        return $this->sendJSONResponse(['error' => true, 'validate' => ActiveForm::validate($form)]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionAddMenu() {
        $form = new MenuForm();
        $this->setTitleAndBreadcrumbs('Новое меню', [
            ['label' => 'Меню', 'url' => ['index']],
        ]);

        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post())) {
            $menu = $form->create();
            if ($menu) {
                return $this->redirect(['items', 'id' => $menu->id]);
            }
        }

        return $this->render('edit-menu', ['form' => $form, 'model' => null]);
    }

    /**
     * @return mixed
     */
    public function actionAddItem() {
        if (!Yii::$app->request->isAjax || empty(Yii::$app->request->post('menu_id')))
            return $this->sendJSONResponse(['error' => true]);

        $item = new MenuItem([
            'title' => Yii::$app->request->post('title'),
            'menu_id' => Yii::$app->request->post('menu_id'),
        ]);

        if ($item->save()) {
            $link = Html::a($item->title, 'javascript:void(0)', [
                'class' => 'view-item',
                'data-id' => $item->id,
            ]);
            $del_link = Html::a('<i class="fa fa-close"></i>', 'javascript:void(0)', [
                'class' => 'label label-info pull-right delete-item',
                'data-id' => $item->id,
                'data-name' => $item->title,
                'data-url' => Url::to(['delete-item']),
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
    public function actionNestableItems() {
        $sort_id = 1;
        $order = Yii::$app->request->post('sort_data');
        $orders = Json::decode($order);

        foreach ($orders as $item) {
            $item_obj = MenuItem::findOne($item['id']);
            if ($item_obj) {
                $item_obj->parent_id = null;
                $item_obj->sort = $sort_id;
                $item_obj->save();

                if (ArrayHelper::getValue($item, 'children')) {
                    self::getTree(ArrayHelper::getValue($item, 'children'), $item_obj->id);
                }
            }
            $sort_id++;
        }

        return $this->sendJSONResponse(['error' => false]);
    }

    /**
     * @param $node
     * @param $parent_id
     */
    protected static function getTree($node, $parent_id) {
        $sort_id = 1;
        foreach ($node as $item) {
            $item_obj = MenuItem::findOne($item['id']);
            if ($item_obj) {
                $item_obj->parent_id = $parent_id;
                $item_obj->sort = $sort_id;
                $item_obj->save();
                if (ArrayHelper::getValue($item, 'children')) {
                    self::getTree(ArrayHelper::getValue($item, 'children'), $item_obj->id);
                }
            }

            $sort_id++;
        }
    }

    /**
     * @param $id
     * @return Menu
     * @throws NotFoundHttpException
     */
    protected function findMenu($id) {
        $model = Menu::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('Меню не найдено');
        }

        return $model;
    }

    /**
     * @param $id
     * @return MenuItem
     * @throws NotFoundHttpException
     */
    protected function findMenuItem($id) {
        $model = MenuItem::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('Элемент меню не найден');
        }

        return $model;
    }
}