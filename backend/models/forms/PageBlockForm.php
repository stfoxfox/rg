<?php

namespace backend\models\forms;

use Yii;
use yii\base\Model;
use common\models\PageBlock;
/**
* This is the model class for PageBlock form.
*/
class PageBlockForm extends Model
{
    public $page_id;
    public $block_name;
    public $type;
    public $sort;
    public $data;
    public $parent_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_id', 'type', 'sort', 'parent_id'], 'integer'],
            [['data'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['block_name'], 'string', 'max' => 255],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::className(), 'targetAttribute' => ['page_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => PageBlock::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @param PageBlock $item
     */
    public function loadFromItem($item)
    {
        $this->page_id = $item->page_id;
        $this->block_name = $item->block_name;
        $this->type = $item->type;
        $this->sort = $item->sort;
        $this->data = $item->data;
        $this->parent_id = $item->parent_id;
    }

    /**
     * @inheritdoc
     * @var PageBlock $item
     */
    public function edit($item)
    {
        if (!$this->validate()) {
            return null;
        }

        $item->page_id = $this->page_id;
        $item->block_name = $this->block_name;
        $item->type = $this->type;
        $item->sort = $this->sort;
        $item->data = $this->data;
        $item->parent_id = $this->parent_id;
    
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

        $item = new PageBlock();

        $item->page_id = $this->page_id;
        $item->block_name = $this->block_name;
        $item->type = $this->type;
        $item->sort = $this->sort;
        $item->data = $this->data;
        $item->parent_id = $this->parent_id;
    
        if ($item->save()) {
            return $item;
        }

        return null;
    }
}
