<?php

use yii\db\Migration;

class m170913_203939_add_catalog_gallery extends Migration
{
    public function safeUp()
    {

        $this->createTable('catalog_item_image', array(
            'catalog_item_id' => $this->integer()->notNull(),
            'file_id' => $this->integer()->notNull(),
            'PRIMARY KEY(file_id, catalog_item_id)'
        ));
        $this->addForeignKey('catalog_item_image-file_id-fkey', 'catalog_item_image', 'file_id', 'file', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('catalog_item_image-file_id-idx', 'catalog_item_image', 'file_id');
        $this->addForeignKey('catalog_item_image-catalog_item-fkey', 'catalog_item_image', 'catalog_item_id', 'catalog_item', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('catalog_item_image-page_id-idx', 'catalog_item_image', 'catalog_item_id');
    }

    public function safeDown()
    {
        echo "m170913_203939_add_catalog_gallery cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170913_203939_add_catalog_gallery cannot be reverted.\n";

        return false;
    }
    */
}
