<?php
namespace frontend\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use common\models\SiteSettings;

/**
 * Class FeedbackWidget
 * @package frontend\widgets
 */
class FeedbackWidget extends Widget
{
    const FLAT = 'flat';
    const CALLBACK = 'callback';
    const MAILTO = 'mailto';
    const CONTACT = 'contact';

    /** @var string */
    public $type;

    /**
     * @inheritdoc
     */
    public function init() {
        if ($this->type == null) {
            throw new InvalidConfigException('Type must be set');
        }

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run() {
        $tel = SiteSettings::findOne(['text_key' => 'phone']);

        return $this->render($this->type, [
            'phone' => ($tel) ? $tel->string_value : '',
        ]);
    }

}