<?php
/**
 * @var \yii\web\View $this
 * @var \common\models\PageBlock[] $provider
 */
?>

<div id="blocks-list" class="col-lg-12 ui-sortable">
    <?php foreach ($provider as $block) {
        //echo Yii::$app->controller->renderPartial($block->getBlockTemplateForBackend(),['item'=>$block]);
        $widgetClass = $block->widgetClassName;
        $params = $block->dataParams;

        /** @var \common\components\MyExtensions\MyWidget $block_widget */
        $block_widget = new $widgetClass(['page_id' => $block->page_id, 'params' => $params]);
        if($block_widget){
            echo $block_widget->backendView($block);
        }
    }?>
</div>
