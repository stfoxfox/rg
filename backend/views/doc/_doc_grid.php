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
    'options' => ['id' => 'sortable-doc',
        'data-url' => Url::to(['sort-items']),
        'data-table' => \common\models\Doc::tableName(),
    ],
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
            'value' => function($model) {
                /** @var $model \common\models\DocSearch */
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
            'attribute' => 'complex_id',
            'value' => function($model) {
                /** @var $model \common\models\DocSearch */
                return !empty($model->complex_id) ? $model->complex->title : null;
//                return EditableWidget::widget([
//                    'name' => 'complex_id',
//                    'value' => !empty($model->complex_id) ? $model->complex->title : null,
//                    'pk' => $model->id,
//                    'type' => 'select',
//                    'mode' => 'popup',
//                    'url' => ['editable'],
//                    'options' => [
//                        'data-title' => $model->getAttributeLabel('complex_id'),
//                        'data-source' => \common\models\Complex::getList(),
//                    ]
//                ]);
            }
        ],

        'created_at:datetime:Создана',
        [
            'header' => 'Действия',
            'class' => 'yii\grid\ActionColumn',
            'template' => '{edit} {delete}',
            'buttons' => [
                'edit' => function ($url, $model) {
                    /** @var $model \common\models\DocSearch */
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['edit-doc', 'id' => $model->id], [
                        'title' => 'Редактировать',
                        'aria-label' => 'Редактировать',
                        'data-pjax' => '0',
                    ]);
                },
                'delete' => function ($url, $model) {
                    /** @var $model \common\models\DocSearch */
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', 'javascript:void(0)', [
                        'title' => 'Удалить',
                        'aria-label' => 'Удалить',
                        'data-pjax' => '0',
                        'class' => 'delete-doc',
                        'data-item-id' => $model->id,
                        'data-category-id' => $model->category_id,
                        'data-item-name' => $model->title,
                        'data-url' => Url::to(['delete-doc']),
                    ]);
                },
            ],
        ],
    ]
])?>
