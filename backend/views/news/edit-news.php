<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\Box;
use yii\bootstrap\ActiveForm;
use common\widgets\DatePicker;
use backend\widgets\select2\Select2Widget;
use backend\assets\custom\NewsEditAsset;

/**
 * @var $this yii\web\View
 * @var $edit_form \backend\models\forms\NewsForm
 * @var $model \common\models\News
 * @var $tags \common\models\NewsTag[]
 */
NewsEditAsset::register($this);
?>

<div class="row">
    <div class="col-lg-4 col-md-4 animated fadeInLeft">
        <?php Box::begin(['header' => '<i class="fa fa-tags"></i> Тэги новости', 'headerButtons' => [
            [
                'label' => '<i class="fa fa-plus"></i> Добавить',
                'options' => [
                    'id' => 'add-tag',
                    'class' => 'btn btn-outline btn-xs btn-primary',
                    'data-url' => Url::to(['add-tag']),
                    'data-url-tags' => Url::to(['load-tags']),
                ],
            ],
        ], 'collapseButton' => false])?>
        <?=Html::beginTag('div', ['id' => 'sortable-tag', 'class' => 'dd',
            'data-url' => Url::to(['sort-tag']),
        ])?>
        <?=Html::ol($tags, ['item' => function($tag) {
            return $this->render('_tag', ['item' => $tag]);
        },
            'class' => 'dd-list',
        ])?>
        <?=Html::endTag('div')?>
        <?php Box::end()?>
    </div>

    <div class="col-lg-8 col-md-8 animated fadeInRight">
        <?php Box::begin([
            'header' => '<i class="fa fa-key"></i> Основная информация',
            'headerButtons' => [[
                'label' => '<i class="fa fa-pencil"></i> Управление контентом',
                'url' => Url::to(['/page/blocks', 'id' => $model->page_id]),
                'options' => ['class' => 'btn btn-outline btn-xs btn-success']
            ]],
            'collapseButton' => false
        ])?>

        <?php $form = ActiveForm::begin(['id' => 'news-form', 'class' => "m-t",
            'options' => ['enctype' => 'multipart/form-data'],
            'fieldConfig' => [
                'template' => "{beginWrapper}\n{label}\n<hr style='margin: 0 0 10px'>\n{input}\n{hint}\n{error}\n{endWrapper}",
            ],
        ]);
        ?>
        <?=$form->field($edit_form, 'title')?>
        <?=$form->field($edit_form, 'news_date')->widget(DatePicker::className())?>
        <?=$form->field($edit_form, 'short_text')?>
        <?=$form->field($edit_form, 'full_text')->textarea()?>
        <?=$form->field($edit_form, 'news_tags')->widget(Select2Widget::className(), [
            'items' => \common\models\NewsTag::getList(),
            'options' => [
                'class' => 'form-control m-r',
                'style' => 'width: 100%',
                'multiple' => true,
            ],
        ])?>
        <?=Html::activeHiddenInput($edit_form, 'page_id')?>

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
</div>
