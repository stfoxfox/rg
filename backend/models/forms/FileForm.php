<?php

namespace backend\models\forms;

use Yii;
use yii\base\Model;
use common\models\File;
/**
* This is the model class for File form.
*/
class FileForm extends Model
{
    public $file_name;
    public $is_img;
    public $title;
    public $description;
    public $sort;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file_name'], 'required'],
            [['is_img'], 'boolean'],
            [['description'], 'string'],
            [['sort'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['file_name', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @param File $item
     */
    public function loadFrom($item)
    {
        $this->file_name = $item->file_name;
        $this->is_img = $item->is_img;
        $this->title = $item->title;
        $this->description = $item->description;
        $this->sort = $item->sort;
    }

    /**
     * @inheritdoc
     * @var File $item
     */
    public function edit($item)
    {
        if (!$this->validate()) {
            return null;
        }

        $item->file_name = $this->file_name;
        $item->is_img = $this->is_img;
        $item->title = $this->title;
        $item->description = $this->description;
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

        $item = new File();

        $item->file_name = $this->file_name;
        $item->is_img = $this->is_img;
        $item->title = $this->title;
        $item->description = $this->description;
        $item->sort = $this->sort;
    
        if ($item->save()) {
            return $item;
        }

        return null;
    }
}
