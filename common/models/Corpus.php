<?php
namespace common\models;

use Yii;
use common\models\gii\BaseCorpus;
use yii\helpers\ArrayHelper;

/**
* This is the model class for table "corpus".
* Class Corpus
* @package common\models
* @inheritdoc
 *
 * @property string $name
*/
class Corpus extends BaseCorpus
{
    /**
     * @inheritdoc
     */
    public function rules() {
        return ArrayHelper::merge(parent::rules(),[
            [['corpus_num'], 'exist', 'skipOnError' => true, 'targetClass' => Section::className(), 'targetAttribute' => ['corpus_num' => 'corpus_num']],
        ]);
    }

    /**
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return array
     */
    public static function getList() {
        return ArrayHelper::map(self::find()->all(), 'id', function($corpus) {
            /** @var $corpus self */
            return 'Корпус №' . $corpus->corpus_num;
        });
    }

    /**
     * @return string
     */
    public function getName() {
        return 'Корпус №' . $this->corpus_num;
    }
}
