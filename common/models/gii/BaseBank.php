<?php
namespace common\models\gii;

use Yii;
use common\components\MyExtensions\MyActiveRecord;
use common\models\Mortgage;

/**
 * Class BaseBank
 * @package common\models\gii
 * @property integer $id
 * @property string $title
 * @property string $license
 * @property string $date_license
 * @property integer $sort
 * @property string $external_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Mortgage[] $mortgages
 */
class BaseBank extends MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'bank';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['date_license', 'created_at', 'updated_at'], 'safe'],
            [['sort'], 'integer'],
            [['title', 'license', 'external_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'license' => 'Номер лицензии банка',
            'date_license' => 'Дата лицензии банка',
            'sort' => 'Sort',
            'external_id' => 'External ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMortgages() {
        return $this->hasMany(Mortgage::className(), ['bank_id' => 'id']);
    }
}
