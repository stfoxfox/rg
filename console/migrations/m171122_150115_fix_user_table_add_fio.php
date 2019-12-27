<?php

use yii\db\Migration;

/**
 * Class m171122_150115_fix_user_table_add_fio
 */
class m171122_150115_fix_user_table_add_fio extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp() {
        $this->addColumn('user', 'first_name', $this->string());
        $this->addColumn('user', 'last_name', $this->string());
        $this->addColumn('user', 'gender', $this->smallInteger());
        $this->addColumn('user', 'birthday', $this->date());
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->dropColumn('user', 'first_name');
        $this->dropColumn('user', 'last_name');
        $this->dropColumn('user', 'gender');
        $this->dropColumn('user', 'birthday');
    }
}
