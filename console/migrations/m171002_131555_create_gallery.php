<?php

use yii\db\Migration;

class m171002_131555_create_gallery extends Migration
{
    public function safeUp() {
        $this->createTable('gallery', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'description' => $this->text(),
            'type' => $this->smallInteger()->defaultValue(0),
            'created_at' => $this->timestamp()->defaultExpression("NOW()"),
            'updated_at' => $this->timestamp()->defaultExpression("NOW()"),
        ]);

        $this->createTable('gallery_item', [
            'id' => $this->primaryKey(),
            'file_id' => $this->integer(),
            'gallery_id' => $this->integer(),
            'sort' => $this->integer()->defaultValue(0),
            'created_at' => $this->timestamp()->defaultExpression("NOW()"),
            'updated_at' => $this->timestamp()->defaultExpression("NOW()"),
        ]);

        $this->addForeignKey('gallery_item-file_id-fkey', 'gallery_item', 'file_id', 'file', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('gallery_item-gallery_id-fkey', 'gallery_item', 'gallery_id', 'gallery', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown() {
        $this->dropForeignKey('gallery_item-file_id-fkey', 'gallery_item');
        $this->dropForeignKey('gallery_item-gallery_id-fkey', 'gallery_item');

        $this->dropTable('gallery_item');
        $this->dropTable('gallery');
    }
}
