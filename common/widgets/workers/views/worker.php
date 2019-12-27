<?php
use yii\helpers\Html;
use common\components\MyExtensions\MyImagePublisher;

/**
 * @var $this \yii\web\View
 * @var $model \common\widgets\workers\forms\WorkerWidgetForm;
 */

$src = (new MyImagePublisher($model))->resizeInBox(365, 365);
?>

<div class="col-6">
    <div class="about_profile_leader">
        <div class="about_profile_leader__item">
            <div class="about_profile_leader__avatar">
                <?=Html::img($src, ['alt' => $model->fio])?>
            </div>
        </div>
        <div class="about_profile_leader__item">
            <div class="about_profile_leader__info">
                <?=Html::tag('div', $model->fio, ['class' => 'about_profile_leader__name'])?>
                <?=Html::tag('div', $model->duty, ['class' => 'about_profile_leader__position'])?>
            </div>
        </div>
    </div>
</div>