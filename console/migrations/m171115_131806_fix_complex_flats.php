<?php

use yii\db\Migration;

/**
 * Class m171115_131806_fix_complex_flats
 */
class m171115_131806_fix_complex_flats extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp() {
        $this->addColumn('complex', 'is_active', $this->smallInteger());
        $this->addColumn('flat', 'floor_plan_id', $this->integer());
        $this->addForeignKey('flat-floor_plan_id-fkey', 'flat', 'floor_plan_id', 'floor_plan', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->dropForeignKey('flat-floor_plan_id-fkey', 'flat');
        $this->dropColumn('flat', 'floor_plan_id');
        $this->dropColumn('complex', 'is_active');
    }
}
