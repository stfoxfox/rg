<?php
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var \common\models\MenuItem[] $items
 */
?>

<nav class="navigation">
    <?php foreach ($items as $menuItem) {
        echo Html::a($menuItem->icon . ' ' . $menuItem->title, $menuItem->fullUrl, ['class' => 'navigation__item']);
    }?>
</nav>
