<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\widgets\Box;
use backend\assets\custom\MenuItemAsset;

/**
 * @var $this yii\web\View
 * @var $menu \common\models\Menu
 */
MenuItemAsset::register($this);
$items = $menu->menuItemRoots;
?>

<div class="row">
    <div class="col-lg-4 col-md-4 animated fadeInLeft">
        <?php Box::begin(['header' => '<i class="fa fa-th-list"></i> Список', 'headerButtons' => [
            [
                'label' => '<i class="fa fa-plus"></i> Добавить',
                'options' => [
                    'id' => 'add-item',
                    'class' => 'btn btn-outline btn-xs btn-primary',
                    'data-menu' => $menu->id,
                    'data-url' => Url::to(['add-item']),
                ],
            ],
            ['options' => ['id' => 'switchNestable', 'class' => 'btn btn-outline btn-xs']]
        ], 'collapseButton' => false])?>
            <?=Html::beginTag('div', ['id' => 'nestable', 'class' => 'dd', 'data-url' => Url::toRoute(['nestable-items']), 'data-menu' => $menu->id])?>
                <?=Html::ol($items, ['item' => function($item, $index) {
                    return $this->render('_item', ['item' => $item]);
                },
                    'id' => 'folder_list',
                    'class' => 'dd-list',
                ])?>
            <?=Html::endTag('div')?>
        <?php Box::end()?>
    </div>

    <div class="col-lg-8 col-md-8 animated fadeInRight">
        <?php Box::begin(['header' => '', 'bodyOptions' => [
            'id' => 'pjax_container',
            'data-url' => Url::to(['view-item'])
        ]])?>
        <?=Pjax::widget([
            'id' => 'item-container',
            'enablePushState' => false,
            'formSelector' => false,
            'linkSelector' => false,
        ])?>
        <?php Box::end()?>
    </div>

</div>



