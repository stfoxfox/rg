<?php
use yii\helpers\Html;
use common\components\MyExtensions\MyHelper;

/**
 * @var $this \yii\web\View
 * @var $model \common\widgets\text\forms\TextColumnWidgetForm
 */
?>

<div class="block_callout">
    <div class="block_callout__inner">
        <?=Html::tag('h4', $model->title, ['class' => 'block_callout__title title--m'])?>
        <div class="block_callout__paragraphs">
            <?=Html::tag('p', MyHelper::formatTextToHTML($model->text))?>
        </div>
    </div>
</div>

