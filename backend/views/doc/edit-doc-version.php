<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\widgets\Box;
use backend\widgets\InputFileButton;
use common\widgets\DatePicker;
use backend\assets\custom\DocVersionEditAsset;

/**
 * @var $this yii\web\View
 * @var $edit_form backend\models\forms\DocVersionForm
 * @var $model \common\models\DocVersion
 */

DocVersionEditAsset::register($this);

$img = false;
$src = '';
$content = '';
if ($model && $model->file) {
    $src = $model->file->getOriginal((new ReflectionClass($model))->getShortName());
    $content = $model->file->getResize((new ReflectionClass($model))->getShortName());
    if ($model->file->is_img) {
        $img = true;
        $content = '';
    }
}

$version = '';
if (!$model) {
    $edit_form->version = \common\models\DocVersion::getLatestVersion($edit_form->doc_id);
    $version = $edit_form->version;
}

$form = ActiveForm::begin([
    'id' => 'version-form',
    'class' => "m-t",
    'options' => ['enctype' => 'multipart/form-data'],
    'fieldConfig' => [
        'template' => "{beginWrapper}\n{label}\n<hr style='margin: 0 0 10px'>\n{input}\n{hint}\n{error}\n{endWrapper}",
    ],
]);
?>

<div class="row">
    <div class="col-lg-5 col-md-5 animated fadeInLeft">
        <?php Box::begin(['header' => '<i class="fa fa-key"></i> Основная информация'])?>

        <?=$form->field($edit_form, 'version')->textInput(['placeholder' => $version])?>
        <?=$form->field($edit_form, 'doc_date')->widget(DatePicker::className())?>

        <?=Html::activeHiddenInput($edit_form, 'doc_id')?>

        <?php Box::end()?>

    </div>

    <div class="col-lg-7 col-md-7 animated fadeInRight">
        <?php Box::begin(['header' => '<i class="fa fa-file"></i> Файл',
            'fileButton' => InputFileButton::widget([
                'model' => $edit_form,
                'options' => ['accept' => 'image/*, application/pdf, application/msword', 'class' => "hide"],
            ]),
            'collapseButton' => false
        ])?>

        <div class="row">
            <?=Html::activeHiddenInput($edit_form, 'x')?>
            <?=Html::activeHiddenInput($edit_form, 'y')?>
            <?=Html::activeHiddenInput($edit_form, 'w')?>
            <?=Html::activeHiddenInput($edit_form, 'h')?>
            <div id="preview" class="col-lg-12 col-md-12">
                <?=Html::tag('div', Html::img($img ? $src : '', ['id' => 'crop_img', 'height' => 375]), ['id' => 'image-div', 'class' => 'm-t'])?>
                <?=Html::tag('div', $content, ['id' => 'content'])?>
                <?php if (!$img && $src) {
                    echo '<embed src="' . $src . '" width="100%" height="375" type="' . $model->file->type . '">';
                }?>
            </div>
        </div>

        <?php Box::end()?>
    </div>

</div>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-outline btn-sm btn-primary m-t-n-xs']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end()?>