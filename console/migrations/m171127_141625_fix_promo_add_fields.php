<?php

use yii\db\Migration;

/**
 * Class m171127_141625_fix_promo_add_fields
 */
class m171127_141625_fix_promo_add_fields extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp() {
        $this->addColumn('promo', 'type', $this->smallInteger());
        $this->addColumn('promo', 'avatar_id', $this->integer());
        $this->addColumn('promo', 'manager', $this->string());
        $this->addColumn('promo', 'manager_phone', $this->string(50));
        $this->addColumn('promo', 'button_text', $this->string());
        $this->addColumn('promo', 'button_link', $this->string());

        $this->addForeignKey('promo-avatar_id-fkey', 'promo', 'avatar_id', 'file', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->dropForeignKey('promo-avatar_id-fkey', 'promo');

        $this->dropColumn('promo', 'button_link');
        $this->dropColumn('promo', 'button_text');
        $this->dropColumn('promo', 'manager_phone');
        $this->dropColumn('promo', 'manager');
        $this->dropColumn('promo', 'avatar_id');
        $this->dropColumn('promo', 'type');
    }
}
