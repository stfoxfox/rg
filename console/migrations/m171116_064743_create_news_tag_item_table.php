<?php

use yii\db\Migration;

/**
 * Handles the creation of table `news_tag_item`.
 */
class m171116_064743_create_news_tag_item_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp() {
        $this->createTable('news_tag_item', [
            'news_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression("NOW()"),
            'updated_at' => $this->timestamp()->defaultExpression("NOW()"),
        ]);

        $this->addPrimaryKey('news_tag_item-pkey', 'news_tag_item', ['news_id', 'tag_id']);
        $this->addForeignKey('news_tag_item-news_id-fkey', 'news_tag_item', 'news_id', 'news', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('news_tag_item-tag_id-fkey', 'news_tag_item', 'tag_id', 'news_tag', 'id', 'CASCADE', 'CASCADE');

        $this->dropForeignKey('news_tag-news_id-fkey', 'news_tag');
        $this->dropColumn('news_tag', 'news_id');
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->dropForeignKey('news_tag_item-tag_id-fkey', 'news_tag_item');
        $this->dropForeignKey('news_tag_item-news_id-fkey', 'news_tag_item');
        $this->dropPrimaryKey('news_tag_item-pkey', 'news_tag_item');
        $this->dropTable('news_tag_item');

        $this->addColumn('news_tag', 'news_id', $this->integer());
        $this->addForeignKey('news_tag-news_id-fkey', 'news_tag', 'news_id', 'news', 'id', 'CASCADE', 'CASCADE');
    }
}
