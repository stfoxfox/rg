<?php

use yii\db\Migration;

/**
 * Handles the creation of table `promo`.
 */
class m170927_073802_create_promo_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp() {
        $this->createTable('promo', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'file_id' => $this->integer(),
            'description' => $this->text(),
            'external_id' => $this->string(),
            'date_to' => $this->date(),
            'status' => $this->smallInteger()->defaultValue(0),
            'sort' => $this->integer()->defaultValue(0),
            'created_at' => $this->timestamp()->defaultExpression("NOW()"),
            'updated_at' => $this->timestamp()->defaultExpression("NOW()"),
        ]);

        $this->addForeignKey('promo-file_id-fkey', 'promo', 'file_id', 'file', 'id', 'SET NULL', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->dropForeignKey('promo-file_id-fkey', 'promo');
        $this->dropTable('promo');
    }
}
