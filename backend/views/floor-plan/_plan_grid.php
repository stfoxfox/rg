<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use backend\widgets\editable\EditableWidget;
use common\models\Section;

/**
 * @var $this \yii\web\View
 * @var $models \yii\data\ActiveDataProvider
 * @var $complex_id integer
 */
$corpuses = Section::getCorpuses($complex_id);
?>

<?=GridView::widget([
    'dataProvider' => $models,
    'tableOptions' => ['class' => 'table table-hover'],
    'layout' => "{items}\n{pager}",
    'options' => ['id' => 'plan-table'],
    'columns' => [
        [
            'format' => 'raw',
            'attribute' => 'file_id',
            'enableSorting' => false,
            'value' => function($model) {
                /** @var $model \common\models\FloorPlanSearch */
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
            'attribute' => 'corpus_num',
            'value' => function($model) use ($corpuses) {
                /** @var $model \common\models\FloorPlanSearch */
                return EditableWidget::widget([
                    'name' => 'corpus_num',
                    'value' => $model->corpus_num,
                    'pk' => $model->id,
                    'type' => 'select',
                    'mode' => 'popup',
                    'url' => ['editable'],
                    'options' => [
                        'data-title' => $model->getAttributeLabel('corpus_num'),
                        'data-source' => $corpuses,
                    ]
                ]);
            }
        ],
        [
            'format' => 'raw',
            'attribute' => 'section_num',
            'value' => function($model) {
                /** @var $model \common\models\FloorPlanSearch */
                return EditableWidget::widget([
                    'name' => 'section_num',
                    'value' => $model->section_num,
                    'pk' => $model->id,
                    'type' => 'select',
                    'mode' => 'popup',
                    'url' => ['editable'],
                    'options' => [
                        'data-title' => $model->getAttributeLabel('section_num'),
                        'data-source' => Section::getSectionsNumList($model->complex_id, $model->corpus_num),
                    ]
                ]);
            }
        ],
        [
            'label' => 'Этажи',
            'format' => 'html',
            'value' => function($model) {
                /** @var $model \common\models\FloorPlanSearch */
                return $model->floor_num_starts . ' - ' . $model->floor_num_ends;
            }
        ],
        [
            'format' => 'raw',
            'attribute' => 'number_on_floor',
            'enableSorting' => false,
            'value' => function($model) {
                /** @var $model \common\models\FloorPlanSearch */
                return EditableWidget::widget([
                    'name' => 'number_on_floor',
                    'value' => $model->number_on_floor,
                    'pk' => $model->id,
                    'url' => ['editable'],
                ]);
            }
        ],


        'created_at:datetime:Создана',
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Действия',
            'template' => '{update} {delete}',
            'buttons' => [
                'update' => function ($url, $model) {
                    /** @var $model \common\models\FloorPlanSearch */
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['edit-plan', 'id' => $model->id], [
                        'title' => 'Редактировать',
                        'aria-label' => 'Редактировать',
                        'data-pjax' => '0',
                    ]);
                },
                'delete' => function ($url, $model) {
                    /** @var $model \common\models\FloorPlanSearch */
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', 'javascript:void(0)', [
                        'title' => 'Удалить',
                        'aria-label' => 'Удалить',
                        'data-pjax' => '0',
                        'class' => 'item-delete',
                        'data-item-id' => $model->id,
                        'data-item-name' => $model->external_id,
                        'data-url' => Url::to(['item-delete']),
                    ]);
                },
            ],
        ],
    ]
])?>
