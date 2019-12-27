<?php
use yii\helpers\Html;
use common\components\MyExtensions\MyImagePublisher;

/**
 * @var $model \common\widgets\image\forms\ImageWidgetForm
 */
$width = ($model->width) ? $model->width : 500;
$height = ($model->height) ? $model->height : 500;

echo Html::img((new MyImagePublisher($model))->resizeInBox($width, $height));


