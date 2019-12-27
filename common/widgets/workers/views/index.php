<?php
use yii\helpers\Html;

/**
 * @var $this \yii\web\View
 * @var $model \common\widgets\workers\forms\WorkersContainerWidgetForm
 * @var $block \common\models\PageBlock
 */
$i = 0;
?>

<article id="department_leaders">
    <?=Html::tag('h1', $model->title, ['class' => 'title--xxl'])?>
    <div class="row p-14">
        <?php foreach ($block->childBlocks as $childBlock) {
            echo $childBlock->getDataWidget();

            if ($model->show_line && $i == 0) {
                echo Html::tag('div', Html::tag('hr', '', ['class' => 'hr hr--red']), ['class' => 'col-12']);
            }
            $i ++;
        }?>
    </div>
</article>