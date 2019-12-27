<?php

use yii\db\Migration;
use common\models\Flat;
use common\models\Section;

/**
 * Class m171110_080030_delete_all_flats
 */
class m171110_080030_delete_all_flats extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp() {
        Flat::deleteAll();
        Section::deleteAll();
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171110_080030_delete_all_flats cannot be reverted.\n";

        return true;
    }
}
