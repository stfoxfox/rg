<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\widgets\Box;
use backend\widgets\editable\EditableWidget;
use backend\assets\custom\ContactAsset;

/**
 * @var $this \yii\web\View
 * @var $models \yii\data\ActiveDataProvider
 */
ContactAsset::register($this);
?>

<div class="row">
    <div class="col-lg-10 col-md-10 col-lg-offset-1 col-md-offset-1 animated fadeInRight">
        <?php Box::begin([
            'header' => '<i class="fa fa-th-list"></i> Список',
            'headerButtons' => [[
                'label' => '<i class="fa fa-plus"></i> Добавить',
                'url' => Url::to(['add']),
                'options' => ['class' => 'btn btn-outline btn-xs btn-primary']
            ]],
            'collapseButton' => false
        ])?>

        <?=GridView::widget([
            'dataProvider' => $models,
            'tableOptions' => ['class' => 'table table-hover'],
            'layout' => "{items}\n{pager}",
            'options' => ['id' => 'sortable', 'data-url' => Url::to(['sort'])],
            'columns' => [
                [
                    'format' => 'html',
                    'value' => function() {
                        return Html::tag('span', '<i class="fa fa-bars"></i>', ['class' => 'label label-info dd-h']);
                    }
                ],
                [
                    'format' => 'raw',
                    'attribute' => 'title',
                    'enableSorting' => false,
                    'value' => function($model) {
                        /** @var $model \common\models\ContactSearch */
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
                    'attribute' => 'address',
                    'enableSorting' => false,
                    'value' => function($model) {
                        /** @var $model \common\models\ContactSearch */
                        return EditableWidget::widget([
                            'name' => 'address',
                            'value' => $model->address,
                            'pk' => $model->id,
                            'url' => ['editable'],
                        ]);
                    }
                ],
                [
                    'format' => 'raw',
                    'attribute' => 'phones',
                    'enableSorting' => false,
                    'value' => function($model) {
                        /** @var $model \common\models\ContactSearch */
                        return EditableWidget::widget([
                            'name' => 'phones',
                            'value' => $model->phones,
                            'pk' => $model->id,
                            'url' => ['editable'],
                        ]);
                    }
                ],
                [
                    'format' => 'raw',
                    'attribute' => 'email',
                    'enableSorting' => false,
                    'value' => function($model) {
                        /** @var $model \common\models\ContactSearch */
                        return EditableWidget::widget([
                            'name' => 'email',
                            'value' => $model->email,
                            'pk' => $model->id,
                            'url' => ['editable'],
                        ]);
                    }
                ],
                [
                    'label' => 'Создан',
                    'attribute' => 'created_at',
                    'enableSorting' => false,
                    'format' => 'datetime'
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Действия',
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            /** @var $model \common\models\Contact */
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['edit', 'id' => $model->id], [
                                'title' => 'Редактировать',
                                'aria-label' => 'Редактировать',
                                'data-pjax' => '0',
                            ]);
                        },
                        'delete' => function ($url, $model) {
                            /** @var $model \common\models\Contact */
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', 'javascript:void(0)', [
                                'title' => 'Удалить',
                                'aria-label' => 'Удалить',
                                'data-pjax' => '0',
                                'class' => 'item-delete',
                                'data-item-id' => $model->id,
                                'data-item-name' => $model->title,
                                'data-url' => Url::to(['delete']),
                            ]);
                        },
                    ],
                ],
            ]
        ])?>

        <?php Box::end()?>
    </div>
</div>
