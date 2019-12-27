<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\widgets\Box;
use backend\widgets\select2\Select2Widget;

/**
 * @var $this yii\web\View
 * @var $model backend\models\forms\FlatForm
 * @var $flat \common\models\Flat
 */

$form = ActiveForm::begin(['id' => 'flat-form', 'class' => "m-t",
    'options' => ['enctype' => 'multipart/form-data'],
    'fieldConfig' => [
        'template' => "{beginWrapper}\n{label}\n<hr style='margin: 0 0 10px'>\n{input}\n{hint}\n{error}\n{endWrapper}",
    ],
]);
?>

<div class="row">
    <div class="col-lg-6 col-md-6 animated fadeInLeft">
        <?php Box::begin(['header' => '<i class="fa fa-key"></i> Основная информация'])?>
            <?= $form->field($model, 'number') ?>
            <?= $form->field($model, 'number_on_floor') ?>
            <?= $form->field($model, 'type') ?>

            <?= $form->field($model, 'status')->widget(Select2Widget::className(), [
                'items' => \common\models\Flat::getAttributeEnums('status'),
                'options' => [
                    'class' => 'form-control m-r',
                    'style' => 'width: 100%',
                ],
            ]) ?>

            <?= $form->field($model, 'price') ?>
            <?= $form->field($model, 'sale_price') ?>
            <?= $form->field($model, 'total_price') ?>

            <?= $form->field($model, 'floor_id')->widget(Select2Widget::className(), [
                'items' => \common\models\Floor::getList(),
                'options' => [
                    'class' => 'form-control m-r',
                    'style' => 'width: 100%',
                ],
            ]) ?>

            <?= $form->field($model, 'floor_plan_id')->widget(Select2Widget::className(), [
                'items' => $flat->floor->getFloorPlanList(),
                'options' => [
                    'class' => 'form-control m-r',
                    'style' => 'width: 100%',
                ],
            ]) ?>

            <?= $form->field($model, 'object_id')->textInput(['readonly' => true]) ?>
            <?= $form->field($model, 'external_id')->textInput(['readonly' => true]) ?>
        <?php Box::end()?>
    </div>

    <div class="col-lg-6 col-md-6 animated fadeInRight">
        <?php Box::begin(['header' => 'Дополнительная'])?>
            <?= $form->field($model, 'rooms_count') ?>
            <?= $form->field($model, 'currency') ?>

            <?= $form->field($model, 'total_area') ?>
            <?= $form->field($model, 'live_area') ?>
            <?= $form->field($model, 'kitchen_area') ?>

            <?= $form->field($model, 'garage') ?>
            <?= $form->field($model, 'furniture') ?>
            <?= $form->field($model, 'binding') ?>
            <?= $form->field($model, 'decoration') ?>
            <?= $form->field($model, 'features') ?>
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

<?php ActiveForm::end(); ?>
