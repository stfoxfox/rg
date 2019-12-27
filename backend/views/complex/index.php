<?php
use yii\helpers\Html;
use yii\grid\GridView;
use common\widgets\Box;
use backend\widgets\editable\EditableWidget;
use backend\assets\custom\ComplexAsset;
use common\models\Complex;

/**
 * @var $this \yii\web\View
 * @var $models \yii\data\ActiveDataProvider
 */
ComplexAsset::register($this);

$status = Complex::getAttributeEnums('status');
$status_source = Complex::getAttributeSourceEnums('status');
?>

<div class="row">
    <div class="col-lg-10 col-md-10 col-lg-offset-1 col-md-offset-1 animated fadeInRight">
        <?php Box::begin([
            'header' => '<i class="fa fa-th-list"></i> Список',
            'collapseButton' => false
        ])?>

        <?=GridView::widget([
            'dataProvider' => $models,
            'tableOptions' => ['class' => 'table table-hover'],
            'options' => ['id' => 'complex-table'],
            'layout' => "{items}\n{pager}",
            'columns' => [
                [
                    'format' => 'raw',
                    'attribute' => 'title',
                    'value' => function($model) {
                        /** @var $model \common\models\ComplexSearch */
                        return EditableWidget::widget([
                            'name' => 'title',
                            'value' => $model->title,
                            'pk' => $model->id,
                            'url' => ['editable'],
                        ]);
                    }
                ],
                [
                    'label' => 'Цены',
                    'format' => 'html',
                    'value' => function($model) {
                        /** @var $model \common\models\ComplexSearch */
                        $min = ($model->min_price) ? 'от ' . Yii::$app->formatter->asCurrency($model->min_price) : '';
                        $max = ($model->max_price) ? ' до ' . Yii::$app->formatter->asCurrency($model->max_price) : '';
                        return $min . $max;
                    }
                ],
                [
                    'label' => 'Площадь',
                    'format' => 'html',
                    'value' => function($model) {
                        /** @var $model \common\models\ComplexSearch */
                        $min = ($model->min_area) ? 'от ' . Yii::$app->formatter->asDecimal($model->min_area) : '';
                        $max = ($model->max_area) ? ' до ' . Yii::$app->formatter->asDecimal($model->max_area) : '';
                        return $min . $max;
                    }
                ],
                [
                    'format' => 'raw',
                    'attribute' => 'is_active',
                    'enableSorting' => false,
                    'value' => function($model) use ($status, $status_source) {
                        /** @var $model \common\models\ComplexSearch */
                        return EditableWidget::widget([
                            'name' => 'is_active',
                            'value' => ($model->is_active)
                                ? $status[$model->is_active] : $status[Complex::STATUS_DISABLED],
                            'pk' => $model->id,
                            'type' => 'select',
                            'mode' => 'popup',
                            'url' => ['editable'],
                            'options' => [
                                'data-title' => $model->getAttributeLabel('status'),
                                'data-source' => $status_source,
                            ]
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
                    'template' => '{update}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            /** @var $model \common\models\ComplexSearch */
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['edit-complex', 'id' => $model->id], [
                                'title' => 'Редактировать',
                                'aria-label' => 'Редактировать',
                                'data-pjax' => '0',
                            ]);
                        },
                    ],
                ],
            ]
        ])?>

        <?php Box::end()?>
    </div>
</div>