<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\widgets\Box;
use backend\widgets\select2\Select2Widget;
use backend\widgets\InputFileButton;
use common\models\Section;
use backend\assets\custom\FloorPlanEditAsset;

/**
 * @var $this yii\web\View
 * @var $edit_form backend\models\forms\FloorPlanForm
 * @var $model \common\models\FloorPlan
 * @var $complex_id integer
 */

FloorPlanEditAsset::register($this);
$sections = ($model && $model->corpus_num)
    ? Section::getSectionsNumList($complex_id, $model->corpus_num) : [];

$img = null;
if ($model && $model->file) {
    $img = $model->file->getResize((new ReflectionClass($model))->getShortName());
}

$form = ActiveForm::begin([
    'id' => 'plan-form',
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
            <div class="row">

            <div class="col-lg-12 col-md-12">
                <?=$form->field($edit_form, 'corpus_num')->widget(Select2Widget::className(), [
                    'items' => Section::getCorpusesList($complex_id),
                    'options' => [
                        'class' => 'form-control m-r',
                        'style' => 'width: 100%',
                        'prompt' => 'Корпус',
                        'data-url' => \yii\helpers\Url::to(['change-corpus']),
                    ],
                ])?>
            </div>

            <div class="col-lg-12 col-md-12">
                <?=$form->field($edit_form, 'section_num')->widget(Select2Widget::className(), [
                    'items' => $sections,
                    'options' => [
                        'class' => 'form-control m-r',
                        'style' => 'width: 100%',
                        'prompt' => 'Секция',
                    ],
                ])?>
            </div>

            <div class="col-lg-6 col-md-6">
                <?=$form->field($edit_form, 'floor_num_starts')?>
            </div>
            <div class="col-lg-6 col-md-6">
                <?=$form->field($edit_form, 'floor_num_ends')?>
            </div>
            <div class="col-lg-6 col-md-6">
                <?=$form->field($edit_form, 'number_on_floor')?>
            </div>

            <div class="col-lg-12 col-md-12">
                <?=$form->field($edit_form, 'external_id')->textInput(['readonly' => true])?>
            </div>

                <?=Html::activeHiddenInput($edit_form, 'complex_id')?>
            </div>
            <?php Box::end()?>
        </div>

        <div class="col-lg-7 col-md-7 animated fadeInRight">
            <?php Box::begin([
                'header' => '<i class="fa fa-map-o"></i> Планировка',
                'fileButton' => InputFileButton::widget(['model' => $edit_form]),
                'collapseButton' => false
            ])?>

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <?=Html::tag('div', Html::img($img, ['id' => 'crop_img', 'height' => 387]), ['id' => 'image-div', 'class' => 'm-t'])?>
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