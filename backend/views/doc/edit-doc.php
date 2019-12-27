<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use common\widgets\Box;
use backend\widgets\select2\Select2Widget;
use backend\widgets\editable\EditableWidget;
use backend\assets\custom\DocEditAsset;

/**
 * @var $this yii\web\View
 * @var $edit_form backend\models\forms\DocForm
 * @var $model \common\models\Doc
 * @var $versions \yii\data\ActiveDataProvider
 */
DocEditAsset::register($this);
?>

<div class="row">
    <div class="col-lg-5 col-md-5 animated fadeInLeft">
        <?php Box::begin(['header' => '<i class="fa fa-key"></i> Основная информация'])?>

        <?php $form = ActiveForm::begin(['id' => 'doc-form', 'class' => "m-t",
            'options' => ['enctype' => 'multipart/form-data'],
            'fieldConfig' => [
                'template' => "{beginWrapper}\n{label}\n<hr style='margin: 0 0 10px'>\n{input}\n{hint}\n{error}\n{endWrapper}",
            ],
        ]);
        ?>
        <?=$form->field($edit_form, 'title')?>
        <?=$form->field($edit_form, 'complex_id')->widget(Select2Widget::className(), [
            'items' => \common\models\Complex::getList(),
            'options' => [
                'prompt' => 'выберите',
                'class' => 'form-control m-r',
                'style' => 'width: 100%',
                'data-url' => Url::to(['change-selection']),
                'data-type' => 'complex',
            ],
        ])?>
        <?=$form->field($edit_form, 'corpus_num')->widget(Select2Widget::className(), [
            'items' => \common\models\Section::getCorpusesList($edit_form->complex_id),
            'options' => [
                'prompt' => '',
                'class' => 'form-control m-r',
                'style' => 'width: 100%',
                'data-url' => Url::to(['change-selection']),
                'data-type' => 'corpus',
            ],
        ])?>
        <?=$form->field($edit_form, 'section_id')->widget(Select2Widget::className(), [
            'items' => \common\models\Section::getSectionsList($edit_form->complex_id, $edit_form->corpus_num),
            'options' => [
                'prompt' => '',
                'class' => 'form-control m-r',
                'style' => 'width: 100%',
            ],
        ])?>
        <?=Html::activeHiddenInput($edit_form, 'category_id')?>

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
    <div class="col-lg-7 col-md-7 animated fadeInRight">
        <?php Box::begin(['header' => '<i class="fa fa-files-o"></i> Версии документа',
            'headerButtons' => [[
                'label' => '<i class="fa fa-plus"></i> Добавить',
                'url' => Url::to(['add-doc-version', 'id' => $model->id]),
                'options' => ['class' => 'btn btn-outline btn-xs btn-primary']
            ]],
            'collapseButton' => false
        ])?>

        <?=GridView::widget([
            'dataProvider' => $versions,
            'tableOptions' => ['class' => 'table table-hover'],
            'layout' => "{items}\n{pager}",
            'options' => ['id' => 'doc-versions-table'],
            'columns' => [
                [
                    'format' => 'raw',
                    'attribute' => 'file_id',
                    'enableSorting' => false,
                    'value' => function($model) {
                        /** @var $model \common\models\DocVersionSearch */
                        if ($model->file) {
                            if ($model->file->is_img) {
                                $img = Html::img($model->file->getThumb($model->parentModelShortName), [
                                    'class' => 'img-thumbnail img-responsive',
                                    'height' => 75,
                                ]);
                                return Html::a($img, $model->file->getOriginal($model->parentModelShortName), [
                                    'class' => 'galery_img',
                                    'data-lightbox' => 'roadtrip',
                                ]);

                            } else {
                                $thumb = $model->file->getThumb($model->parentModelShortName);
                                return Html::a($thumb, $model->file->getOriginal($model->parentModelShortName), [
                                    'target' => 'blank',
                                    'title' => $model->file->original_name,
                                    'aria-label' => $model->file->original_name,
                                ]);
                            }
                        }
                        return null;
                    }
                ],
                [
                    'format' => 'raw',
                    'attribute' => 'version',
                    'enableSorting' => false,
                    'value' => function($model) {
                        /** @var $model \common\models\DocVersionSearch */
                        return EditableWidget::widget([
                            'name' => 'version',
                            'value' => $model->version,
                            'pk' => $model->id,
                            'url' => ['editable-version'],
                        ]);
                    }
                ],
                [
                    'format' => 'date',
                    'attribute' => 'doc_date',
                    'enableSorting' => false,
                ],
                [
                    'format' => 'datetime',
                    'label' => 'Создана',
                    'attribute' => 'created_at',
                    'enableSorting' => false,
                ],
                [
                    'header' => 'Действия',
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{edit} {delete}',
                    'buttons' => [
                        'edit' => function ($url, $model) {
                            /** @var $model \common\models\DocVersionSearch */
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['edit-doc-version', 'id' => $model->id], [
                                'title' => 'Редактировать',
                                'aria-label' => 'Редактировать',
                                'data-pjax' => '0',
                            ]);
                        },
                        'delete' => function ($url, $model) {
                            /** @var $model \common\models\DocVersionSearch */
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', 'javascript:void(0)', [
                                'title' => 'Удалить',
                                'aria-label' => 'Удалить',
                                'data-pjax' => '0',
                                'class' => 'delete-doc-version',
                                'data-item-id' => $model->id,
                                'data-item-name' => $model->version,
                                'data-url' => Url::to(['delete-doc-version']),
                            ]);
                        },
                    ],
                ],
            ]
        ])?>

        <?php Box::end()?>
    </div>
    <?php }?>
</div>
