<?php
namespace common\components\behaviors;

use Yii;
use yii\base\Behavior;
use yii\base\InvalidConfigException;
use yii\db\BaseActiveRecord;
use common\components\MyExtensions\MyActiveRecord;
use common\components\MyExtensions\MyImagePublisher;
use common\models\File;

/**
 * Class FileBehavior
 * @package common\components\behaviors
 */
class FileBehavior extends Behavior
{
    /**
     * @var string the attribute which holds the attachment.
     */
    public $attribute = 'file_name';

    /**
     * @var array the scenarios in which the behavior will be triggered
     */
    public $scenarios = [];

    /**
     * @var boolean If `true` current attribute file will be deleted after model deletion.
     */
    public $unlinkOnDelete = true;

    /**
     * @var string
     * @info Обязательный атрибут, в котором должно быть имя папки, где хранятся файлы конкретной модели
     * по умолчанию будет браться путь из короткого имени модели
     */
    public $modelPath;

    /** @var File */
    protected $_file;

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();

        if ($this->attribute === null) {
            throw new InvalidConfigException('Некорректно установлен "attribute".');
        }
    }

    /**
     * @inheritdoc
     */
    public function events() {
        return [
            BaseActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }

    /**
     * @info delete file
     */
    public function afterDelete() {
        /** @var MyActiveRecord $class */
        $class = $this->owner;
        if ($class->hasAttribute('file_id') && $class->file_id > 0) {
            if (!$this->modelPath) {
                $this->modelPath = (new \ReflectionClass($class))->getShortName();
            }

            $this->_file = File::findOne($class->file_id);
            if ($this->unlinkOnDelete && $this->_file && $this->_file->delete()) {
                $this->delete();
            }
        }
    }

    /**
     * @info delete file
     */
    protected function delete() {
        $path = (new MyImagePublisher($this->_file))->getFilePath($this->attribute, $this->modelPath);
        if (is_file($path)) {
            unlink($path);
        }
    }

}