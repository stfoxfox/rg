<?php

use yii\db\Migration;

class m171006_004851_create_file_type_field extends Migration
{
    public function safeUp() {
        $this->addColumn('file', 'type', $this->string()->after('description'));
        $this->addColumn('file', 'original_name', $this->string()->after('type'));
    }

    public function safeDown() {
        $this->dropColumn('file', 'type');
        $this->dropColumn('file', 'original_name');
    }

}
