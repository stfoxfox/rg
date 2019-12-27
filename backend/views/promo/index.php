<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\widgets\Box;
use backend\widgets\editable\EditableWidget;
use backend\assets\custom\PromoAsset;

/**
 * @var $this \yii\web\View
 * @var $promos \yii\data\ActiveDataProvider
 */
PromoAsset::register($this);
?>

<div class="row">
    <div class="col-lg-10 col-md-10 col-lg-offset-1 col-md-offset-1 animated fadeInRight">
        <?php Box::begin([
            'header' => '<i class="fa fa-th-list"></i> Список',
            'headerButtons' => [[
                'label' => '<i class="fa fa-plus"></i> Добавить',
                'url' => Url::to(['add-promo']),
                'options' => ['class' => 'btn btn-outline btn-xs btn-primary']
            ]],
            'collapseButton' => false
        ])?>

        <?=GridView::widget([
            'dataProvider' => $promos,
            'tableOptions' => ['class' => 'table table-hover'],
            'layout' => "{items}\n{pager}",
            'options' => ['id' => 'sortable', 'data-url' => Url::to(['item-sort'])],
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
                    'value' => function($model) {
                        /** @var $model \common\models\PromoSearch */
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
                    'attribute' => 'title',
                    'value' => function($model) {
                        /** @var $model \common\models\PromoSearch */
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
                    'value' => function($model) {
                        /** @var $model \common\models\PromoSearch */
                        return EditableWidget::widget([
                            'name' => 'description',
                            'value' => $model->description,
                            'pk' => $model->id,
                            'type' => 'textarea',
                            'mode' => 'popup',
                            'url' => ['editable'],
                        ]);
                    }
                ],
                'date_to:date',
//                [
//                    'format' => 'raw',
//                    'attribute' => 'date_to',
//                    'value' => function($model) {
//                        /** @var $model \common\models\PromoSearch */
//                        return EditableWidget::widget([
//                            'name' => 'date_to',
//                            'value' => Yii::$app->formatter->asDate($model->date_to, 'dd.MM.yyyy'),
//                            'pk' => $model->id,
//                            'type' => 'combodate',
//                            'url' => ['editable'],
//                            'options' => [
//                                'data-format' => 'DD.MM.YYYY',
//                                'data-viewformat' => 'DD.MM.YYYY',
//                                'data-template' => 'D / MMM / YYYY',
//                            ],
//                        ]);
//                    }
//                ],
                'created_at:datetime:Создана',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Действия',
                    'template' => '{update} {content} {delete}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            /** @var $model \common\models\Promo */
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['edit-promo', 'id' => $model->id], [
                                'title' => 'Редактировать',
                                'aria-label' => 'Редактировать',
                                'data-pjax' => '0',
                            ]);
                        },
                        'content' => function ($url, $model) {
                            /** @var $model \common\models\Promo */
                            return ($model->page)
                                ? Html::a('<span class="glyphicon glyphicon-tasks"></span>', ['/page/blocks', 'id' => $model->page->id], [
                                    'title' => 'Редактировать',
                                    'aria-label' => 'Редактировать',
                                    'data-pjax' => '0',
                                ]) : '';
                        },
                        'delete' => function ($url, $model) {
                            /** @var $model \common\models\Promo */
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', 'javascript:void(0)', [
                                'title' => 'Удалить',
                                'aria-label' => 'Удалить',
                                'data-pjax' => '0',
                                'class' => 'item-delete',
                                'data-item-id' => $model->id,
                                'data-item-name' => $model->title,
                                'data-url' => Url::to(['item-delete']),
                            ]);
                        },
                    ],
                ],
            ]
        ])?>

        <?php Box::end()?>
    </div>
</div>
