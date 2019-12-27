<?php

use yii\db\Migration;

class m171017_145615_add_settings extends Migration
{
    public function safeUp()
    {
        $this->addColumn('site_settings','model_id',$this->integer());
        $this->addColumn('site_settings','model_class',$this->string());



    }

    public function safeDown()
    {
        echo "m171017_145615_add_settings cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171017_145615_add_settings cannot be reverted.\n";

        return false;
    }
    */
}
