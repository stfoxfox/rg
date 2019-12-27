<?php

namespace backend\models\forms;

use Yii;
use yii\base\Model;
use common\models\Contact;
/**
* This is the model class for Contact form.
*/
class ContactForm extends Model
{
    public $title;
    public $address;
    public $hours;
    public $phones;
    public $email;
    public $sort;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['title', 'required'],
            ['email', 'email'],
            [['sort'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'address', 'hours', 'phones', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return (new Contact())->attributeLabels();
    }

    /**
     * @param Contact $item
     */
    public function loadFrom($item)
    {
        $this->title = $item->title;
        $this->address = $item->address;
        $this->hours = $item->hours;
        $this->phones = $item->phones;
        $this->email = $item->email;
        $this->sort = $item->sort;
    }

    /**
     * @inheritdoc
     * @var Contact $item
     */
    public function edit($item)
    {
        if (!$this->validate()) {
            return null;
        }

        $item->title = $this->title;
        $item->address = $this->address;
        $item->hours = $this->hours;
        $item->phones = $this->phones;
        $item->email = $this->email;
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

        $item = new Contact();

        $item->title = $this->title;
        $item->address = $this->address;
        $item->hours = $this->hours;
        $item->phones = $this->phones;
        $item->email = $this->email;
        $item->sort = $this->sort;
    
        if ($item->save()) {
            return $item;
        }

        return null;
    }
}
