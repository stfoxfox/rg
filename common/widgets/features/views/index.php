<?php
use yii\helpers\Html;
use common\components\MyExtensions\MyImagePublisher;
use common\widgets\features\forms\FeatureWidgetForm;

/**
 * @var $this \yii\web\View
 * @var $model \common\widgets\features\forms\FeaturesContainerWidgetForm
 * @var $block \common\models\PageBlock
 * @var $childBlock \common\models\PageBlock
 */

$first_block = $block->childBlocks[0];
$first_block_widget = $first_block->getWidgetClass();
$img_src = (new MyImagePublisher(new FeatureWidgetForm([
    'page_id' => $first_block_widget->params['page_id'],
    'widget_name' => basename($first_block_widget->className()),
    'file_name' => $first_block_widget->params['file_name']
])))->resizeInBox(1360, 700);
?>

<section class="section">
    <div class="flat_features">
        <div class="section__container">
            <div class="section__content">
                <?=Html::tag('h1', $model->title, ['class' => 'flat_features__title h1 title--xxl'])?>
            </div>
        </div>
        <?=Html::beginTag('div', [
            'class' => 'flat_features__container js_flat_features__container',
            'style' => "background-image: url('{$img_src}')"
        ])?>
            <div class="section__container">
                <div class="section__content">
                    <div class="row">

                        <div class="col-6">
                            <nav class="flat_features__nav js_flat_features__nav">
                                <?php $i = 0?>
                                <?php foreach ($block->childBlocks as $childBlock) {
                                    $childBlockWidget = $childBlock->getWidgetClass();
                                    echo Html::tag('div', Html::a($childBlockWidget->params['title'], '#'), [
                                        'class' => ($i == 0) ? 'flat_features__nav_item flat_features__nav_item--active'
                                            : 'flat_features__nav_item'
                                    ]);
                                    $i ++;
                                }?>
                            </nav>
                        </div>

                        <div class="col-6">
                            <div class="flat_features__content">
                                <div class="flat_features__list js_flat_features__list">
                                    <?php $i = 0?>
                                    <?php foreach ($block->childBlocks as $childBlock) {
                                        $childBlockWidget = $childBlock->getWidgetClass();
                                        echo Html::beginTag('div', [
                                            'class' => ($i == 0) ? 'flat_features__item flat_features__item--active' : 'flat_features__item',
                                            'data-bg' => (new MyImagePublisher(new FeatureWidgetForm([
                                                'page_id' => $childBlockWidget->params['page_id'],
                                                'widget_name' => basename($childBlockWidget->className()),
                                                'file_name' => $childBlockWidget->params['file_name']
                                            ])))->resizeInBox(1360, 700)
                                        ]);
                                        echo $childBlock->getDataWidget();
                                        echo Html::endTag('div');
                                        $i ++;
                                    }?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        <?=Html::endTag('div')?>
    </div>
</section>