<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\widgets\Box;
use backend\widgets\select2\Select2Widget;

/**
 * @var $this yii\web\View
 * @var $edit_form backend\models\forms\GalleryForm
 */
$form = ActiveForm::begin(['id' => 'gallery-form', 'class' => "m-t",
    'options' => ['enctype' => 'multipart/form-data'],
    'fieldConfig' => [
        'template' => "{beginWrapper}\n{label}\n<hr style='margin: 0 0 10px'>\n{input}\n{hint}\n{error}\n{endWrapper}",
    ],
]);
?>
<div class="row">
    <div class="col-lg-6 col-md-6 animated fadeInRight">
        <?php Box::begin(['header' => '<i class="fa fa-key"></i> Основная информация'])?>
        <?= $form->field($edit_form, 'title') ?>
        <?= $form->field($edit_form, 'description')->textarea() ?>
        <?= $form->field($edit_form, 'type')->widget(Select2Widget::className(), [
            'items' => \common\models\Gallery::getAttributeEnums('type'),
            'options' => [
                'class' => 'form-control m-r',
                'style' => 'width: 100%',
            ],
        ]) ?>
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