<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_oauth`.
 */
class m171129_143424_create_user_oauth_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp() {
        $this->createTable('user_oauth', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'provider_id' => $this->integer(),
            'provider_user_id' => $this->string(),
            'created_at' => $this->timestamp()->defaultExpression("NOW()"),
            'updated_at' => $this->timestamp()->defaultExpression("NOW()"),
        ]);

        $this->addForeignKey('user_oauth-user_id-fkey', 'user_oauth', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->dropForeignKey('user_oauth-user_id-fkey', 'user_oauth');
        $this->dropTable('user_oauth');
    }
}
