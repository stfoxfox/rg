<?php
use yii\helpers\Html;

/**
 * @var $this \yii\web\View
 * @var $model \common\widgets\text\forms\TextContainerWidgetForm
 * @var $block \common\models\PageBlock
 * @var $childBlock \common\models\PageBlock
 */
?>

<?=Html::beginTag('article', [
    'id' => ($block->page->show_anchors && $model->anchor) ? $model->anchor : ''
])?>
    <?=Html::tag('h1', $model->title, ['class' => 'title--xxl'])?>
    <div class="row p-14">

        <div class="col-4">
            <?php foreach ($block->childBlocks as $childBlock) {
                /** @var stdClass $params */
                $params = $childBlock->getDataParams();
                if ($params && $params->column_num == 1) {
                    echo $childBlock->getDataWidget();
                }
            }?>
        </div>

        <div class="col-4">
            <?php foreach ($block->childBlocks as $childBlock) {
                /** @var stdClass $params */
                $params = $childBlock->getDataParams();
                if ($params && $params->column_num == 2) {
                    echo $childBlock->getDataWidget();
                }
            }?>
        </div>

        <div class="col-4">
            <?php foreach ($block->childBlocks as $childBlock) {
                /** @var stdClass $params */
                $params = $childBlock->getDataParams();
                if ($params && $params->column_num == 3) {
                    echo $childBlock->getDataWidget();
                }
            }?>
        </div>

    </div>
<?=Html::endTag('article')?>