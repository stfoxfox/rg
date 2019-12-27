<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\widgets\Box;
use backend\widgets\editable\EditableWidget;
use backend\assets\custom\BankAsset;

/**
 * @var $this \yii\web\View
 * @var $models \yii\data\ActiveDataProvider
 */
BankAsset::register($this);
?>

<div class="row">
    <div class="col-lg-10 col-md-10 col-lg-offset-1 col-md-offset-1 animated fadeInRight">
        <?php Box::begin([
            'header' => '<i class="fa fa-th-list"></i> Список',
            'headerButtons' => [[
                'label' => '<i class="fa fa-plus"></i> Добавить',
                'url' => Url::to(['add-bank']),
                'options' => ['class' => 'btn btn-outline btn-xs btn-primary']
            ]],
            'collapseButton' => false
        ])?>

        <?=GridView::widget([
            'dataProvider' => $models,
            'tableOptions' => ['class' => 'table table-hover'],
            'options' => ['id' => 'bank_table', 'data-url' => Url::to(['sort-bank'])],
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
                    'attribute' => 'title',
                    'enableSorting' => false,
                    'value' => function($model) {
                        /** @var $model \common\models\BankSearch */
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
                    'attribute' => 'license',
                    'enableSorting' => false,
                    'value' => function($model) {
                        /** @var $model \common\models\BankSearch */
                        return EditableWidget::widget([
                            'name' => 'license',
                            'value' => $model->license,
                            'pk' => $model->id,
                            'type' => 'textarea',
                            'mode' => 'inline',
                            'url' => ['editable'],
                        ]);
                    }
                ],
                [
                    'attribute' => 'date_license',
                    'enableSorting' => false,
                    'format' => 'date'
                ],
                [
                    'label' => 'Создан',
                    'attribute' => 'created_at',
                    'enableSorting' => false,
                    'format' => 'date'
                ],

                [
                    'header' => 'Действия',
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            /** @var $model \common\models\BankSearch */
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['edit-bank', 'id' => $model->id], [
                                'title' => 'Редактировать',
                                'aria-label' => 'Редактировать',
                                'data-pjax' => '0',
                            ]);
                        },
                        'delete' => function ($url, $model) {
                            /** @var $model \common\models\BankSearch */
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', 'javascript:void(0)', [
                                'title' => 'Удалить',
                                'aria-label' => 'Удалить',
                                'data-pjax' => '0',
                                'class' => 'delete-bank',
                                'data-item-id' => $model->id,
                                'data-item-name' => $model->title,
                                'data-url' => Url::to(['delete-bank']),
                            ]);
                        },
                    ],
                ],
            ]
        ])?>

        <?php Box::end()?>
    </div>
</div>
