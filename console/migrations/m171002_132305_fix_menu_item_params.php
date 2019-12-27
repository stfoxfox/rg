<?php

use yii\db\Migration;

class m171002_132305_fix_menu_item_params extends Migration
{
    public function safeUp() {
        $this->alterColumn('menu_item', 'params', $this->text());

    }

    public function safeDown() {
        $this->alterColumn('menu_item', 'params', $this->string());
    }

}
