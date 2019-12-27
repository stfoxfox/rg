<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\SharedAssets\Select2Asset;

/**
 * @var \yii\web\View $this
 * @var \common\components\MyExtensions\WidgetModel $model
 * @var integer $added_id
 * @var integer $page_id
 * @var integer $parent_id
 * @var string $class_name
 * @var \common\models\PageBlock $page_block
 */

/** @var \common\components\MyExtensions\MyWidget $widget */
$widget = new $class_name;

$js = <<<JS
var select2 = $("select.select2");
if (select2.length) {
    select2.select2();
}
JS;

Select2Asset::register($this);
$this->registerJs($js);
?>

<?php if(!isset($page_block)){ ?>
<div class="ibox page_block" id="n_<?=$added_id?>">
<?php }else{ ?>
<div class="ibox page_block" id="block_<?= $page_block->id ?>" sort-id="<?= $page_block->sort ?>" data-page-block-id="<?= $page_block->id ?>">
<?php } ?>
<?php $form = ActiveForm::begin(['id' => "form_n_{$added_id}",'action' =>['save-widget'], 'class'=>"m-t",  'options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="ibox-title ui-sortable-handle">
        <?=Html::tag('h5', $widget->icon . ' ' . $widget::getBlockName())?>
        <div class="ibox-tools" style="float: right">
            <?= Html::hiddenInput('model_class_name', $model->className()); ?>
            <?= Html::hiddenInput('widget_class_name', $class_name); ?>
            <?= Html::hiddenInput('page_id', $page_id); ?>
            <?= Html::hiddenInput('parent_id', $parent_id)?>

            <?php if(isset($page_block)) echo Html::hiddenInput('page_block_id', $page_block->id); ?>
            <?= Html::submitButton('Сохранить', [
                'id' => "save_btn_{$added_id}",
                'data-block-id' => !isset($page_block)?"n_{$added_id}":"block_{$page_block->id}",
                'data-form_id' => $added_id,
                'class' => 'btn btn-outline btn-sm btn-primary m-t-n-xs save_btn',
                'name' => 'add-exist-button'
            ]) ?>

            <a class="dell-block-link">
                <i class="fa fa-times"></i>
            </a>
        </div>
    </div>

    <div class="ibox-content">
        <?php 
            $safeAttributes = $model->safeAttributes();
            if (empty($safeAttributes)) {
                $safeAttributes = $model->attributes();
            }
            foreach ($model->attributes() as $attribute) {
                if (in_array($attribute, $safeAttributes)) {
                    eval('echo '.$model->generateActiveField($attribute,$model).';');
                }
            }
        ?>
        <hr>
    </div>

<?php ActiveForm::end()?>
</div>
