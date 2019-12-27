<?php

use yii\db\Migration;
use common\models\Page;

class m171101_155802_create_main_page extends Migration
{
    public function safeUp() {
        $page = Page::findOne(['type' => Page::TYPE_MAIN]);
        if (!$page) {
            $page = new Page(['title' => 'Главная', 'slug' => 'main', 'type' => Page::TYPE_MAIN]);
            $page->save(false);
        }

        return true;
    }

    public function safeDown() {
        echo "m171101_155802_create_main_page cannot be reverted.\n";

        return true;
    }

}
