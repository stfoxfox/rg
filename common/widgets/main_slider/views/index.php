<?php
use yii\helpers\Html;

/**
 * @var $model \common\widgets\main_slider\forms\MainSliderWidgetForm
 * @var $block \common\models\PageBlock
 */
$i = 1;
?>

<section class="promo section section--promo">
    <div class="promo__carousel owl-carousel js_promo__carousel">
        <?php foreach($block->childBlocks as $childBlock) :?>
            <?=Html::beginTag('div', [
                'class' => 'promo__item',
                'style' => "background-image:url('{$childBlock->getDataWidget()}')"
            ])?>

            <?php if ($i == 1) {?>
            <div class="section__container">
                <div class="section__content">
                    <div class="promo__content">
                        <?=Html::tag('div', $model->title, ['class' => 'promo__title'])?>
                        <?=Html::tag('div', $model->sub_title, ['class' => 'promo__subtitle title--xl'])?>
                        <div class="promo__choose">
                            <div class="row">
                                <div class="col-2">
                                    <?=Html::a(Html::tag('span', 'Выбрать квартиру', ['class' => 'btn__label']), ['/flats'], ['class' => 'btn btn--main'])?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if ($model->promo_title || $model->promo_text) { ?>
                    <div class="countdown_main">
                        <svg class="countdown_main__svg" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 285 285">
                            <defs>
                                <linearGradient id="countdown_main__gradient--1" x1="0" y1="80%" x2="100%" y2="20%">
                                    <stop offset="0%" stop-color="rgba(255,121,0,0.7)"></stop>
                                    <stop offset="85%" stop-color="rgba(255,121,0, 0)"></stop>
                                </linearGradient>
                                <linearGradient id="countdown_main__gradient--2" x1="50%" y1="0%" x2="50%" y2="100%">
                                    <stop offset="0%" stop-color="rgba(255,121,0, 1)"></stop>
                                    <stop offset="100%" stop-color="rgba(255,121,0, 0)"></stop>
                                </linearGradient>
                                <linearGradient id="countdown_main__gradient--3" x1="0" y1="50%" x2="100%" y2="50%">
                                    <stop offset="55%" stop-color="rgba(255,121,0, 1)"></stop>
                                    <stop offset="62%" stop-color="rgba(255,121,0, 0.8)"></stop>
                                    <stop offset="70%" stop-color="rgba(255,121,0, 0)"></stop>
                                </linearGradient>
                            </defs>
                            <g class="countdown_main__g">
                                <circle class="countdown_main__circle circle-0" r="132" cx="50%" cy="50%"></circle>
                                <circle class="countdown_main__circle circle-1" r="132" cx="50%" cy="50%"></circle>
                                <circle class="countdown_main__circle circle-2" r="132" cx="50%" cy="50%"></circle>
                            </g>
                        </svg>

                        <?=Html::tag('span', '<b>' . $model->promo_title . '</b>' . $model->promo_text, [
                            'class' => 'countdown_main__value'
                        ])?>
                    </div>
                    <?php } ?>
                </div>
            </div>

            <?php } else {?>
                <?=Html::tag('slide' . $i, '')?>
            <?php }?>

            <?=Html::endTag('div')?>
            <?php $i++?>
        <?php endforeach?>

    </div>

    <div class="promo__carousel__actions">
        <div class="section__container">
            <div class="promo__carousel__actions__nav">
                <div class="owl-nav"></div>
            </div>
            <div class="promo__carousel__actions__dots">
                <div class="owl-dots"></div>
            </div>
            <div class="promo__carousel__actions__counter"></div>
        </div>
    </div>

</section>