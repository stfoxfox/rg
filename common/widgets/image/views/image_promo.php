<?php
use yii\helpers\Html;
use common\components\MyExtensions\MyHelper;
use common\components\MyExtensions\MyImagePublisher;

/**
 * @var $model \common\widgets\image\forms\ImagePromoWidgetForm
 */
$width = ($model->width) ? $model->width : 368;
$height = ($model->height) ? $model->height : 297;
?>

<div class="col-4">
    <div class="offer_gift_card">
        <?=Html::img((new MyImagePublisher($model))->resizeInBox($width, $height), ['class' => 'block_special_offer__illu'])?>
        <?=Html::tag('div', MyHelper::formatTextToHTML($model->text), ['class' => 'text--m'])?>
    </div>
</div>


