<?php
use yii\helpers\Html;
use common\components\MyExtensions\MyHelper;

/**
 * @var $this \yii\web\View
 * @var $block \common\models\PageBlock
 */
?>

<div class="contacts_tabs">
    <div class="block_tabs js_tabs">
        <?php $i = 0?>
        <?php foreach ($block->childBlocks as $childBlock) {
            $childBlockWidget = $childBlock->getWidgetClass();
            echo Html::a($childBlockWidget->params['title'], '#', ['class' => ($i == 0) ? 'text--m current' : 'text--m']);
            $i ++;
        }?>
    </div>

    <div class="contacts_tabs__content js_tabs__content">
        <?php $i = 0?>
        <?php foreach ($block->childBlocks as $childBlock) {
            $childBlockWidget = $childBlock->getWidgetClass();
            echo Html::beginTag('div', ['class' => ($i == 0) ? 'contacts_tabs__item current' : 'contacts_tabs__item']);
            echo Html::tag('p', MyHelper::formatTextToHTML($childBlockWidget->params['text']), ['class' => 'text--m']);
            echo Html::endTag('div');
            $i ++;
        }?>
    </div>
</div>
