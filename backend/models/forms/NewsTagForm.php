<?php

namespace backend\models\forms;

use Yii;
use yii\base\Model;
use common\models\NewsTag;
/**
* This is the model class for NewsTag form.
*/
class NewsTagForm extends Model
{
    public $title;
    public $sort;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @param NewsTag $item
     */
    public function loadFromItem($item)
    {
        $this->title = $item->title;
        $this->sort = $item->sort;
    }

    /**
     * @inheritdoc
     * @var NewsTag $item
     */
    public function edit($item)
    {
        if (!$this->validate()) {
            return null;
        }

        $item->title = $this->title;
        $item->sort = $this->sort;
    
        if ($item->save()) {
            return true;
        }

        return null;
    }

    public function create()
    {
        if (!$this->validate()) {
            return null;
        }

        $item = new NewsTag();

        $item->title = $this->title;
        $item->sort = $this->sort;
    
        if ($item->save()) {
            return $item;
        }

        return null;
    }
}
