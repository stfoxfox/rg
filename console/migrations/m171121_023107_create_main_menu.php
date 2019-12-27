<?php

use yii\db\Migration;
use common\models\Menu;
use common\models\MenuItem;

/**
 * Class m171121_023107_create_main_menu
 */
class m171121_023107_create_main_menu extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp() {
        Menu::deleteAll();

        $menu = new Menu([
            'title' => 'Главное меню',
            'description' => 'Главное меню наверху страницы',
            'type' => Menu::TYPE_MAIN,
            'status' => Menu::STATUS_ENABLED,
        ]);
        $menu->save(false);

        $item = new MenuItem([
            'title' => 'О застройщике',
            'controller' => 'site',
            'action' => 'about',
            'sort' => 1,
            'status' => MenuItem::STATUS_ENABLED,
            'menu_id' => $menu->id
        ]);
        $item->save(false);

        $item = new MenuItem([
            'title' => 'Подбор квартиры',
            'controller' => 'flats',
            'action' => 'index',
            'sort' => 2,
            'status' => MenuItem::STATUS_ENABLED,
            'menu_id' => $menu->id
        ]);
        $item->save(false);

        $item = new MenuItem([
            'title' => 'Документы',
            'controller' => 'site',
            'action' => 'documents',
            'sort' => 3,
            'status' => MenuItem::STATUS_ENABLED,
            'menu_id' => $menu->id
        ]);
        $item->save(false);

        $menu = new Menu([
            'title' => 'Футер',
            'description' => 'Меню в подвале страницы',
            'type' => Menu::TYPE_FOOTER,
            'status' => Menu::STATUS_ENABLED,
        ]);
        $menu->save(false);

        $item = new MenuItem([
            'title' => 'Документы',
            'controller' => 'site',
            'action' => 'documents',
            'sort' => 1,
            'status' => MenuItem::STATUS_ENABLED,
            'menu_id' => $menu->id
        ]);
        $item->save(false);

        $item = new MenuItem([
            'title' => 'О застройщике',
            'controller' => 'site',
            'action' => 'about',
            'sort' => 2,
            'status' => MenuItem::STATUS_ENABLED,
            'menu_id' => $menu->id
        ]);
        $item->save(false);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m171121_023107_create_main_menu cannot be reverted.\n";

        return true;
    }
}
