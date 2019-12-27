<?php
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $page \common\models\Page
 */
$anchors = $page->getAnchors();
?>

<?php if (count($anchors) > 0) :?>
    <div class="sidebar__container">
        <aside>
            <?=Html::ul($anchors, ['item' => function($item, $index) {
                    /** @var array $item */
                    return Html::tag('li', Html::a($item['anchor_title'], Url::current(['#' => $item['anchor']])));
                }, 'class' => 'page__nav']
            )?>
        </aside>
    </div>
<?php endif?>

