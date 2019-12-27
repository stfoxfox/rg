<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use common\widgets\Box;
use common\widgets\DatePicker;
use backend\assets\custom\BankEditAsset;

/**
 * @var $this yii\web\View
 * @var $edit_form backend\models\forms\BankForm
 * @var $model \common\models\Bank
 */
BankEditAsset::register($this);
?>
    <div class="row">
        <div class="col-lg-4 col-md-4 animated fadeInLeft">
            <?php Box::begin(['header' => '<i class="fa fa-key"></i> Основная информация'])?>
            <?php $form = ActiveForm::begin(['id' => 'bank-form', 'class' => "m-t",
                'options' => ['enctype' => 'multipart/form-data'],
                'fieldConfig' => [
                    'template' => "{beginWrapper}\n{label}\n<hr style='margin: 0 0 10px'>\n{input}\n{hint}\n{error}\n{endWrapper}",
                ],
            ])?>
            <?=$form->field($edit_form, 'title')?>
            <?=$form->field($edit_form, 'license')?>
            <?=$form->field($edit_form, 'date_license')->widget(DatePicker::className())?>
            <?=$form->field($edit_form, 'external_id')->textInput(['readonly' => true])?>
            <?=Html::activeHiddenInput($edit_form, 'id')?>

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="form-group">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-outline btn-sm btn-primary m-t-n-xs']) ?>
                    </div>
                </div>
            </div>

            <?php ActiveForm::end()?>
            <?php Box::end()?>
        </div>

        <?php if ($model) {?>
            <div class="col-lg-8 col-md-8 animated fadeInRight">
                <?php Box::begin(['header' => '<i class="fa fa-files-o"></i> Ипотеки',
                    'headerButtons' => [[
                        'label' => '<i class="fa fa-plus"></i> Добавить',
                        'options' => [
                            'id' => 'add-mortgage',
                            'class' => 'btn btn-outline btn-xs btn-primary',
                            'data-url' => Url::to(['add-mortgage']),
                        ],
                    ]],
                    'collapseButton' => false,
                    'bodyOptions' => [
                        'id' => 'pjax_container',
                        'data-url' => Url::to(['view-grid'])
                    ]
                ])?>

                <?=Pjax::widget([
                    'id' => 'item-container',
                    'enablePushState' => false,
                    'timeout' => 3000,
                    'formSelector' => false,
                    'linkSelector' => '#mortgages-table th a, #mortgages-table ul.pagination a',
                ])?>

                <?php Box::end()?>
            </div>
        <?php }?>
    </div>
