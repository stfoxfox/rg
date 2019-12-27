<?php
use yii\helpers\Html;
use backend\assets\custom\PageBlocksAsset;

/**
 * @var \yii\web\View $this
 * @var \common\models\Page $item
 * @var array $menu
 * @var array $blocks
 * @var integer $possible_parent_id
 */
PageBlocksAsset::register($this);
?>

<div class="row">
    <div class="col-md-12" >

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins" >
                    <div class="ibox-title">
                        <h5>Контент</h5>
                        <?=Html::hiddenInput('block_sort',null,['id'=>"block_sort"])?>
                        <div class="pull-right btn-group">
                            <?=$this->render('_add_list', [
                                'provider' => $menu,
                                'page' => $item,
                                'possible_parent_id' => $possible_parent_id
                            ])?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="row" id="sortable-view">
                    <?=$this->render('_blocks', [
                        'provider' => $blocks,
                    ])?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Контент</h5>
                        <div class="pull-right btn-group">
                            <?=$this->render('_add_list', [
                                'provider' => $menu,
                                'page' => $item,
                                'possible_parent_id' => $possible_parent_id
                            ])?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

