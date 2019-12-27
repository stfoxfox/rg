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
    'layout' => "{items}\n{pager}",
    'options' => ['id' => 'mortgages-table', 'data-url' => Url::to(['sort-mortgage'])],
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
                /** @var $model \common\models\MortgageSearch */
                return EditableWidget::widget([
                    'name' => 'title',
                    'value' => $model->title,
                    'pk' => $model->id,
                    'url' => ['editable-mortgage'],
                ]);
            }
        ],
        [
            'format' => 'raw',
            'attribute' => 'min_cash',
            'enableSorting' => false,
            'value' => function($model) {
                /** @var $model \common\models\MortgageSearch */
                return EditableWidget::widget([
                    'name' => 'min_cash',
                    'value' => $model->min_cash,
                    'pk' => $model->id,
                    'url' => ['editable-mortgage'],
                ]);
            }
        ],
        [
            'format' => 'raw',
            'attribute' => 'percent_rate',
            'enableSorting' => false,
            'value' => function($model) {
                /** @var $model \common\models\MortgageSearch */
                return EditableWidget::widget([
                    'name' => 'percent_rate',
                    'value' => $model->percent_rate,
                    'pk' => $model->id,
                    'url' => ['editable-mortgage'],
                ]);
            }
        ],
        [
            'format' => 'raw',
            'attribute' => 'max_amount',
            'enableSorting' => false,
            'value' => function($model) {
                /** @var $model \common\models\MortgageSearch */
                return EditableWidget::widget([
                    'name' => 'max_amount',
                    'value' => $model->max_amount,
                    'pk' => $model->id,
                    'url' => ['editable-mortgage'],
                ]);
            }
        ],
        [
            'header' => 'Действия',
            'class' => 'yii\grid\ActionColumn',
            'template' => '{edit} {delete}',
            'buttons' => [
                'edit' => function ($url, $model) {
                    /** @var $model \common\models\MortgageSearch */
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['edit-mortgage', 'id' => $model->id], [
                        'title' => 'Редактировать',
                        'aria-label' => 'Редактировать',
                        'data-pjax' => '0',
                    ]);
                },
                'delete' => function ($url, $model) {
                    /** @var $model \common\models\MortgageSearch */
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', 'javascript:void(0)', [
                        'title' => 'Удалить',
                        'aria-label' => 'Удалить',
                        'data-pjax' => '0',
                        'class' => 'delete-mortgage',
                        'data-item-id' => $model->id,
                        'data-item-name' => $model->title,
                        'data-url' => Url::to(['delete-mortgage']),
                    ]);
                },
            ],
        ],
    ]
])?>
