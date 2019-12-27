<?php
use yii\helpers\Html;

/**
 * @var $model \common\widgets\map\forms\MapWidgetForm
 */
?>

<section class="section">
    <div class="section__container">
        <div class="section__content">
            <div class="map_main">
                <?=Html::tag('div', $model->title, ['class' => 'h1 title--xxl'])?>
                <div class="map_main__content" id="mapmain"></div>
            </div>
        </div>
    </div>
</section>