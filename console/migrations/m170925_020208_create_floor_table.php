<?php
use yii\db\Migration;

/**
 * Handles the creation of table `floor`.
 */
class m170925_020208_create_floor_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp() {
        $this->createTable('floor', [
            'id' => $this->primaryKey(),
            'number' => $this->string(),
            'flats_count' => $this->integer(),

            'section_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression("NOW()"),
            'updated_at' => $this->timestamp()->defaultExpression("NOW()"),
        ]);

        $this->addForeignKey('floor-section_id-fkey', 'floor', 'section_id', 'section', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('floor-section_id-idx', 'floor', 'section_id');
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->dropIndex('floor-section_id-idx', 'floor');
        $this->dropForeignKey('floor-section_id-fkey', 'floor');
        $this->dropTable('floor');
    }
}
