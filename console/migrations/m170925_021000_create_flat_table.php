<?php

use yii\db\Migration;

/**
 * Handles the creation of table `flat`.
 */
class m170925_021000_create_flat_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp() {
        $this->createTable('flat', [
            'id' => $this->primaryKey(),
            'type' => $this->smallInteger()->defaultValue(0),
            'number' => $this->string(50),
            'rooms_count' => $this->smallInteger(),
            'total_area' => $this->float(3),
            'live_area' => $this->float(3),
            'kitchen_area' => $this->float(3),
            'currency' => $this->integer(),
            'price' => $this->float(3),
            'sale_price' => $this->float(3),
            'total_price' => $this->float(3),
            'status' => $this->smallInteger()->defaultValue(0),
            'number_on_floor' => $this->smallInteger(),
            'binding' => $this->string(),
            'garage' => $this->boolean()->defaultValue(false),
            'decoration' => $this->string(),
            'furniture' => $this->boolean()->defaultValue(false),
            'features' => $this->string(),
            'object_id' => $this->string(),
            'external_id' => $this->string(),

            'floor_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression("NOW()"),
            'updated_at' => $this->timestamp()->defaultExpression("NOW()"),
        ]);

        $this->addForeignKey('flat-floor_id-fkey', 'flat', 'floor_id', 'floor', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('flat-floor_id-idx', 'flat', 'floor_id');
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->dropIndex('flat-floor_id-idx', 'flat');
        $this->dropForeignKey('flat-floor_id-fkey', 'flat');
        $this->dropTable('flat');
    }
}
