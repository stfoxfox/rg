<?php
namespace common\models;

use Yii;
use common\models\gii\BaseMenu;
use yii\helpers\ArrayHelper;

/**
 * Class Menu
 * @package common\models
 *
 * @inheritdoc
 * @property MenuItem[] $menuItems
 * @property MenuItem[] $menuItemRoots
 * @property MenuItem[] $enabledMenuItemRoots
 */
class Menu extends BaseMenu
{
    const TYPE_MAIN = 10;
    const TYPE_FOOTER = 20;
    const TYPE_PAGE = 30;

    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 1;

    /**
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return array
     */
    public static function getList() {
        return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'description' => 'Описание',
            'type' => 'Тип меню',
            'status' => 'Статус',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuItems() {
        return $this->hasMany(MenuItem::className(), ['menu_id' => 'id'])
            ->orderBy('sort');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuItemRoots() {
        return $this->hasMany(MenuItem::className(), ['menu_id' => 'id'])
            ->andWhere(['is', 'parent_id', null])
            ->orderBy('sort');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnabledMenuItemRoots() {
        return $this->hasMany(MenuItem::className(), ['menu_id' => 'id'])
            ->from(['mi' => MenuItem::tableName()])->innerJoinWith('menu')
            ->andWhere(['is', 'parent_id', null])
            ->andWhere(['menu.status' => Menu::STATUS_ENABLED])
            ->andWhere(['mi.status' => MenuItem::STATUS_ENABLED])
            ->orderBy('mi.sort');
    }

    /**
     * @param $type
     * @return Menu
     */
    public static function getEnabledOne($type) {
        return self::find()->andWhere(['status' => Menu::STATUS_ENABLED])
            ->andWhere(['type' => $type])->one();
    }
}
