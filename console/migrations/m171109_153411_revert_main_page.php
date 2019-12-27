<?php

use yii\db\Migration;
use common\models\Page;

/**
 * Class m171109_153411_revert_main_page
 */
class m171109_153411_revert_main_page extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp() {
        $main = Page::findOne(['type' => Page::TYPE_MAIN]);
        if ($main) {
            $main->is_internal = false;
            $main->save(false);
        }

    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171109_153411_revert_main_page cannot be reverted.\n";

        return true;
    }
}
