<?php
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \common\models\Flat $model
 */
?>

<?=Html::beginTag('li', ['class' => $model->getStatusLabelClass()])?>

Кваритра № <?=$model->number?>, Корпус <?=$model->section->corpus_num?>, Секция № <?=$model->section->number?>, Этаж <?=$model->floor->number?>,
 <u><?=Yii::$app->formatter->asDecimal($model->total_area)?> кв.м - <?=Yii::$app->formatter->asCurrency($model->price)?></u>
<div class="agile-detail">
    <div class="pull-right btn-group">
        <?=Html::a('<i class="fa fa-pencil"></i> Редактировать', ['edit-flat', 'id' => $model->id], ['data-pjax' => 0, 'class' => 'btn btn-xs btn-outline btn-success'])?>
        <?=Html::a('<i class="fa fa-close"></i>', 'javascript:void(0)', [
            'data-pjax' => 0,
            'class' => 'btn btn-xs btn-outline btn-danger flat-delete',
            'data-id' => $model->id,
            'data-name' => 'Кваритра №' . $model->number,
            'data-url' => Url::to(['delete-flat'])
        ])?>
    </div>

    <i class="fa fa-clock-o"></i> <?=Yii::$app->formatter->asDate($model->created_at)?>
</div>

<?=Html::endTag('li')?>
