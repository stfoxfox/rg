<?php
use yii\helpers\Html;
use common\components\MyExtensions\MyHelper;

/**
 * @var $this \yii\web\View
 * @var $model \common\widgets\promo\forms\PromoWidgetForm
 * @var $block \common\models\PageBlock
 */
?>

<div class="section__container">
    <div class="section__content">

        <div class="block_offer_gift_head">
            <?=Html::tag('h3', $model->title, ['class' => 'block_offer_gift_title title--l'])?>
            <div class="special__offer_1_heading block_special_offer__description">
                <?=Html::tag('div', MyHelper::formatTextToHTML($model->text), ['class' => 'text--m'])?>
            </div>
        </div>

        <div class="row p-34">
            <?php foreach ($block->childBlocks as $childBlock) {
                echo $childBlock->getDataWidget();
            }?>
        </div>
    </div>
</div>
