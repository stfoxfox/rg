<?php
namespace common\models\gii;

use Yii;
use common\models\Menu;
use common\models\MenuItem;
use common\components\MyExtensions\MyActiveRecord;

/**
 * Class BaseMenuItem
 * @package common\models\gii
 *
 * @property integer $id
 * @property string $title
 * @property string $icon
 * @property string $url
 * @property string $controller
 * @property string $action
 * @property string $params
 * @property integer $status
 * @property integer $sort
 * @property integer $parent_id
 * @property integer $menu_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Menu $menu
 * @property MenuItem $parent
 */
class BaseMenuItem extends MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'menu_item';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['status', 'sort', 'parent_id', 'menu_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            ['params', 'string'],
            [['title', 'icon', 'url', 'controller', 'action'], 'string', 'max' => 255],
            [['menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['menu_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => MenuItem::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'icon' => 'Иконка',
            'url' => 'URL',
            'controller' => 'Controller',
            'action' => 'Action',
            'params' => 'Params',
            'status' => 'Статус',
            'sort' => 'Sort',
            'parent_id' => 'Родитель',
            'menu_id' => 'Menu ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent() {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu() {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id']);
    }
}
