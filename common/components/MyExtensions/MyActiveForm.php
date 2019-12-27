<?php
namespace common\components\MyExtensions;

use Yii;
use yii\widgets\ActiveForm;

/**
 * Class MyActiveForm
 * @package common\components\MyExtensions
 *
 * @inheritdoc
 */
class MyActiveForm extends ActiveForm
{
    public $errorCssClass = 'field--error';

    public function init() {
        parent::init();
        $this->fieldClass = MyActiveField::className();
    }

}