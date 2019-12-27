<?php
namespace backend\models\forms;

use common\models\Page;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\web\UploadedFile;
use common\models\Promo;
use common\models\File;

/**
 * Class PromoForm
 * This is the model class for Promo form.
 * @package backend\models\forms
 */
class PromoForm extends Model
{
    public $title;
    public $file_id;
    public $description;
    public $external_id;
    public $date_to;
    public $status;
    public $type;
    public $avatar_id;
    public $manager;
    public $manager_phone;
    public $button_text;
    public $button_link;

    public $file;
    public $x;
    public $y;
    public $w;
    public $h;

    public $avatar;
    public $x1;
    public $y1;
    public $w1;
    public $h1;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['file_id', 'status', 'type', 'avatar_id'], 'integer'],
            [['description'], 'string'],
            [['date_to'], 'safe'],
            [['title', 'external_id', 'manager', 'button_text', 'button_link'], 'string', 'max' => 255],
            ['title', 'unique', 'targetClass' => '\common\models\Promo', 'message' => 'Этот заголовок уже используется.'],
            ['button_link', 'url'],
            [['manager_phone'], 'string', 'max' => 50],
//            ['manager_phone', 'match', 'pattern' => '/^[0-9]+$/', 'message' => 'Введите правильный номер'],
            [['file', 'x', 'y', 'w', 'h'], 'safe'],
            [['avatar', 'x1', 'y1', 'w1', 'h1'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return ArrayHelper::merge((new Promo())->attributeLabels(), []);
    }

    /**
     * @param Promo $item
     */
    public function loadFrom($item) {
        $this->title = $item->title;
        $this->file_id = $item->file_id;
        $this->description = $item->description;
        $this->external_id = $item->external_id;
        $this->date_to = $item->date_to;
        $this->status = $item->status;
        $this->type = $item->type;
        $this->avatar_id = $item->avatar_id;
        $this->manager = $item->manager;
        $this->manager_phone = $item->manager_phone;
        $this->button_text = $item->button_text;
        $this->button_link = $item->button_link;
    }

    /**
     * @inheritdoc
     * @var Promo $item
     */
    public function edit($item) {
        if (!$this->validate()) {
            return null;
        }

        $item->title = $this->title;
        $item->description = $this->description;
        $item->external_id = $this->external_id;
        $item->date_to = $this->date_to;
        $item->status = $this->status;
        $item->type = $this->type;
        $item->manager = $this->manager;
        $item->manager_phone = $this->manager_phone;
        $item->button_text = $this->button_text;
        $item->button_link = $this->button_link;

        $file_id = null;
        $file = $item->file ? $item->file : new File();
        if ($picture = UploadedFile::getInstance($this, 'file')) {
            $file_id = File::saveFile($picture, (new \ReflectionClass($item))->getShortName(), $file->id, $this->x, $this->y, $this->h, $this->w);
        }

        $avatar_id = null;
        $ava = $item->avatar ? $item->avatar : new File();
        if ($avatar = UploadedFile::getInstance($this, 'avatar')) {
            $avatar_id = File::saveFile($avatar, (new \ReflectionClass($item))->getShortName(), $ava->id, $this->x1, $this->y1, $this->h1, $this->w1);
        }

        if ($item->save()) {
            if ($file_id) {
                $item->link('file', File::findOne($file_id));
            }

            if ($avatar_id) {
                $item->link('avatar', File::findOne($avatar_id));
            }

            return true;
        }

        return null;
    }

    /**
     * @return bool|null
     */
    public function create() {
        if (!$this->validate()) {
            return null;
        }

        $item = new Promo();

        $item->title = $this->title;
        $item->description = $this->description;
        $item->external_id = $this->external_id;
        $item->date_to = $this->date_to;
        $item->status = $this->status;
        $item->type = $this->type ? $this->type : Promo::TYPE_ALL;
        $item->manager = $this->manager;
        $item->manager_phone = $this->manager_phone;
        $item->button_text = $this->button_text;
        $item->button_link = $this->button_link;

        $file_id = null;
        $file = new File();
        if ($picture = UploadedFile::getInstance($this, 'file')) {
            $file_id = File::saveFile($picture, (new \ReflectionClass($item))->getShortName(), $file->id, $this->x, $this->y, $this->h, $this->w);
        }

        $ava_id = null;
        $ava = new File();
        if ($avatar = UploadedFile::getInstance($this, 'avatar')) {
            $ava_id = File::saveFile($avatar, (new \ReflectionClass($item))->getShortName(), $ava->id, $this->x1, $this->y1, $this->h1, $this->w1);
        }

        if ($item->save()) {
            if ($file_id > 0) {
                $item->link('file', File::findOne($file_id));
            }

            if ($ava_id > 0) {
                $item->link('file', File::findOne($ava_id));
            }

            $page = new Page([
                'title' => 'Спецпредложение ' . $item->title,
                'slug' => Inflector::slug('Промо ' . $item->title),
                'is_internal' => true,
            ]);

            $page->save(false);
            $item->link('page', $page);

            return true;
        }

        return null;
    }
}
