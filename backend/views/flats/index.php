<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ListView;
use yii\widgets\LinkPager;
use backend\assets\custom\FlatsAsset;
use common\widgets\Box;

/**
 * @var $this \yii\web\View
 * @var $flats \yii\data\ActiveDataProvider
 * @var $corpus_title string
 * @var $corpus_url string
 */
FlatsAsset::register($this);

$buttons = [];
if ($corpus_title && $corpus_url) {
    $buttons []= [
        'label' => '<i class="fa fa-th-large"></i> Контент страницы, ' . $corpus_title,
        'url' => $corpus_url,
        'options' => [
            'class' => 'btn btn-outline btn-xs btn-success',
            'data-pjax' => 0,
        ],
    ];
}
$buttons []= [
    'label' => '<i class="fa fa-plus"></i> Добавить',
    'url' => Url::to(['add-flat']),
    'options' => [
        'class' => 'btn btn-outline btn-xs btn-primary',
        'data-pjax' => 0,
    ],
];
?>

<div class="row">
    <div class="col-lg-4 col-md-4 animated fadeInLeft">
        <?php Box::begin(['header' => '<i class="fa fa-th-list"></i> Структура комплекса'])?>
            <?=Html::tag('div', '', ['id' => 'js-tree', 'data-url' => Url::to(['get-tree'])])?>
        <?php Box::end()?>
    </div>

    <div class="col-lg-8 col-md-8 animated fadeInRight">

        <?php Pjax::begin([
            'id' => 'flats',
            'enablePushState' => false,
            'formSelector' => false,
        ])?>
        <?php Box::begin([
            'header' => '<i class="fa fa-building-o"></i> Список квартир',
            'headerButtons' => $buttons,
            'collapseButton' => false
        ])?>

            <?=Html::beginTag('ul', ['class' => 'agile-list'])?>
                <?=ListView::widget([
                    'dataProvider' => $flats,
                    'itemView' => '_flat_item',
                    'layout' => "{items}",
                    'emptyText' => Html::tag('div', 'Ничего не найдено', [
                        'class' => 'col-sm-6 col-md-4 col-lg-4'
                    ]),
                ])?>
            <?=Html::endTag('ul')?>

            <?=LinkPager::widget([
                'pagination' => $flats->pagination,
            ])?>

        <?php Box::end()?>
        <?php Pjax::end()?>
    </div>
</div>