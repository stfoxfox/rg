<?php
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var array $provider
 * @var integer $possible_parent_id
 * @var \common\models\Page $page
 */
?>

<button data-toggle="dropdown" class="btn btn-sm btn-success m-t-n-xs dropdown-toggle" aria-expanded="false">Добавить блок <span class="caret"></span></button>
<ul class="dropdown-menu">
    <?php foreach ($provider as $key => $type) { $class = $type['widgetClass']; ?>
        <li>
            <?=Html::a($class::getBlockName(), 'javascript:void(0)', [
                'class' => 'add-block',
                'data-item-id' => $page->id,
                'data-block-type' => $key,
                'data-parent-id' => $possible_parent_id,
                'data-url' => Url::to(['/page/get-widget']),
            ])?>
        </li>
    <?php }?>
</ul>
