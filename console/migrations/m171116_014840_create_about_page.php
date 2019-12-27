<?php

use yii\db\Migration;
use common\models\Page;

/**
 * Class m171116_014840_create_about_page
 */
class m171116_014840_create_about_page extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp() {
        $page = Page::findOne(['type' => Page::TYPE_ABOUT]);
        if (!$page) {
            $page = new Page(['title' => 'О застройщике', 'slug' => 'about', 'type' => Page::TYPE_ABOUT]);
            $page->save(false);
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171116_014840_create_about_page cannot be reverted.\n";

        return true;
    }

}
