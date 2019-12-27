<?php

use yii\db\Migration;
use common\models\Page;

/**
 * Class m171127_015143_create_contacts_page
 */
class m171127_015143_create_contacts_page extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp() {
        $page = Page::findOne(['type' => Page::TYPE_CONTACT]);
        if (!$page) {
            $page = new Page(['title' => 'Контакты', 'slug' => 'contacts', 'type' => Page::TYPE_CONTACT]);
            $page->save(false);
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171127_015143_create_contacts_page cannot be reverted.\n";
        return true;
    }
}
