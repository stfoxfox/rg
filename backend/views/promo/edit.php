<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\widgets\Box;
use backend\widgets\select2\Select2Widget;
use backend\widgets\InputFileButton;
use common\widgets\DatePicker;
use yii\widgets\MaskedInput;
use backend\assets\custom\PromoEditAsset;

/**
 * @var $this yii\web\View
 * @var $edit_form backend\models\forms\PromoForm
 * @var $model \common\models\Promo
 */

PromoEditAsset::register($this);
$img = null;
if ($model && $model->file) {
    $img = $model->file->getResize((new ReflectionClass($model))->getShortName());
}

$ava = null;
if ($model && $model->avatar) {
    $ava = $model->avatar->getResize((new ReflectionClass($model))->getShortName());
}

$buttons = [];
if ($model && $model->page) {
    $buttons []= [
        'label' => '<i class="fa fa-th-large"></i> Контент страницы, ' . $model->title,
        'url' => \yii\helpers\Url::to(['/page/blocks', 'id' => $model->page->id]),
        'options' => [
            'class' => 'btn btn-outline btn-xs btn-success',
            'data-pjax' => 0,
        ],
    ];
}

$form = ActiveForm::begin([
    'id' => 'promo-form',
    'class' => "m-t",
    'options' => ['enctype' => 'multipart/form-data'],
    'fieldConfig' => [
        'template' => "{beginWrapper}\n{label}\n<hr style='margin: 0 0 10px'>\n{input}\n{hint}\n{error}\n{endWrapper}",
    ],
]);
?>

    <div class="row">
        <div class="col-lg-6 col-md-6 animated fadeInLeft">
            <?php Box::begin([
                'header' => '<i class="fa fa-key"></i> Основная информация',
                'headerButtons' => $buttons,
                'collapseButton' => false
            ])?>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <?=$form->field($edit_form, 'title')?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <?=$form->field($edit_form, 'status')->widget(Select2Widget::className(), [
                        'items' => \common\models\Promo::getAttributeEnums('status'),
                        'options' => [
                            'class' => 'form-control m-r',
                            'style' => 'width: 100%',
                        ],
                    ])?>
                </div>
                <div class="col-lg-6 col-md-6">
                    <?=$form->field($edit_form, 'type')->widget(Select2Widget::className(), [
                        'items' => \common\models\Promo::getAttributeEnums('type'),
                        'options' => [
                            'class' => 'form-control m-r',
                            'style' => 'width: 100%',
                        ],
                    ])?>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <?=$form->field($edit_form, 'date_to')->widget(DatePicker::className())?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <?=$form->field($edit_form, 'description')->textarea()?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <?=$form->field($edit_form, 'manager')?>
                </div>
                <div class="col-lg-6 col-md-6">
                    <?=$form->field($edit_form, 'manager_phone', [
                        'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon"><i class="fa fa-phone-square"></i></span></div>'
                    ])->widget(MaskedInput::className(), [
                        'mask' => '+7 999 999-99-99',
                        'clientOptions' => [
                            'clearIncomplete' => true
                        ]
                    ])?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <?=$form->field($edit_form, 'button_text')?>
                </div>
                <div class="col-lg-6 col-md-6">
                    <?=$form->field($edit_form, 'button_link', [
                        'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon"><i class="fa fa-globe"></i></span></div>'
                    ])?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <?=$form->field($edit_form, 'external_id')->textInput(['readonly' => true])?>
                </div>
            </div>
            <?php Box::end()?>
        </div>

        <div class="col-lg-6 col-md-6 animated fadeInRight">
            <?php Box::begin([
                'header' => '<i class="fa fa-picture-o"></i> Изображение',
                'fileButton' => InputFileButton::widget(['model' => $edit_form]),
                //'fileButton' => $form->field($edit_form, 'file')->widget(InputFileButton::className())->label(false),
                'collapseButton' => false
            ])?>

            <div class="row">
                <?=Html::activeHiddenInput($edit_form, 'x')?>
                <?=Html::activeHiddenInput($edit_form, 'y')?>
                <?=Html::activeHiddenInput($edit_form, 'w')?>
                <?=Html::activeHiddenInput($edit_form, 'h')?>
                <div class="col-lg-12 col-md-12">
                    <?=Html::tag('div', Html::img($img, ['id' => 'crop_img', 'height' => 300]), ['id' => 'image-div', 'class' => 'm-t'])?>
                </div>
            </div>

            <?php Box::end()?>

            <?php Box::begin([
                'header' => '<i class="fa fa-picture-o"></i> Аватар менеджера',
                'fileButton' => InputFileButton::widget(['model' => $edit_form, 'attribute' => 'avatar']),
                'collapseButton' => false
            ])?>

            <div class="row">
                <?=Html::activeHiddenInput($edit_form, 'x1')?>
                <?=Html::activeHiddenInput($edit_form, 'y1')?>
                <?=Html::activeHiddenInput($edit_form, 'w1')?>
                <?=Html::activeHiddenInput($edit_form, 'h1')?>
                <div class="col-lg-12 col-md-12">
                    <?=Html::tag('div', Html::img($ava, ['id' => 'crop_img1', 'height' => 180]), ['id' => 'image-div1', 'class' => 'm-t'])?>
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