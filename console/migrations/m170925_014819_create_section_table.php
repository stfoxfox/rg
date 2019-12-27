<?php
use yii\db\Migration;

/**
 * Handles the creation of table `section`.
 */
class m170925_014819_create_section_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp() {
        $this->createTable('section', [
            'id' => $this->primaryKey(),
            'number' => $this->integer(),
            'corpus_num' => $this->integer(),
            'floors_count' => $this->integer(),
            'quarter' => $this->string(),
            'status' => $this->smallInteger()->defaultValue(0),
            'series' => $this->string(),
            'registration' => $this->string(),

            'complex_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression("NOW()"),
            'updated_at' => $this->timestamp()->defaultExpression("NOW()"),
        ]);

        $this->addForeignKey('section-complex_id-fkey', 'section', 'complex_id', 'complex', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('section-complex_id-idx', 'section', 'complex_id');
        $this->createIndex('section-corpus_num-idx', 'section', 'corpus_num');
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->dropIndex('section-complex_id-idx', 'section');
        $this->dropIndex('section-corpus_num-idx', 'section');
        $this->dropForeignKey('section-complex_id-fkey', 'section');
        $this->dropTable('section');
    }
}
