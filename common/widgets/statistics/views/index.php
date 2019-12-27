<?php
use yii\helpers\Html;

/**
 * @var $this \yii\web\View
 * @var $model \common\widgets\statistics\forms\StatisticsWidgetForm
 * @var $block \common\models\PageBlock
 * @var $childBlock \common\models\PageBlock
 */
?>

<?=Html::beginTag('article', [
    'id' => ($block->page->show_anchors && $model->anchor) ? $model->anchor : ''
])?>
    <!--Вывод простых текстовых блоков-->
    <?php foreach ($block->getChildBlocksByType(12)->all() as $childBlock) {
        echo $childBlock->getDataWidget();
    }?>

    <!--Вывод элементов статистики-->
    <div class="row p-14">
        <?php foreach ($block->getChildBlocksByType(25)->all() as $childBlock) {
            echo $childBlock->getDataWidget();
        }?>
    </div>
<?=Html::endTag('article')?>