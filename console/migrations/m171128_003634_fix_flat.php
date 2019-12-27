<?php

use yii\db\Migration;

/**
 * Class m171128_003634_fix_flat
 */
class m171128_003634_fix_flat extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp() {
        $this->dropColumn('flat', 'decoration');
        $this->dropColumn('flat', 'features');
        $this->addColumn('flat', 'decoration', $this->text());
        $this->addColumn('flat', 'features', $this->text());
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171128_003634_fix_flat cannot be reverted.\n";
        return true;
    }
}
