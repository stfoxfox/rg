<?php
/**
 * @var $page \common\models\Page
 */

if (!empty($page->rootBlocks)) {
    foreach ($page->rootBlocks as $key => $block) {
        echo $block->dataWidget;
    }
}