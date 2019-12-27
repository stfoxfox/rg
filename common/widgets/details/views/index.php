<?php
use yii\helpers\Html;

/**
 * @var $model \common\widgets\main_slider\forms\MainSliderWidgetForm
 * @var $block \common\models\PageBlock
 */
$i = 0;
?>

<section class="section section--main_details">

    <div class="section__container">
        <div class="section__content">
            <div class="main_details">
                <?=Html::tag('div', $model->title, ['class' => 'main_details__title'])?>
                <div class="main_details__actions">
                    <div class="owl-nav owl-nav--big"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="main_details__list__wrap">
        <div class="main_details__list owl-carousel js_details__carousel">
            <?php foreach ($block->childBlocks as $childBlock) {?>
                <?=Html::tag('div', $childBlock->getDataWidget(), ['class' => 'the_detail__wrap owl-detail-' . $i])?>
            <?php $i++; }?>
        </div>
    </div>

</section>