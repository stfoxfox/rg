<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\widgets\Box;
use common\models\Gallery;
use backend\widgets\editable\EditableWidget;
use backend\assets\custom\GalleryAsset;

/**
 * @var $this \yii\web\View
 * @var $models \yii\data\ActiveDataProvider
 */
$enum_type = Gallery::getAttributeSourceEnums('type');
$type = Gallery::getAttributeEnums('type');
GalleryAsset::register($this);
?>

<div class="row">
    <div class="col-lg-10 col-md-10 col-lg-offset-1 col-md-offset-1 animated fadeInRight">
        <?php Box::begin([
            'header' => '<i class="fa fa-th-list"></i> Список',
            'headerButtons' => [[
                'label' => '<i class="fa fa-plus"></i> Добавить',
                'url' => Url::to(['add-gallery']),
                'options' => ['class' => 'btn btn-outline btn-xs btn-primary']
            ]],
            'collapseButton' => false
        ])?>

        <?=GridView::widget([
            'dataProvider' => $models,
            'tableOptions' => ['class' => 'table table-hover'],
            'options' => ['id' => 'gallery_table'],
            'layout' => "{items}\n{pager}",
            'columns' => [
                [
                    'format' => 'raw',
                    'attribute' => 'title',
                    'enableSorting' => false,
                    'value' => function($model) {
                        /** @var $model \common\models\GallerySearch */
                        return EditableWidget::widget([
                            'name' => 'title',
                            'value' => $model->title,
                            'pk' => $model->id,
                            'url' => ['editable'],
                        ]);
                    }
                ],
                [
                    'format' => 'raw',
                    'attribute' => 'description',
                    'enableSorting' => false,
                    'value' => function($model) {
                        /** @var $model \common\models\GallerySearch */
                        return EditableWidget::widget([
                            'name' => 'description',
                            'value' => $model->description,
                            'pk' => $model->id,
                            'type' => 'textarea',
                            'mode' => 'inline',
                            'url' => ['editable'],
                        ]);
                    }
                ],
                [
                    'format' => 'raw',
                    'attribute' => 'type',
                    'value' => function($model) use ($type, $enum_type) {
                        /** @var $model \common\models\GallerySearch */
                        return EditableWidget::widget([
                            'name' => 'type',
                            'value' => !empty($model->type) ? $type[$model->type] : null,
                            'pk' => $model->id,
                            'type' => 'select',
                            'mode' => 'popup',
                            'url' => ['editable'],
                            'options' => [
                                'data-title' => $model->getAttributeLabel('type'),
                                'data-source' => $enum_type,
                            ]
                        ]);
                    }
                ],

                'created_at:datetime:Создана',
                [
                    'header' => 'Действия',
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {view} {delete}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            /** @var $model \common\models\GallerySearch */
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['edit-gallery', 'id' => $model->id], [
                                'title' => 'Редактировать',
                                'aria-label' => 'Редактировать',
                                'data-pjax' => '0',
                            ]);
                        },
                        'view' => function ($url, $model) {
                            /** @var $model \common\models\GallerySearch */
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['items', 'id' => $model->id], [
                                'title' => 'Элементы галереи',
                                'aria-label' => 'Элементы галереи',
                                'data-pjax' => '0',
                            ]);
                        },
                        'delete' => function ($url, $model) {
                            /** @var $model \common\models\GallerySearch */
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', 'javascript:void(0)', [
                                'title' => 'Удалить',
                                'aria-label' => 'Удалить',
                                'data-pjax' => '0',
                                'class' => 'delete-gallery',
                                'data-item-id' => $model->id,
                                'data-item-name' => $model->title,
                                'data-url' => Url::to(['delete-gallery']),
                            ]);
                        },
                    ],
                ],
            ]
        ])?>

        <?php Box::end()?>
    </div>
</div>
