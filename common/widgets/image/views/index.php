<?php
use common\components\MyExtensions\MyImagePublisher;

/**
 * @var $model \common\widgets\image\forms\ImageWidgetForm
 */
$width = ($model->width) ? $model->width : 2000;
$height = ($model->height) ? $model->height : 1335;

echo (new MyImagePublisher($model))->resizeInBox($width, $height);


