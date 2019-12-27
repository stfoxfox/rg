<?php

namespace backend\models\forms;

use Yii;
use yii\base\Model;
use common\models\Page;
/**
* This is the model class for Page form.
*/
class PageForm extends Model
{
    public $slug;
    public $title;
    public $description;
    public $html_text;
    public $type;
    public $show_anchors;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug', 'title'], 'required'],
            [['html_text'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['type'], 'integer'],
            [['slug', 'title', 'description'], 'string', 'max' => 255],
            [['show_anchors'], 'boolean'],
        ];
    }

    /**
     * @param Page $item
     */
    public function loadFromItem($item)
    {
        $this->slug = $item->slug;
        $this->title = $item->title;
        $this->description = $item->description;
        $this->html_text = $item->html_text;
        $this->type = $item->type;
        $this->show_anchors = $item->show_anchors;
    }

    /**
     * @inheritdoc
     * @var Page $item
     */
    public function edit($item)
    {
        if (!$this->validate()) {
            return null;
        }

        $item->slug = $this->slug;
        $item->title = $this->title;
        $item->description = $this->description;
        $item->html_text = $this->html_text;
        $item->type = $this->type;
        $item->show_anchors = $this->show_anchors;

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

        $item = new Page();

        $item->slug = $this->slug;
        $item->title = $this->title;
        $item->description = $this->description;
        $item->html_text = $this->html_text;
        $item->type = $this->type;
        $item->show_anchors = $this->show_anchors;

        if ($item->save()) {
            return $item;
        }

        return null;
    }
}
