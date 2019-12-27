<?php
namespace backend\models\forms;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use common\models\File;
use common\components\MyExtensions\MyFileSystem;
use common\models\FloorPlan;

/**
 * Class FloorPlanImportForm
 * @package backend\models\forms
 */
class FloorPlanImportForm extends Model
{
    public $complex_id;
    public $file;

    protected static $_TRANSLIT_MAP = [
        "A" => "А",
        "B" => "Б",
        "V" => "В",
        "G" => "Г",
        "D" => "Д",
        "E" => "Е",
        "Yo" => "Ё",
        "Zh" => "Ж",
        "Z" => "З",
        "I" => "И",
        "Y" => "Й",
        "K" => "К",
        "L" => "Л",
        "M" => "М",
        "N" => "Н",
        "O" => "О",
        "P" => "П",
        "R" => "Р",
        "S" => "С",
        "T" => "Т",
        "U" => "У",
        "F" => "Ф",
        "H" => "Х",
        "C" => "Ц",
        "Ch" => "Ч",
        "Sh" => "Ш",
        "Sch" => "Щ",
        "Yy" => "Ы",
        "Ee" => "Э",
        "Yu" => "Ю",
        "Ya" => "Я",
    ];

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['complex_id', 'integer'],
            ['file', 'file',
                'extensions' => 'zip',
                //'mimeTypes' => 'application/zip, application/gzip, application/x-rar-compressed, application/x-tar',
                'mimeTypes' => 'application/x-zip-compressed',
            ],
        ];
    }

    /**
     * @return bool|null
     */
    public function create() {
        if (!$this->validate()) {
            return null;
        }

        if ($archive = UploadedFile::getInstance($this, 'file')) {
            $related_model_path = 'FloorPlan';
            $path = MyFileSystem::makeDirs(Yii::getAlias('@common') . "/uploads/{$related_model_path}/");

            $zip = zip_open($archive->tempName);
            if ($zip) {

                while ($zip_entry = zip_read($zip)) {
                    // проверка соответствует ли файл формату корпус_секция_этаж_номер_квартиры
                    $tmp = explode('.', zip_entry_name($zip_entry));
                    $basename = self::translit($tmp[0]);
                    $params = explode('_', $basename);
                    if (count($params) < 4 || count($params) > 5) {
                        continue;
                    }

                    $file = null;
                    if (zip_entry_open($zip, $zip_entry, "r")) {
                        $filename = uniqid(). '_' . md5($basename) . '.jpg';

                        // пишем бинарный файл
                        $fp = fopen($path . $filename, "w");
                        fwrite($fp, zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)));
                        fclose($fp);

                        // создаем файл
                        $file = new File([
                            'file_name' => $filename,
                            'original_name' => $basename . '.jpg',
                            'type' => 'image/jpeg',
                            'sort' => -1,
                            'is_img' => true,
                        ]);

                        zip_entry_close($zip_entry);
                    }

                    // создаем планировку
                    if ($file) {
                        /** @var FloorPlan $floor_plan */
                        $floor_plan = FloorPlan::findOne(['external_id' => $basename]);

                        if ($floor_plan && $old_file = $floor_plan->file) {
                            $floor_plan->unlink('file', $old_file, true);
                        }

                        if (!$floor_plan) {
                            $floor_plan = new FloorPlan([
                                'complex_id' => $this->complex_id,
                                'external_id' => $basename,
                                'corpus_num' => $params[0],
                                'section_num' => $params[1],
                            ]);

                            if (count($params) == 5) {
                                $floor_plan->setAttributes([
                                    'floor_num_starts' => $params[2],
                                    'floor_num_ends' => $params[3],
                                    'number_on_floor' => $params[4],
                                ], false);

                            } else {
                                $floor_plan->setAttributes([
                                    'floor_num_starts' => $params[2],
                                    'floor_num_ends' => $params[2],
                                    'number_on_floor' => $params[3],
                                ], false);
                            }

                            $floor_plan->save(false);
                        }

                        if ($file->save()) {
                            $floor_plan->link('file', $file);
                        }
                    }
                }

                zip_close($zip);
                return true;
            }
        }

        return null;
    }

    /**
     * @param $text
     * @return string
     */
    protected static function translit($text) {
        return strtr($text, self::$_TRANSLIT_MAP);
    }
}


