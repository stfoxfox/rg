<?php

use yii\db\Migration;

class m171003_003800_fix_gallery_item_table extends Migration
{
    public function safeUp() {
        $this->addColumn('gallery_item', 'photo_date', $this->date()->after('gallery_id'));
        $this->addColumn('gallery_item', 'complex_id', $this->integer()->after('photo_date'));
        $this->addColumn('gallery_item', 'corpus_num', $this->integer()->after('complex_id'));

        $this->addForeignKey('gallery_item-complex_id-fkey', 'gallery_item', 'complex_id', 'complex', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('gallery_item-corpus_num-idx', 'gallery_item', 'corpus_num');
    }

    public function safeDown() {
        $this->dropForeignKey('gallery_item-complex_id-fkey', 'gallery_item');
        $this->dropIndex('gallery_item-corpus_num-idx', 'gallery_item');
        $this->dropColumn('gallery_item', 'photo_date');
        $this->dropColumn('gallery_item', 'complex_id');
        $this->dropColumn('gallery_item', 'corpus_num');
    }
}
