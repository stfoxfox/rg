<?php

use yii\db\Migration;

/**
 * Handles the creation of table `corpus`.
 */
class m171012_022802_create_corpus_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('corpus', [
            'id' => $this->primaryKey(),
            'corpus_num' => $this->string()->notNull(),
            'page_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression("NOW()"),
            'updated_at' => $this->timestamp()->defaultExpression("NOW()"),
        ]);

        $this->createIndex('corpus-corpus_num-idx', 'corpus', 'corpus_num');
        $this->addForeignKey('corpus-page_id-fkey', 'corpus', 'page_id', 'page', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('corpus-page_id-fkey', 'corpus');
        $this->dropIndex('corpus-corpus_num-idx', 'corpus');
        $this->dropTable('corpus');
    }
}
