<?php
namespace backend\models\forms;

use Yii;
use yii\base\Model;
use common\models\DocVersion;
use common\models\Doc;
use common\models\File;
use yii\web\UploadedFile;

/**
 * Class DocVersionForm
 * @package backend\models\forms
 */
class DocVersionForm extends Model
{
    public $version;
    public $doc_date;
    public $doc_id;
    public $file_id;

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
            [['doc_date', 'file', 'file_id', 'x', 'y', 'w', 'h'], 'safe'],
            [['doc_id', 'file_id'], 'integer'],
            [['version'], 'string', 'max' => 255],
            ['version', 'required'],
            ['file', 'file',
                'extensions' => 'jpg, jpeg, png, pdf, doc, docx',
                'mimeTypes' => 'image/jpeg, image/png, image/gif, application/pdf, application/msword',
            ],
            [['doc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Doc::className(), 'targetAttribute' => ['doc_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'version' => 'Версия',
            'doc_date' => 'Дата документа',
            'doc_id' => 'Документ',
            'file' => 'Файл',
        ];
    }

    /**
     * @param DocVersion $item
     */
    public function loadFrom($item) {
        $this->version = $item->version;
        $this->doc_date = $item->doc_date;
        $this->doc_id = $item->doc_id;
        $this->file_id = $item->file_id;
    }

    /**
     * @inheritdoc
     * @var DocVersion $item
     */
    public function edit($item) {
        if (!$this->validate()) {
            return null;
        }

        $item->version = $this->version;
        $item->doc_date = $this->doc_date;
        $item->doc_id = $this->doc_id;

        $file = $item->file ? $item->file : new File();
        return $this->upload(UploadedFile::getInstance($this, 'file'), $file, $item);
    }

    public function create() {
        if (!$this->validate()) {
            return null;
        }

        $item = new DocVersion();
        $item->version = $this->version;
        $item->doc_date = $this->doc_date;
        $item->doc_id = $this->doc_id;

        return $this->upload(UploadedFile::getInstance($this, 'file'), new File(), $item);
    }

    /**
     * @param $_file UploadedFile
     * @param $file File
     * @param $item DocVersion
     * @return DocVersion|null
     */
    protected function upload($_file, $file, $item) {
        $file_id = null;

        if ($_file instanceof UploadedFile) {

            switch ($_file->type) {
                case 'image/jpeg':
                case 'image/jpg':
                case 'image/pjpeg':
                case 'image/png':
                    $file_id = File::saveFile($_file, (new \ReflectionClass($item))->getShortName(), $file->id, $this->x, $this->y, $this->h, $this->w);
                    break;

                default:
                    $file_id = File::saveFile($_file, (new \ReflectionClass($item))->getShortName(), $file->id);
                    break;
            }
        }

        if ($item->save()) {
            if ($file_id > 0) {
                $item->link('file', File::findOne($file_id));
            }

            return $item;
        }

        return null;
    }
}
