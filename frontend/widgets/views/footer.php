<?php
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var \common\models\MenuItem[] $items
 */
?>

<div class="footer__col">
    <?=Html::ul($items, ['item' => function($item, $index) {
        /** @var \common\models\MenuItem $item */
        return Html::tag('li', Html::a($item->icon . ' ' . $item->title, $item->fullUrl, ['class' => 'navigation__item']));
    }, 'class' => 'footer__nav']
    )?>
</div>
