<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\widgets\select2\Select2Widget;

/**
 * @var $this yii\web\View
 * @var $edit_form backend\models\forms\MenuItemForm
 */

$form = ActiveForm::begin([
    'id' => 'item-form',
    'class' => "m-t",
    'action' => \yii\helpers\Url::to(['edit-item']),
    'options' => [
        'enctype' => 'multipart/form-data',
    ],
    'fieldConfig' => [
        'template' => "{beginWrapper}\n{label}\n<hr style='margin: 0 0 10px'>\n{input}\n{hint}\n{error}\n{endWrapper}",
    ],
]);
?>

<div class="row">
    <div class="col-lg-8 col-md-8">
        <?=$form->field($edit_form, 'title')?>
    </div>
    <div class="col-lg-4 col-md-4">
        <?=$form->field($edit_form, 'status')->widget(Select2Widget::className(), [
            'items' => \common\models\MenuItem::getAttributeEnums('status'),
            'options' => [
                'class' => 'form-control m-r',
                'style' => 'width: 100%',
            ],
        ])?>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <?=$form->field($edit_form, 'url', [
            'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon"><i class="fa fa-globe"></i></span></div>'
        ])?>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-md-6">
        <?=$form->field($edit_form, 'controller')->widget(Select2Widget::className(), [
            'items' => \common\models\MenuItem::getControllersList(),
            'options' => [
                'prompt' => 'выберите',
                'style' => 'width: 100%',
            ],
        ])?>
    </div>
    <div class="col-lg-6 col-md-6">
        <?php if ($edit_form->controller) {
            echo $form->field($edit_form, 'action')->widget(Select2Widget::className(), [
                'items' => \common\models\MenuItem::getActionsList($edit_form->controller),
                'options' => [
                    'prompt' => 'выберите',
                    'style' => 'width: 100%',
                ],
            ]);
        }?>
    </div>
</div>

<div class="row">
    <?php if (!empty($edit_form->params)) {
        echo Html::beginTag('div', ['class' => 'col-md-12 col-lg-12']);
        echo Html::beginTag('fieldset', ['id' => 'json_params']);
        echo Html::tag('legend', '<i class="fa fa-cog"></i> Параметры');

        foreach ($edit_form->params as $id => $param) {
            echo Html::beginTag('div', ['class' => 'col-md-6 col-lg-6']);
            echo $form->field($edit_form, 'json_params[' . $id . ']', [
//                'wrapperOptions' => [
//                    'class' => 'col-md-6 col-lg-6',
//                ],
            ])->widget(Select2Widget::className(), [
                'items' => $edit_form->getParamList($param),
                'options' => [
                    'prompt' => 'выберите',
                    'style' => 'width: 100%',
                ],
            ])->label($param['name']);
            echo Html::endTag('div');
        }

        echo Html::endTag('fieldset');
        echo Html::endTag('div');
    }?>
</div>

<?=Html::activeHiddenInput($edit_form, 'id')?>

<div class="row m-t">
    <div class="col-lg-12 col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-outline btn-sm btn-primary m-t-n-xs']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end()?>