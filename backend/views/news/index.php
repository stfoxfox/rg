<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\widgets\Box;
use backend\widgets\editable\EditableWidget;
use backend\assets\custom\NewsAsset;

/**
 * @var $this \yii\web\View
 * @var $models \yii\data\ActiveDataProvider
 */
NewsAsset::register($this);
?>

<div class="row">
    <div class="col-lg-10 col-md-10 col-lg-offset-1 col-md-offset-1 animated fadeInRight">
        <?php Box::begin([
            'header' => '<i class="fa fa-th-list"></i> Список',
            'headerButtons' => [[
                'label' => '<i class="fa fa-plus"></i> Добавить',
                'url' => 'javascript:void(0)',
                'options' => [
                    'id' => 'add-news',
                    'class' => 'btn btn-outline btn-xs btn-primary',
                    'data-url' => Url::to(['add-news']),
                ]
            ]],
            'collapseButton' => false
        ])?>

        <?=GridView::widget([
            'dataProvider' => $models,
            'tableOptions' => ['class' => 'table table-hover'],
            'options' => ['id' => 'news_table'],
            'layout' => "{items}\n{pager}",
            'columns' => [
                [
                    'attribute' => 'news_date',
                    'enableSorting' => false,
                    'format' => 'date'
                ],
                [
                    'format' => 'raw',
                    'attribute' => 'title',
                    'enableSorting' => false,
                    'value' => function($model) {
                        /** @var $model \common\models\NewsSearch */
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
                    'attribute' => 'short_text',
                    'enableSorting' => false,
                    'value' => function($model) {
                        /** @var $model \common\models\NewsSearch */
                        return EditableWidget::widget([
                            'name' => 'license',
                            'value' => $model->short_text,
                            'pk' => $model->id,
                            'type' => 'textarea',
                            'mode' => 'inline',
                            'url' => ['editable'],
                        ]);
                    }
                ],
                [
                    'label' => 'Создана',
                    'attribute' => 'created_at',
                    'enableSorting' => false,
                    'format' => 'datetime'
                ],

                [
                    'header' => 'Действия',
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            /** @var $model \common\models\NewsSearch */
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['edit-news', 'id' => $model->id], [
                                'title' => 'Редактировать',
                                'aria-label' => 'Редактировать',
                                'data-pjax' => '0',
                            ]);
                        },
                        'delete' => function ($url, $model) {
                            /** @var $model \common\models\NewsSearch */
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', 'javascript:void(0)', [
                                'title' => 'Удалить',
                                'aria-label' => 'Удалить',
                                'data-pjax' => '0',
                                'class' => 'delete-news',
                                'data-item-id' => $model->id,
                                'data-item-name' => $model->title,
                                'data-url' => Url::to(['delete-news']),
                            ]);
                        },
                    ],
                ],
            ]
        ])?>

        <?php Box::end()?>
    </div>
</div>