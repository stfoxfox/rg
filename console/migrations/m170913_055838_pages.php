<?php

use yii\db\Migration;

class m170913_055838_pages extends Migration
{
    public function safeUp()
    {

        $this->createTable('page', [
            'id' => $this->primaryKey(),
            'slug' => $this->string()->notNull(),
            'title' => $this->string()->notNull(),
            'description' => $this->string(),
            'html_text' => $this->text(),
            'is_index_page' => $this->boolean()->defaultValue(false),
            'is_internal' => $this->boolean()->defaultValue(false),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ]);


        $this->createTable('file', [
            'id' => $this->primaryKey(),
            'file_name' => $this->string()->notNull(),
            'is_img' => $this->boolean(),
            'title' => $this->string(),
            'description' => $this->text(),
            'sort' => $this->integer(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ]);


        $this->createTable('page_block', array(
            'id' => $this->primaryKey(),
            'page_id' => $this->integer(),
            'block_name' => $this->string(),
            'type' => $this->integer(),
            'sort' => $this->integer(),
            'data' => 'jsonb',
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ));
        $this->addForeignKey('page_block-page_id-fkey', 'page_block', 'page_id', 'page', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('page_block-page_id-idx', 'page_block', 'page_id');



        $this->createTable('page_block_image', array(
            'parent_id' => $this->integer()->notNull(),
            'file_id' => $this->integer()->notNull(),
            'page_id' => $this->integer(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
            'PRIMARY KEY(file_id, parent_id)'
        ));
        $this->addForeignKey('page_block_image-file_id-fkey', 'page_block_image', 'file_id', 'file', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('page_block_image-file_id-idx', 'page_block_image', 'file_id');
        $this->addForeignKey('page_block_image-page_id-fkey', 'page_block_image', 'parent_id', 'page_block', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('page_block_image-page_id-idx', 'page_block_image', 'parent_id');
    }

    public function safeDown()
    {
        echo "m170913_055838_pages cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170913_055838_pages cannot be reverted.\n";

        return false;
    }
    */
}
