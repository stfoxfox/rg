<?php

use yii\db\Migration;

class m171017_003151_fix_page_block_table extends Migration
{
    public function safeUp() {
        $this->addColumn('page_block', 'parent_id', $this->integer());
        $this->addForeignKey('page_block-parent_id-fkey', 'page_block', 'parent_id', 'page_block', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown() {
        $this->dropForeignKey('page_block-parent_id-fkey', 'page_block');
        $this->dropColumn('page_block', 'parent_id');
    }
}
