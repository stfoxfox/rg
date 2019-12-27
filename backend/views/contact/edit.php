<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\widgets\Box;

/**
 * @var $this yii\web\View
 * @var $edit_form backend\models\forms\ContactForm
 */
$form = ActiveForm::begin(['id' => 'contact-form', 'class' => "m-t",
    'options' => ['enctype' => 'multipart/form-data'],
    'fieldConfig' => [
        'template' => "{beginWrapper}\n{label}\n<hr style='margin: 0 0 10px'>\n{input}\n{hint}\n{error}\n{endWrapper}",
    ],
]);
?>

    <div class="row">
        <div class="col-lg-10 col-md-10 col-lg-offset-1 col-md-offset1 animated fadeInRight">
            <?php Box::begin(['header' => '<i class="fa fa-key"></i> Основная информация'])?>

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <?=$form->field($edit_form, 'title')?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <?=$form->field($edit_form, 'address')?>
                </div>
                <div class="col-lg-6 col-md-6">
                    <?=$form->field($edit_form, 'hours')->textarea(['rows' => 3])?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <?=$form->field($edit_form, 'phones')?>
                </div>
                <div class="col-lg-6 col-md-6">
                    <?=$form->field($edit_form, 'email')?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="form-group">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-outline btn-sm btn-primary m-t-n-xs']) ?>
                    </div>
                </div>
            </div>

            <?php Box::end()?>
        </div>
    </div>
<?php ActiveForm::end()?>