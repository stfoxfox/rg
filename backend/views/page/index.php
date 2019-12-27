<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 03/07/2017
 * Time: 01:20
 * @var \yii\web\View $this
 */

use common\components\MyExtensions\MyImagePublisher;
use yii\helpers\Url;

\common\SharedAssets\DeleteAsset::register($this)
?>

<div class="row">

    <div class="col-lg-12 animated fadeInRight">



        <div class="row">
            <div class="col-lg-12">


                <div class="ibox ">
                    <div class="ibox-title">
                        <h5></h5>

                        <div class="pull-right">
                            <a  class="btn btn-outline btn-primary btn-xs" href="<?=Url::toRoute(['add'])?>">
                                Добавить страницу
                            </a>

                        </div>
                    </div>
                    <div class="ibox-content">


                        <table class="table">
                            <thead>
                            <tr>
                                <th>Название</th>
                                <th>Управление блоками</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody id="sortable">

                            <?php
                            /** @var \common\models\Course $item */
                            foreach($items as $item)  { ?>
                                <tr id="item_<?=$item->id?>">
                                    <td><?=$item->title?></td>
                                    <td> <a href="<?=Url::toRoute(['blocks','id'=>$item->id])?>"?>Редактировать</a> </td>
                                    <td>
                                        <a href="<?=Url::toRoute(['edit','id'=>$item->id])?>">Изменить</a> |
                                        <a href="#" class="dell-item" data-dell-url="<?=Url::toRoute(['dell'])?>" data-item-id="<?=$item->id?>" data-item-name="<?=$item->title?>">Удалить</a>
                                    </td>
                                </tr>
                            <?php  } ?>

                            </tbody>
                        </table>

                        <?= \yii\widgets\LinkPager::widget([
                            'pagination' => $pages,
                        ]);?>


                    </div>
                </div>


            </div>
        </div>



    </div>
</div>
