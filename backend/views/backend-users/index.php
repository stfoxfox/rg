<?php

/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 21/06/2017
 * Time: 00:03
 *
 * @var  View $this
 */

use common\models\BackendUser;
use backend\widgets\editable\EditableWidget;
use yii\helpers\Url;
use yii\web\View;

/* @var $users BackendUser[] */

\common\SharedAssets\DeleteAsset::register($this);


?>



<div class="row">

    <div class="col-lg-12 animated fadeInRight">



        <div class="row">
            <div class="col-lg-12">


                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Список администраторов</h5>

                        <div class="pull-right">
                            <a  class="btn btn-outline btn-primary btn-xs" href="<?= Url::toRoute(['add-item']) ?>">
                                Добавить
                            </a>

                        </div>
                    </div>
                    <div class="ibox-content">


                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Логин</th>
                                    <th>Имя</th>
                                    <th>Почта </th>
                                    <th>Роли</th>
                                    <th>Действия </th>
                                </tr>
                            </thead>
                            <tbody id="sortable">

                                <?php
                                /** @var BackendUser $item */
                                foreach ($users as $item):
                                    ?>
                                    <tr id="item_<?= $item->id ?>">
                                        <td><?= $item->username ?></td>
                                        <td>
                                            <?=
                                            EditableWidget::widget([
                                                'name' => 'name',
                                                'value' => $item->name,
                                                'pk' => $item->id,
                                                'url' => ['editable'],
                                            ])
                                            ?>
                                        </td>
                                        <td>
                                            <?=
                                            EditableWidget::widget([
                                                'name' => 'email',
                                                'value' => $item->email,
                                                'pk' => $item->id,
                                                'url' => ['editable'],
                                            ])
                                            ?>
                                        </td>
                                        <td>
                                            <a href="#" data-mode="popup" data-value='[<?= $item->getRolesList() ?>]' data-source='<?= BackendUser::getFullRolesList() ?>'  data-type="checklist" data-url="<?= Url::toRoute(['backend-users/item-edit-roles']) ?>" data-pk="<?= $item->id ?>" data-placement="right" data-placeholder="Значение" data-title="Имя" class="editable editable-click item-settings" data-original-title="" title="" style="background-color: rgba(0, 0, 0, 0);"><?= $item->getRolesList() ?></a>
                                        </td>
                                        <td>
                                            <a href="<?= Url::toRoute(['edit', 'id' => $item->id]) ?>">Изменить</a> |
                                            <a href="#" class="dell-item" data-dell-url="<?=Url::toRoute(['dell'])?>" data-item-id="<?=$item->id?>" data-item-name="<?=$item->name?>">Удалить</a>

                                                </td>

                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>




                    </div>
                </div>


            </div>
        </div>



    </div>
</div>

