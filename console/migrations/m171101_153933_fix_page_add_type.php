<?php

use yii\db\Migration;

class m171101_153933_fix_page_add_type extends Migration
{
    public function safeUp() {
        $this->dropColumn('page', 'is_index_page');
        $this->addColumn('page', 'type', $this->smallInteger());
    }

    public function safeDown() {
        $this->dropColumn('page', 'type');
        $this->addColumn('page', 'is_index_page', $this->boolean()->defaultValue(false));
    }
}
