<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\widgets\Box;

/**
 * @var $this yii\web\View
 * @var $edit_form backend\models\forms\MortgageForm
 */
$form = ActiveForm::begin(['id' => 'mortgage-form', 'class' => "m-t",
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
                <?=$form->field($edit_form, 'min_cash')?>
            </div>
            <div class="col-lg-6 col-md-6">
                <?=$form->field($edit_form, 'percent_rate')?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <?=$form->field($edit_form, 'max_period')?>
            </div>
            <div class="col-lg-6 col-md-6">
                <?=$form->field($edit_form, 'max_amount')?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <?=$form->field($edit_form, 'is_priority')->checkbox()?>
            </div>
            <div class="col-lg-6 col-md-6">
                <?=$form->field($edit_form, 'is_military')->checkbox()?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <?=$form->field($edit_form, 'external_id')->textInput(['readonly' => true])?>
            </div>
        </div>

        <?=Html::activeHiddenInput($edit_form, 'bank_id')?>

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