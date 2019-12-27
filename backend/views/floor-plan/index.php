<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use common\widgets\Box;
use backend\assets\custom\FloorPlanAsset;
use backend\widgets\InputFileButton;

/**
 * @var $this \yii\web\View
 * @var $import_form \backend\models\forms\FloorPlanImportForm
 */
FloorPlanAsset::register($this);
$form = ActiveForm::begin([
    'id' => 'import-form',
    'options' => [
        'enctype' => 'multipart/form-data',
        'data-url' => Url::to(['import']),
    ]
]);
?>

<div class="row">
    <div class="col-lg-10 col-md-10 col-lg-offset-1 col-md-offset-1 animated fadeInRight">
        <?php Box::begin([
            'header' => '<i class="fa fa-th-list"></i> Список',
            'headerButtons' => [[
                'label' => '<i class="fa fa-plus"></i> Добавить',
                'url' => Url::to(['add-plan']),
                'options' => ['class' => 'btn btn-outline btn-xs btn-primary']
            ]],
            'fileButton' => InputFileButton::widget(['model' => $import_form, 'title' => 'Архив для импорта', 'options' => [
                //'accept' => 'application/zip, application/gzip, application/x-rar-compressed, application/x-tar',
                'accept' => 'application/zip',
                'class' => "hide",
            ]]),
            'collapseButton' => false
        ])?>

        <?=Html::beginTag('div', ['id' => 'pjax_container', 'data-url' => Url::to(['list'])])?>
        <?=Pjax::widget([
            'id' => 'plan-container',
            'enablePushState' => false,
            'timeout' => 15000,
            'formSelector' => false,
            'linkSelector' => 'ul.pagination a, th a',
        ])?>
        <?=Html::endTag('div')?>

        <?php Box::end()?>
    </div>
</div>

<?=Html::activeHiddenInput($import_form, 'complex_id')?>
<?php ActiveForm::end()?>