<?php

use yii\db\Migration;

/**
 * Class m171121_071602_fix_page_add_anchor
 */
class m171121_071602_fix_page_add_anchor extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp() {
        $this->addColumn('page', 'show_anchors', $this->boolean());
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->dropColumn('page', 'show_anchors');
    }
}
