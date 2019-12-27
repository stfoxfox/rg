<?php

use common\models\SiteSettings;
use yii\db\Migration;

class m171017_150323_create_settings extends Migration
{
    public function safeUp()
    {



        $item = new SiteSettings();
        $item->title = "Ид комплекса в 1С";
        $item->text_key="complexId";
        $item->type=SiteSettings::SiteSettings_TypeString;
        $item->sort=1;
       // $item->string_value= $mainHeader->title;
        $item->save();
    }

    public function safeDown()
    {
        echo "m171017_150323_create_settings cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171017_150323_create_settings cannot be reverted.\n";

        return false;
    }
    */
}
