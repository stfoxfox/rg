<?php
use yii\helpers\Html;

/**
 * @var $this \yii\web\View
 * @var $model \common\widgets\statistics\forms\StatisticsEntryWidgetForm
 */

/**
 * TODO:
 * нужно унифицировать классы, а не так как сейчас - под конкретную страницу
 * теги в тексте вида <br class="m--hide"> - убрать нахрен
 *
 * <span class="about_block_level__value">11</span>
 * <span class="about_block_level__caption">более 11 лет стабильного <br class="m--hide">роста бизнеса</span>
 */
?>

<div class="col-4">
    <div class="about_block_level">
        <?=Html::tag('span', $model->title, ['class' => 'about_block_level__value'])?>
        <?=Html::tag('span', $model->text, ['class' => 'about_block_level__caption'])?>
    </div>
</div>
