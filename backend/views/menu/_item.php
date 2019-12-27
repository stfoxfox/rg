<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var $this \yii\web\View */
/** @var $item \common\models\MenuItem */

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
?>

<?=Html::beginTag('li', ['id' => 'item_id_' . $item->id, 'class' => 'dd-item', 'data-id' => $item->id, 'data-title' => $item->title])?>
<?=$del_link?>
<?=Html::tag('div', Html::tag('span', '<i class="fa fa-bars"></i> ') . $link, [
    'class' => 'dd-handle'
])?>

<?php if ($item->getChilds()->count() > 0) {?>
    <?=Html::ol($item->childs, ['item' => function($item, $index) {
        return $this->render('_item', ['item' => $item]);
    }, 'class' => 'dd-list'])?>
<?php }?>

<?=Html::endTag('li')?>