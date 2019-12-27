<?php
use yii\helpers\Html;
use common\components\MyExtensions\MyImagePublisher;

/**
 * @var $model \common\widgets\gallery\forms\GalleryWidgetForm
 * @var $images \common\models\File[]
 */
$path = 'GalleryItem';
?>

<section class="section">
    <div class="main_photos">

        <div class="main_photos__title">
            <div class="section__container">
                <div class="section__content">
                    <?=Html::tag('div', $model->title, ['class' => 'h1 title--xxl'])?>
                </div>
            </div>
        </div>

        <?=Html::beginTag('div', [
            'class' => 'main_photos__carousel owl-carousel js_photos__carousel',
            'data-slider-id' => $model->page_id,
        ])?>
        <?php foreach ($images as $image) :?>
            <?=Html::tag('div', '', [
                'class' => 'main_photos__item',
                'style' => "background-image:url('" . (new MyImagePublisher($image))->MyThumbnail(2000, 1335, 'file_name', $path) . "')"
            ])?>
        <?php endforeach?>
        <?=Html::endTag('div')?>

        <div class="main_photos__actions">
            <div class="section__container">
                <div class="section__content">

                    <div class="main_photos__nav">
                        <div class="owl-nav"></div>
                    </div>

                    <?=Html::beginTag('div', [
                        'class' => 'main_photos__thumbs owl-thumbs',
                        'data-slider-id' => $model->page_id,
                    ])?>
                    <?php foreach ($images as $image) :?>
                        <?=Html::tag('div', '', [
                            'class' => 'main_photos__thumb owl-thumb',
                            'style' => "background-image:url('" . (new MyImagePublisher($image))->MyThumbnail(100, 100, 'file_name', $path) . "')"
                        ])?>
                    <?php endforeach?>
                    <?=Html::endTag('div')?>

                </div>
            </div>
        </div>

    </div>
</section>