<?php
namespace backend\models\forms;

use Yii;
use yii\base\Model;
use common\models\Feedback;
use common\models\Flat;

/**
 * Class FeedbackForm
 * @package backend\models\forms
 */
class FeedbackForm extends Model
{
    public $status;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
        ];
    }

    /**
     * @param Feedback $item
     */
    public function loadFrom($item) {
        $this->status = $item->status;
    }

    /**
     * @inheritdoc
     * @var Feedback $item
     */
    public function edit($item) {
        if (!$this->validate()) {
            return null;
        }

        $item->status = $this->status;
    
        if ($item->save()) {
            return true;
        }

        return null;
    }

}
