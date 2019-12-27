<?php

use yii\db\Migration;

/**
 * Handles the creation of table `floor_plan`.
 */
class m171114_133657_create_floor_plan_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp() {
        $this->createTable('floor_plan', [
            'id' => $this->primaryKey(),
            'corpus_num' => $this->string(50),
            'section_num' => $this->string(50),
            'floor_num_starts' => $this->smallInteger(),
            'floor_num_ends' => $this->smallInteger(),
            'number_on_floor' => $this->smallInteger(),
            'external_id' => $this->string(),

            'file_id' => $this->integer(),
            'complex_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression("NOW()"),
            'updated_at' => $this->timestamp()->defaultExpression("NOW()"),
        ]);

        $this->addForeignKey('floor_plan-complex_id-fkey', 'floor_plan', 'complex_id', 'complex', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('floor_plan-file_id-fkey', 'floor_plan', 'file_id', 'file', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('floor_plan-corpus_num-idx', 'floor_plan', 'corpus_num');
        $this->createIndex('floor_plan-section_num-idx', 'floor_plan', 'section_num');
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->dropIndex('floor_plan-section_num-idx', 'floor_plan');
        $this->dropIndex('floor_plan-corpus_num-idx', 'floor_plan');
        $this->dropForeignKey('floor_plan-file_id-fkey', 'floor_plan');
        $this->dropForeignKey('floor_plan-complex_id-fkey', 'floor_plan');
        $this->dropTable('floor_plan');
    }
}
