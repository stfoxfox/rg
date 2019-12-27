<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\widgets\editable\EditableWidget;
use common\components\MyExtensions\MyImagePublisher;

/**
 * @var \common\components\MyExtensions\WidgetModel $model
 * @var string $class_name - $model::className()
 * @var \common\models\PageBlock $page_block
 */

/** @var \common\components\MyExtensions\MyWidget $widget */
//$widget = $page_block->getWidgetClass();
$widget = new $class_name;
$title = $widget::getBlockName() . '&nbsp;&nbsp;';
?>

<?=Html::beginTag('div', [
    'id' => 'block_' . $page_block->id,
    'class' => 'ibox page_block',
    'sort-id' => $page_block->id,
    'data-page-block-id' => $page_block->id,
    'data-page-block-parent-id' => $page_block->parent_id,
    'data-edit-url' => Url::to(['/page/edit-widget']),
])?>
    <div class="ibox-title">
        <?=Html::tag('h5', $widget->icon . ' ' . $title, ['class' => ' ui-sortable-handle'])
        . EditableWidget::widget([
            'name' => 'block_name',
            'value' => $page_block->block_name,
            'pk' => $page_block->id,
            'url' => ['block-editable'],
        ])?>
        <div class="ibox-tools" style="float: right">
            <a class="edit-block-link">
                <i class="fa fa-pencil"></i>
            </a>
            <a class="dell-block-link">
                <i class="fa fa-times"></i>
            </a>
        </div>
    </div>
    <div class="ibox-content">
        <table class="table">
            <thead>
              <tr>
                 <th>Параметр</th>
                 <th>Значение</th>
              </tr>
             </thead>
            <?php
                $safeAttributes = $model->safeAttributes();
                if (empty($safeAttributes)) {
                    $safeAttributes = $model->attributes();
                }
                foreach ($model->attributes() as $attribute) {
                    if (in_array($attribute, $safeAttributes)) {
                        echo $model->generateActiveValue($attribute,$model,$page_block);
                    }
                }

                if (!empty($widget->childs)) {
                    echo "<tr><td colspan='2'>" . Html::a('<i class="fa fa-pencil"></i> Управление блоками', ['page/manage-blocks', 'parent_id' => $page_block->id]) . "</td></tr>";
                }
            ?>
        </table>
    </div>
<?=Html::endTag('div')?>