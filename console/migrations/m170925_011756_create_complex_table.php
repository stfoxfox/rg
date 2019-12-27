<?php
use yii\db\Migration;

/**
 * Handles the creation of table `complex`.
 */
class m170925_011756_create_complex_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp() {
        $this->createTable('complex', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'min_price' => $this->float(3),
            'max_price' => $this->float(3),
            'max_area' => $this->float(3),
            'external_id' => $this->string(),

            'created_at' => $this->timestamp()->defaultExpression("NOW()"),
            'updated_at' => $this->timestamp()->defaultExpression("NOW()"),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->dropTable('complex');
    }
}
