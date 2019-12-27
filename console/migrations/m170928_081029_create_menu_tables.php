<?php

use yii\db\Migration;

class m170928_081029_create_menu_tables extends Migration
{
    public function safeUp() {
        $this->createTable('menu', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'description' => $this->text(),
            'type' => $this->smallInteger()->defaultValue(0),
            'status' => $this->smallInteger()->defaultValue(0),
            'created_at' => $this->timestamp()->defaultExpression("NOW()"),
            'updated_at' => $this->timestamp()->defaultExpression("NOW()"),
        ]);

        $this->createTable('menu_item', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'icon' => $this->string(),
            'url' => $this->string(),
            'controller' => $this->string(),
            'action' => $this->string(),
            'params' => $this->string(),
            'status' => $this->smallInteger()->defaultValue(0),
            'sort' => $this->integer(),
            'parent_id' => $this->integer(),
            'menu_id' => $this->integer(),
            'created_at' => $this->timestamp()->defaultExpression("NOW()"),
            'updated_at' => $this->timestamp()->defaultExpression("NOW()"),
        ]);

        $this->addForeignKey('menu_item-parent_id-fkey', 'menu_item', 'parent_id', 'menu_item', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('menu_item-menu_id-fkey', 'menu_item', 'menu_id', 'menu', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown() {
        $this->dropForeignKey('menu_item-menu_id-fkey', 'menu_item');
        $this->dropForeignKey('menu_item-parent_id-fkey', 'menu_item');

        $this->dropTable('menu_item');
        $this->dropTable('menu');
    }

}
