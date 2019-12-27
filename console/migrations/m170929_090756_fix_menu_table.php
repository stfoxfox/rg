<?php

use yii\db\Migration;

class m170929_090756_fix_menu_table extends Migration
{
    public function safeUp() {
        $this->dropForeignKey('menu_item-parent_id-fkey', 'menu_item');
        $this->addForeignKey('menu_item-parent_id-fkey', 'menu_item', 'parent_id', 'menu_item', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown() {
        $this->dropForeignKey('menu_item-parent_id-fkey', 'menu_item');
        $this->addForeignKey('menu_item-parent_id-fkey', 'menu_item', 'parent_id', 'menu_item', 'id', 'SET NULL', 'CASCADE');
    }
}
