<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use backend\widgets\editable\EditableWidget;

/**
 * @var $this \yii\web\View
 * @var $models \yii\data\ActiveDataProvider
 */
?>

<?=GridView::widget([
    'dataProvider' => $models,
    'tableOptions' => ['class' => 'table table-hover'],
    'options' => ['id' => 'sortable', 'data-url' => Url::to(['sort-items'])],
    'layout' => "{items}\n{pager}",
    'columns' => [
        [
            'format' => 'html',
            'value' => function() {
                return Html::tag('span', '<i class="fa fa-bars"></i>', ['class' => 'label label-info dd-h']);
            }
        ],
        [
            'format' => 'raw',
            'attribute' => 'file_id',
            'enableSorting' => false,
            'value' => function($model) {
                /** @var $model \common\models\GalleryItemSearch */
                if ($model->file) {
                    $img = Html::img($model->file->getThumb($model->parentModelShortName), [
                        'class' => 'img-thumbnail img-responsive',
                        'height' => 100,
                    ]);
                    return Html::a($img, $model->file->getOriginal($model->parentModelShortName), [
                        'class' => 'galery_img',
                        'data-lightbox' => 'roadtrip',
                    ]);
                }
                return null;
            }
        ],
        [
            'format' => 'raw',
            'label' => 'Заголовок',
            'enableSorting' => false,
            'value' => function($model) {
                /** @var $model \common\models\GalleryItemSearch */
                return EditableWidget::widget([
                    'name' => 'title',
                    'value' => $model->file->title,
                    'pk' => $model->file->id,
                    'url' => ['editable-item'],
                ]);
            }
        ],
        [
            'format' => 'raw',
            'label' => 'Описание',
            'enableSorting' => false,
            'value' => function($model) {
                /** @var $model \common\models\GalleryItemSearch */
                return EditableWidget::widget([
                    'name' => 'description',
                    'value' => $model->file->description,
                    'pk' => $model->file->id,
                    'type' => 'textarea',
                    'mode' => 'inline',
                    'url' => ['editable-item'],
                ]);
            }
        ],


        'created_at:datetime:Создана',
        [
            'header' => 'Действия',
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {edit} {delete}',
            'buttons' => [
                'update' => function ($url, $model) {
                    /** @var $model \common\models\GalleryItemSearch */
                    return Html::a('<span class="glyphicon glyphicon-picture"></span>', 'javascript:void(0)', [
                        'title' => 'Картинка',
                        'aria-label' => 'Картинка',
                        'class' => 'edit-file',
                        'data-picture-url' => $model->file->getOriginal($model->parentModelShortName),
                        'data-item-id' => $model->file->id,
                        'data-pjax' => '0',
                    ]);
                },
                'edit' => function ($url, $model) {
                    /** @var $model \common\models\GalleryItemSearch */
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['edit-item', 'id' => $model->id], [
                        'title' => 'Редактировать',
                        'aria-label' => 'Редактировать',
                        'data-pjax' => '0',
                    ]);
                },
                'delete' => function ($url, $model) {
                    /** @var $model \common\models\GalleryItemSearch */
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', 'javascript:void(0)', [
                        'title' => 'Удалить',
                        'aria-label' => 'Удалить',
                        'data-pjax' => '0',
                        'class' => 'delete-item',
                        'data-item-id' => $model->id,
                        'data-item-name' => $model->file->title,
                        'data-url' => Url::to(['delete-item']),
                    ]);
                },
            ],
        ],
    ]
])?>
