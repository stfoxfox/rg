<?php

use yii\db\Migration;

/**
 * Handles the creation of table `contact`.
 */
class m171012_022153_create_contact_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('contact', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'address' => $this->string(),
            'hours' => $this->string(),
            'phones' => $this->string(),
            'email' => $this->string(),
            'sort' => $this->integer()->defaultValue(0),
            'created_at' => $this->timestamp()->defaultExpression("NOW()"),
            'updated_at' => $this->timestamp()->defaultExpression("NOW()"),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('contact');
    }
}
