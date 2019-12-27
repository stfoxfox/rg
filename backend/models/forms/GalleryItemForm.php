<?php
namespace backend\models\forms;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use common\models\GalleryItem;
use common\models\File;
use common\models\Gallery;
use common\models\Complex;

/**
 * Class GalleryItemForm
 * @package backend\models\forms
 */
class GalleryItemForm extends Model
{
    public $file_id;
    public $gallery_id;
    public $photo_date;
    public $complex_id;
    public $corpus_num;

    public $file;
    public $x;
    public $y;
    public $w;
    public $h;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['file_id', 'gallery_id', 'complex_id', 'corpus_num'], 'integer'],
            [['photo_date', 'file', 'file_id', 'x', 'y', 'w', 'h'], 'safe'],
            [['complex_id'], 'exist', 'skipOnError' => true, 'targetClass' => Complex::className(), 'targetAttribute' => ['complex_id' => 'id']],
            [['gallery_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gallery::className(), 'targetAttribute' => ['gallery_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'photo_date' => 'Дата фото',
            'complex_id' => 'Комплекс',
            'corpus_num' => '№ корпуса',
        ];
    }

    /**
     * @param GalleryItem $item
     */
    public function loadFrom($item) {
        $this->file_id = $item->file_id;
        $this->gallery_id = $item->gallery_id;
        $this->photo_date = $item->photo_date;
        $this->complex_id = $item->complex_id;
        $this->corpus_num = $item->corpus_num;
    }

    /**
     * @inheritdoc
     * @var GalleryItem $item
     */
    public function edit($item) {
        if (!$this->validate()) {
            return null;
        }

        $item->photo_date = $this->photo_date;
        $item->complex_id = $this->complex_id;
        $item->corpus_num = $this->corpus_num;

        $file_id = null;
        $file = $item->file ? $item->file : new File();
        if ($picture = UploadedFile::getInstance($this, 'file')) {
            $file_id = File::saveFile($picture, (new \ReflectionClass($item))->getShortName(), $file->id, $this->x, $this->y, $this->h, $this->w);
        }

        if ($item->save()) {
            if ($file_id) {
                $item->link('file', File::findOne($file_id));
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

        $item = new GalleryItem();
        $item->gallery_id = $this->gallery_id;

        $file_id = null;
        if ($this->file_id && $this->file_id > 0) {
            $need_link = false;
            $item->file_id = $this->file_id;
            $file = File::findOne($this->file_id);
            if (!$file)
                return null;
        } else {
            $file = new File();
            $need_link = true;
        }

        if ($picture = UploadedFile::getInstance($this, 'file')) {
            $file_id = File::saveFile($picture, (new \ReflectionClass($item))->getShortName(), $file->id, $this->x, $this->y, $this->h, $this->w);
        }

        if ($need_link && $item->save()) {
            if ($file_id > 0) {
                $item->link('file', File::findOne($file_id));
            }
        }

        return true;
    }
}
