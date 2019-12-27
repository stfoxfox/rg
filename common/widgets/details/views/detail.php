<?php
use yii\helpers\Html;
use common\components\MyExtensions\MyImagePublisher;

/**
 * @var $model \common\widgets\details\forms\DetailWidgetForm
 */
$src = (new MyImagePublisher($model))->resizeInBox(800, 534, true);
?>

<div class="the_detail__container">
    <div class="the_detail">
        <?=Html::tag('div', Html::img($src, ['class' => 'the_detail__illu']), ['class' => 'the_detail__col'])?>
        <div class="the_detail__col">
            <div class="the_detail__content">
                <?=Html::tag('h3', $model->title, ['class' => 'the_detail__title title--l'])?>
                <div class="the_detail__description">
                    <?=Html::tag('p', $model->text, ['class' => 'text--m'])?>
                </div>
            </div>
        </div>
    </div>
</div>
