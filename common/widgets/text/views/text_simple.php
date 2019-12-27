<?php
use yii\helpers\Html;
use common\components\MyExtensions\MyHelper;

/**
 * @var $this \yii\web\View
 * @var $model \common\widgets\text\forms\TextSimpleWidgetForm
 */
?>

<?=Html::tag('h1', $model->title, ['class' => 'title--xxl'])?>
<div class="text--m">
    <?=Html::tag('p', MyHelper::formatTextToHTML($model->text))?>
</div>
