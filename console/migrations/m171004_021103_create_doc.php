<?php

use yii\db\Migration;

class m171004_021103_create_doc extends Migration
{
    public function safeUp() {
        $this->createTable('doc_category', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'sort' => $this->integer()->defaultValue(0),
            'created_at' => $this->timestamp()->defaultExpression("NOW()"),
            'updated_at' => $this->timestamp()->defaultExpression("NOW()"),
        ]);

        $this->createTable('doc', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'category_id' => $this->integer(),
            'complex_id' => $this->integer(),
            'corpus_num' => $this->integer(),
            'section_id' => $this->integer(),
            'sort' => $this->integer()->defaultValue(0),
            'created_at' => $this->timestamp()->defaultExpression("NOW()"),
            'updated_at' => $this->timestamp()->defaultExpression("NOW()"),
        ]);

        $this->createTable('doc_version', [
            'id' => $this->primaryKey(),
            'version' => $this->string(),
            'doc_date' => $this->date(),
            'doc_id' => $this->integer(),
            'file_id' => $this->integer(),
            'created_at' => $this->timestamp()->defaultExpression("NOW()"),
            'updated_at' => $this->timestamp()->defaultExpression("NOW()"),
        ]);

        $this->addForeignKey('doc-catefory_id-fkey', 'doc', 'category_id', 'doc_category', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('doc-complex_id-fkey', 'doc', 'complex_id', 'complex', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('doc-section_id-fkey', 'doc', 'section_id', 'section', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('doc-corpus_num-idx', 'doc', 'corpus_num');

        $this->addForeignKey('doc_version-doc_id-fkey', 'doc_version', 'doc_id', 'doc', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('doc_version-file_id-fkey', 'doc_version', 'file_id', 'file', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown() {
        $this->dropForeignKey('doc_version-file_id-fkey', 'doc_version');
        $this->dropForeignKey('doc_version-doc_id-fkey', 'doc_version');
        $this->dropIndex('doc-corpus_num-idx', 'doc');
        $this->dropForeignKey('doc-section_id-fkey', 'doc');
        $this->dropForeignKey('doc-complex_id-fkey', 'doc');
        $this->dropForeignKey('doc-catefory_id-fkey', 'doc');

        $this->dropTable('doc_version');
        $this->dropTable('doc');
        $this->dropTable('doc_category');
    }

}
