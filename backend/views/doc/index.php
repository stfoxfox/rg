<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\widgets\Box;
use backend\assets\custom\DocAsset;

/**
 * @var $this yii\web\View
 * @var $categories \common\models\DocCategory[]
 */
DocAsset::register($this);
?>

<div class="row">
    <div class="col-lg-4 col-md-4 animated fadeInLeft">
        <?php Box::begin(['header' => '<i class="fa fa-th-list"></i> Категории', 'headerButtons' => [
            [
                'label' => '<i class="fa fa-plus"></i> Добавить',
                'options' => [
                    'id' => 'add-doc-category',
                    'class' => 'btn btn-outline btn-xs btn-primary',
                    'data-url' => Url::to(['add-doc-category']),
                ],
            ],
        ], 'collapseButton' => false])?>
        <?=Html::beginTag('div', ['id' => 'sortable-category', 'class' => 'dd',
            'data-url' => Url::to(['sort-items']),
            'data-table' => \common\models\DocCategory::tableName(),
        ])?>
        <?=Html::ol($categories, ['item' => function($category) {
            return $this->render('_item', ['item' => $category]);
        },
            'class' => 'dd-list',
        ])?>
        <?=Html::endTag('div')?>
        <?php Box::end()?>
    </div>

    <div class="col-lg-8 col-md-8 animated fadeInRight">
        <?php Box::begin(['header' => '', 'headerButtons' => [[
                'label' => '<i class="fa fa-plus"></i> Добавить документ',
                'options' => [
                    'id' => 'add-doc', 'data-id' => '',
                    'class' => 'btn btn-outline btn-xs btn-primary',
                    'data-url' => Url::to(['add-doc-redirect']),
                ],
            ]],
            'bodyOptions' => [
                'id' => 'pjax_container',
                'data-url' => Url::to(['view-doc-grid'])
        ], 'collapseButton' => false])?>
        <?=Pjax::widget([
            'id' => 'doc-container',
            'enablePushState' => false,
            'formSelector' => false,
            'linkSelector' => 'ul.pagination a, th a',
        ])?>
        <?php Box::end()?>
    </div>

</div>



