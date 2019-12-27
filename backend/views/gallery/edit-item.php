<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use common\widgets\Box;
use backend\widgets\select2\Select2Widget;
use backend\widgets\InputFileButton;
use common\widgets\DatePicker;
use backend\assets\custom\GalleryItemEditAsset;

/**
 * @var $this yii\web\View
 * @var $edit_form backend\models\forms\GalleryItemForm
 * @var $model \common\models\GalleryItem
 */

GalleryItemEditAsset::register($this);
$img = null;
if ($model && $model->file) {
    $img = $model->file->getResize((new ReflectionClass($model))->getShortName());
}

$form = ActiveForm::begin([
    'id' => 'item-form',
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
        <?= $form->field($edit_form, 'photo_date')->widget(DatePicker::className()) ?>
        <?= $form->field($edit_form, 'complex_id')->widget(Select2Widget::className(), [
            'items' => \common\models\Complex::getList(),
            'options' => [
                'prompt' => 'выберите',
                'class' => 'form-control m-r',
                'style' => 'width: 100%',
                'data-url' => Url::to(['get-corpus-list']),
            ],
        ]) ?>
        <?= $form->field($edit_form, 'corpus_num')->widget(Select2Widget::className(), [
            'items' => \common\models\Section::getCorpusesList($edit_form->complex_id),
            'options' => [
                'prompt' => '',
                'class' => 'form-control m-r',
                'style' => 'width: 100%',
            ],
        ]) ?>
        <?php Box::end()?>
    </div>

    <div class="col-lg-7 col-md-7 animated fadeInRight">
        <?php Box::begin([
            'header' => '<i class="fa fa-picture-o"></i> Изображение',
            'fileButton' => InputFileButton::widget(['model' => $edit_form]),
            'collapseButton' => false
        ])?>

        <div class="row">
            <?=Html::activeHiddenInput($edit_form, 'x')?>
            <?=Html::activeHiddenInput($edit_form, 'y')?>
            <?=Html::activeHiddenInput($edit_form, 'w')?>
            <?=Html::activeHiddenInput($edit_form, 'h')?>
            <div class="col-lg-12 col-md-12">
                <?=Html::tag('div', Html::img($img, ['id' => 'crop_img', 'height' => 350]), ['id' => 'image-div', 'class' => 'm-t'])?>
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