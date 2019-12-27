<?php

use yii\db\Migration;

/**
 * Class m171110_013823_fix_section_num
 */
class m171110_013823_fix_section_num extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp() {
        $this->alterColumn('section', 'number', $this->string(50));
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171110_013823_fix_section_num cannot be reverted.\n";

        return true;
    }
}
