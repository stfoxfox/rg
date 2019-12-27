<?php

use yii\db\Migration;
use common\models\SiteSettings;

/**
 * Handles the creation of table `feedback`.
 */
class m171108_012549_create_feedback_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp() {
        $this->createTable('feedback', [
            'id' => $this->primaryKey(),
            'type' => $this->smallInteger(),
            'status' => $this->smallInteger(),
            'name' => $this->string(),
            'email' => $this->string(),
            'phone' => $this->string(50),
            'message' => $this->text(),
            'extra' => $this->text(),
            'flat_id' => $this->integer(),
            'user_id' => $this->integer(),
            'created_at' => $this->timestamp()->defaultExpression("NOW()"),
            'updated_at' => $this->timestamp()->defaultExpression("NOW()"),
        ]);

        $this->addForeignKey('feedback-flat_id-fkey', 'feedback', 'flat_id', 'flat', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('feedback-user_id-fkey', 'feedback', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');

        $email = SiteSettings::findOne(['text_key' => 'feedback_email']);
        if (!$email) {
            $setting = new SiteSettings([
                'title' => 'Email для запросов обратной связи',
                'text_key' => 'feedback_email',
                'type' => SiteSettings::SiteSettings_TypeString,
                'string_value' => 'helpdesc@site.ru',
            ]);
            $setting->save(false);
        }
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->dropForeignKey('feedback-user_id-fkey', 'feedback');
        $this->dropForeignKey('feedback-flat_id-fkey', 'feedback');

        $this->dropTable('feedback');
    }
}
