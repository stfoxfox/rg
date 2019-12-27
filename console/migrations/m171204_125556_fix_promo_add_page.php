<?php

use yii\db\Migration;

/**
 * Class m171204_125556_fix_promo_add_page
 */
class m171204_125556_fix_promo_add_page extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp() {
        $this->addColumn('promo', 'page_id', $this->integer());
        $this->addForeignKey('promo-page_id-fkey', 'promo', 'page_id', 'page', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->dropForeignKey('promo-page_id-fkey', 'promo');
        $this->dropColumn('promo', 'page_id');
    }

}
