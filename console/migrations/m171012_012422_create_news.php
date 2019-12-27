<?php

use yii\db\Migration;

class m171012_012422_create_news extends Migration
{
    public function safeUp() {
        $this->createTable('news', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'news_date' => $this->date(),
            'short_text' => $this->string(),
            'full_text' => $this->text(),
            'page_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression("NOW()"),
            'updated_at' => $this->timestamp()->defaultExpression("NOW()"),
        ]);

        $this->createTable('news_tag', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'sort' => $this->integer()->defaultValue(0),
            'news_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression("NOW()"),
            'updated_at' => $this->timestamp()->defaultExpression("NOW()"),
        ]);

        $this->addForeignKey('news-page_id-fkey', 'news', 'page_id', 'page', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('news_tag-news_id-fkey', 'news_tag', 'news_id', 'news', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown() {
        $this->dropForeignKey('news_tag-news_id-fkey', 'news_tag');
        $this->dropForeignKey('news-page_id-fkey', 'news');
        $this->dropTable('news_tag');
        $this->dropTable('news');
    }
}
