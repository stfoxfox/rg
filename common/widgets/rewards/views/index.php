<?php
use yii\helpers\Html;

/**
 * @var $this \yii\web\View
 * @var $model \common\widgets\statistics\forms\StatisticsWidgetForm
 * @var $block \common\models\PageBlock
 */
?>

<?=Html::beginTag('article', [
    'id' => ($block->page->show_anchors && $model->anchor) ? $model->anchor : ''
])?>
    <?=Html::tag('h1', $model->title, ['class' => 'title--xxl'])?>

    <div class="about_block_awards">
        <div class="row p-14">
            <?php foreach ($block->childBlocks as $childBlock) :?>

                <div class="col-2">
                    <div class="about_block_awards__container">
                        <div class="about_block_awards__link">
                            <?=$childBlock->getDataWidget()?>
                        </div>
                    </div>
                </div>

            <?php endforeach?>
        </div>
    </div>
<?=Html::endTag('article')?>