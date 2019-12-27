<?php
use yii\helpers\Html;
use common\components\MyExtensions\MyHelper;

/**
 * @var $this \yii\web\View
 * @var $model \common\widgets\features\forms\FeatureWidgetForm
 */
?>

<?=Html::tag('div', $model->title, ['class' => 'flat_features__item_title'])?>
<?=Html::tag('div', MyHelper::formatTextToHTML($model->text1), ['class' => 'flat_features__item_description'])?>
<?=Html::tag('div', MyHelper::formatTextToHTML($model->text2), ['class' => 'flat_features__item_table'])?>
<?=Html::tag('div', MyHelper::formatTextToHTML($model->text3), ['class' => 'flat_features__item_description'])?>

<div class="flat_features__item_actions">
    <?=Html::a(Html::tag('span', $model->link_title, ['class' => 'btn__label']), $model->link, ['class' => 'btn btn--main'])?>
</div>
