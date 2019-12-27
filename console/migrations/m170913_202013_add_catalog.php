<?php

use yii\db\Migration;

class m170913_202013_add_catalog extends Migration
{
    public function safeUp()
    {


        $this->createTable('catalog_category', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'description' => $this->text(),
            'parent_catalog_category_id' => $this->integer(),
            'file_id'=>$this->integer(),
            'sort' => $this->integer()->defaultValue(0),
            'show_in_app' => $this->boolean()->defaultValue(true),
            'created_at' => $this->timestamp()->defaultExpression("NOW()"),
            'updated_at' => $this->timestamp()->defaultExpression("NOW()")
        ]);


        $this->addForeignKey('catalog_category-catalog_item_id-fkey', 'catalog_category', 'parent_catalog_category_id', 'catalog_category', 'id', 'SET NULL', 'CASCADE');
        $this->createIndex('catalog_category-catalog_category_id-idx', 'catalog_category', 'parent_catalog_category_id');

        $this->addForeignKey('catalog_category-file_id-fkey', 'catalog_category', 'file_id', 'file', 'id', 'SET NULL', 'CASCADE');


        $this->createTable('catalog_item', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'description' => $this->text(),
            'file_id' => $this->integer(),
            'ext_code' => $this->string(),
            'price' => $this->float(),
            'old_price' => $this->float(),
            'is_active' => $this->boolean(),
            'created_at' => $this->timestamp()->defaultExpression("NOW()"),
            'updated_at' => $this->timestamp()->defaultExpression("NOW()")
        ]);

        $this->addForeignKey('catalog_item-catalog_item_id-fkey', 'catalog_item', 'file_id', 'file', 'id', 'SET NULL', 'CASCADE');

        $this->createTable('catalog_item_category', array(
            'catalog_item_id' => $this->integer()->notNull(),
            'catalog_category_id' => $this->integer()->notNull(),
            'sort'=>$this->integer()->defaultValue(0),
            'PRIMARY KEY(catalog_category_id, catalog_item_id)'
        ));
        $this->addForeignKey('catalog_item_category-catalog_category_id-fkey', 'catalog_item_category', 'catalog_category_id', 'catalog_category', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('catalog_item_category-catalog_item_id-fkey', 'catalog_item_category', 'catalog_item_id', 'catalog_item', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('catalog_item_category-catalog_category_id-idx', 'catalog_item_category', 'catalog_category_id');
        $this->createIndex('catalog_item_category-catalog_item_id-idx', 'catalog_item_category', 'catalog_item_id');

        

    }

    public function safeDown()
    {
        $this->dropTable('catalog_item');
        $this->dropTable('catalog_category');
        
        
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170913_202013_add_catalog cannot be reverted.\n";

        return false;
    }
    */
}
