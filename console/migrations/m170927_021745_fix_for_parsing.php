<?php

use yii\db\Migration;

class m170927_021745_fix_for_parsing extends Migration
{
    public function safeUp() {
        $this->addColumn('complex', 'min_area', $this->float(3)->after('max_price'));

        $this->dropIndex('section-corpus_num-idx', 'section');
        $this->dropColumn('section', 'corpus_num');
        $this->addColumn('section', 'corpus_num', $this->string()->after('number'));
        $this->createIndex('section-corpus_num-idx', 'section', 'corpus_num');
        $this->dropColumn('section', 'registration');
        $this->addColumn('section', 'decoration', $this->string()->after('series'));

        $this->dropColumn('floor', 'number');
        $this->addColumn('floor', 'number', $this->smallInteger()->after('id'));

        $this->createIndex('complex-external_id-idx', 'complex', 'external_id');
        $this->createIndex('section-number-idx', 'section', 'number');
        $this->createIndex('floor-number-idx', 'floor', 'number');
        $this->createIndex('flat-external_id-idx', 'flat', 'external_id');
    }

    public function safeDown() {
        $this->dropColumn('complex', 'min_area');
        $this->alterColumn('floor', 'number', $this->string());

        $this->dropIndex('section-corpus_num-idx', 'section');
        $this->dropColumn('section', 'corpus_num');
        $this->addColumn('section', 'corpus_num', $this->integer()->after('number'));
        $this->createIndex('section-corpus_num-idx', 'section', 'corpus_num');
        $this->dropColumn('section', 'decoration');
        $this->addColumn('section', 'registration', $this->string()->after('series'));

        $this->dropIndex('complex-external_id-idx', 'complex');
        $this->dropIndex('section-number-idx', 'section');
        $this->dropIndex('floor-number-idx', 'floor');
        $this->dropIndex('flat-external_id-idx', 'flat');
    }
}
