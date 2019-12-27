<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use common\widgets\Box;
use backend\widgets\editable\EditableWidget;
use backend\assets\custom\FeedbackAsset;
use common\models\Feedback;

/**
 * @var $this \yii\web\View
 * @var $models \yii\data\ActiveDataProvider
 */
FeedbackAsset::register($this);

$status = Feedback::getAttributeEnums('status');
$status_source = Feedback::getAttributeSourceEnums('status');
$type = Feedback::getAttributeEnums('type');
?>

<div class="row">
    <div class="col-lg-12 col-md-12 animated fadeInRight">
        <?php Box::begin([
            'header' => '<i class="fa fa-th-list"></i> Список',
            'collapseButton' => false
        ])?>

        <?=GridView::widget([
            'dataProvider' => $models,
            'tableOptions' => ['class' => 'table table-hover'],
            'options' => ['id' => 'feedback_table'],
            'layout' => "{items}\n{pager}",
            'columns' => [
                [
                    'attribute' => 'type',
                    'enableSorting' => false,
                    'value' => function($model) use ($type) {
                        /** @var $model \common\models\FeedbackSearch */
                        return $type[$model->type];
                    }
                ],
                [
                    'attribute' => 'name',
                    'enableSorting' => false,
                    'format' => 'html',
                    'value' => function($model) {
                        /** @var $model \common\models\FeedbackSearch */
                        $user = ($model->user) ? '<br/><i class="fa fa-user"></i> ' . $model->user->username : '';
                        return $model->name . $user;
                    }
                ],
                [
                    'label' => 'Контакты',
                    'format' => 'html',
                    'value' => function($model) {
                        /** @var $model \common\models\FeedbackSearch */
                        $phone = ($model->phone) ? '<i class="fa fa-phone-square"></i> ' . $model->phone . '<br/>' : '';
                        $email = ($model->email) ? '<i class="fa fa-envelope"></i> ' . $model->email . '<br/>' : '';
                        return $phone . $email;
                    }
                ],
                [
                    'format' => 'html',
                    'attribute' => 'message',
                    'enableSorting' => false,
                ],
                [
                    'format' => 'html',
                    'attribute' => 'extra',
                    'enableSorting' => false,
                    'value' => function($model) {
                        /** @var $model \common\models\FeedbackSearch */
                        if (!$model->extra)
                            return null;

                        $result = [];
                        $arr = Json::decode($model->extra);
                        foreach ($arr as $key => $value) {
                            $result []= $key . ': ' . $value;
                        }
                        return implode('<br/>', $result);
                    }
                ],
                [
                    'format' => 'raw',
                    'attribute' => 'status',
                    'enableSorting' => false,
                    'value' => function($model) use ($status, $status_source) {
                        /** @var $model \common\models\FeedbackSearch */
                        return EditableWidget::widget([
                            'name' => 'status',
                            'value' => $status[$model->status],
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
                    'template' => '{delete}',
                    'buttons' => [
                        'delete' => function ($url, $model) {
                            /** @var $model \common\models\FeedbackSearch */
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', 'javascript:void(0)', [
                                'title' => 'Удалить',
                                'aria-label' => 'Удалить',
                                'data-pjax' => '0',
                                'class' => 'delete-item',
                                'data-item-id' => $model->id,
                                'data-item-name' => 'от ' . $model->name,
                                'data-url' => Url::to(['delete-item']),
                            ]);
                        },
                    ],
                ],
            ]
        ])?>

        <?php Box::end()?>
    </div>
</div>