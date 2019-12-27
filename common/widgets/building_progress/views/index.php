<?php
use yii\helpers\Html;

/**
 * @var $model \common\widgets\building_progress\forms\BuildingProgressWidgetForm;
 * @var $block \common\models\PageBlock
 */
?>

<section class="section">
    <div class="section__container">
        <div class="section__content">
            <div class="construction_progress_photo__wrap">
                <?=Html::tag('h1', $model->title, ['class' => 'title--xxl'])?>
                <div class="construction_progress_photo construction_progress_photo--four">

                    <div class="row p-14">
                        <?php foreach ($block->childBlocks as $childBlock) :?>
                            <?php $childBlockWidget = $childBlock->getWidgetClass()?>
                            <div class="col-3">
                                <figure class="construction_progress_photo__item">
                                    <?=Html::img($childBlock->getDataWidget(), ['alt' => $childBlockWidget->params['title']])?>
                                    <?=Html::tag('figcapture', $childBlockWidget->params['title'])?>
                                </figure>
                            </div>
                        <?php endforeach?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
