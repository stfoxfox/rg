<?php
use yii\db\Migration;

class m171006_080320_create_bank_mortgage_tables extends Migration
{
    public function safeUp() {
        $this->createTable('bank', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'license' => $this->string(),
            'date_license' => $this->date(),
            'sort' => $this->integer()->defaultValue(0),
            'external_id' => $this->string(),
            'created_at' => $this->timestamp()->defaultExpression("NOW()"),
            'updated_at' => $this->timestamp()->defaultExpression("NOW()"),
        ]);

        $this->createTable('mortgage', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'min_cash' => $this->float(3),
            'percent_rate' => $this->float(3),
            'max_period' => $this->smallInteger(),
            'max_amount' => $this->integer(),
            'is_military' => $this->boolean(),
            'is_priority' => $this->boolean(),
            'sort' => $this->integer()->defaultValue(0),
            'bank_id' => $this->integer()->notNull(),
            'external_id' => $this->string(),
            'created_at' => $this->timestamp()->defaultExpression("NOW()"),
            'updated_at' => $this->timestamp()->defaultExpression("NOW()"),
        ]);

        $this->createIndex('bank-external_id-idx', 'bank', 'external_id');
        $this->createIndex('mortgage-external_id-idx', 'mortgage', 'external_id');
        $this->addForeignKey('mortgage-bank_id-fkey', 'mortgage', 'bank_id', 'bank', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown() {
        $this->dropForeignKey('mortgage-bank_id-fkey', 'mortgage');
        $this->dropIndex('mortgage-external_id-idx', 'mortgage');
        $this->dropIndex('bank-external_id-idx', 'bank');

        $this->dropTable('mortgage');
        $this->dropTable('bank');
    }
}
