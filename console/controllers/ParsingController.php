<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;
use yii\helpers\FileHelper;
use common\models\Complex;
use common\models\Section;
use common\models\Floor;
use common\models\Flat;
use common\models\Bank;
use common\models\Mortgage;
use yii\helpers\Inflector;
use common\models\Corpus;
use common\models\Page;

/**
 * Class ParsingController
 * @package console\controllers
 */
class ParsingController extends Controller
{
    public $defaultAction='parse';

    protected $queue_path;
    protected $done_path;
    protected $file;

    /**
     * @param string $path
     * @return int
     */
    public function actionParse($path = '@console/uploads') {
        ini_set('memory_limit', '-1');

        $start = new \DateTime();
        $complex_count = 0;
        $section_count = 0;
        $corpus_count = 0;
        $floor_count = 0;
        $flat_count = 0;
        $errors = "";

        $this->queue_path = FileHelper::normalizePath(Yii::getAlias($path . '/queue'));
        $this->done_path = FileHelper::normalizePath(Yii::getAlias($path . '/done'));

        if (!file_exists($this->queue_path)) mkdir($this->queue_path, 0755, true);
        if (!file_exists($this->done_path)) mkdir($this->done_path, 0755, true);
        $files = FileHelper::findFiles($this->queue_path, [
            'recursive' => false,
            'only' => ['objectsfile*.xml']
        ]);

        if (empty($files)) {
            echo $this->stdout("Files with pattern -objectsfile*.xml- was not found in " . $this->queue_path . "\n", Console::FG_RED);
            return ExitCode::OK;
        }

        $file_objects = $this->extractArray($files);
        foreach ($file_objects as $file_object) {

            $iteration = 0; $steps = count($file_object);
            Console::startProgress(0, $steps);

            foreach ($file_object as $complex) {
                //смотрим комплексы
                if (!isset($complex['@attributes']) || !isset($complex['@attributes']['ID1C'])) {
                    $errors .= "У комплекса нет атрибутов или не установлен ID1C, пропуск.. \n";
                    continue;
                }
                $attributes = $complex['@attributes'];

                $complex_item = Complex::findOne(['external_id' => $attributes['ID1C']]);
                if (empty($complex_item)) {
                    $complex_item = new Complex();
                    echo $this->stdout("Новый комплекс " . $complex_item->external_id . " " . $complex_item->title . ", добавлен \n", Console::FG_GREEN);
                    $complex_count ++;

                } else {
                    // echo $this->stdout("Комплекс " . $complex_item->external_id . " " . $complex_item->title . ", найден \n", Console::BG_PURPLE);
                }

                $complex_item->setAttributes([
                    'title' => isset($attributes['Complex_Name']) ? $attributes['Complex_Name'] : 'Temp Complex',
                    'min_price' => isset($attributes['Min_price']) ? floatval($attributes['Min_price']) : null,
                    'max_price' => isset($attributes['Max_price']) ? floatval($attributes['Max_price']) : null,
                    'min_area' => isset($attributes['Min_square']) ? floatval($attributes['Min_square']) : null,
                    'max_area' => isset($attributes['Max_square']) ? floatval($attributes['Max_square']) : null,
                    'external_id' => $attributes['ID1C'],
                ], false);
                $complex_item->save(false);

                //смотрим секции
                if (!isset($complex['Sections']) || !isset($complex['Sections']['Section'])) {
                    $errors .= "--- У комплекса {$complex_item->title} не найдено секций, пропуск.. \n";
                    continue;
                }
                foreach ($complex['Sections']['Section'] as $section) {
                    if (!isset($section['@attributes']) || !isset($section['@attributes']['Section_num']) || trim($section['@attributes']['Section_num']) == '') {
                        $errors .= "--- {$complex_item->title} У секции нет атрибутов или не установлен Section_num, пропуск.. \n";
                        continue;
                    }
                    $sec_attributes = $section['@attributes'];

                    $section_item = Section::findOne([
                        'number' => trim($sec_attributes['Section_num']),
                        'corpus_num' => isset($sec_attributes['Corpus_num']) ? $sec_attributes['Corpus_num'] : null,
                        'complex_id' => $complex_item->id
                    ]);
                    if (empty($section_item)) {
                        $section_item = new Section();
                        echo $this->stdout("--- Новая секция " . $section_item->number . ", добавлена \n", Console::FG_GREEN);
                        $section_count ++;

                    } else {
                        // echo $this->stdout("--- Секция " . $section_item->number . ", найдена \n", Console::BG_PURPLE);
                    }

                    $section_item->setAttributes([
                        'number' => trim($sec_attributes['Section_num']),
                        'corpus_num' => isset($sec_attributes['Corpus_num']) ? $sec_attributes['Corpus_num'] : null,
                        'floors_count' => isset($sec_attributes['Floor_quant']) ? intval($sec_attributes['Floor_quant']) : null,
                        'quarter' => isset($sec_attributes['Kvartal']) ? $sec_attributes['Kvartal'] : null,
                        'status' => isset($sec_attributes['Montage']) ? $this->getSectionStatus($sec_attributes['Montage']) : null,
                        'series' => isset($sec_attributes['Series']) ? $sec_attributes['Series'] : null,
                        'decoration' => isset($sec_attributes['Decoration']) ? $sec_attributes['Decoration'] : null,
                        'complex_id' => $complex_item->id
                    ], false);
                    $section_item->save(false);

                    //пишем корпус
                    if ($section_item->corpus_num && !$section_item->getCorpus()->exists()) {
                        $page = new Page([
                            'title' => 'Корпус №' . $section_item->corpus_num,
                            'slug' => Inflector::slug('Корпус ' . $section_item->corpus_num),
                            'is_internal' => true,
                        ]);
                        if ($page->save(false)) {
                            $corpus = new Corpus([
                                'corpus_num' => $section_item->corpus_num,
                                'page_id' => $page->id,
                            ]);
                            if ($corpus->save(false)) {
                                echo $this->stdout("--- " . $corpus->name . ", добавлен \n", Console::FG_GREEN);
                                $corpus_count ++;
                            }
                        }
                    }

                    //смотрим этажи
                    if (!isset($section['Floors']) || !isset($section['Floors']['Floor'])) {
                        echo $this->stdout("------ {$complex_item->title} - {$section_item->number} У секции не найдено этажей, пропуск.. \n", Console::BG_YELLOW);
                        continue;
                    }
                    foreach ($section['Floors']['Floor'] as $floor) {
                        if (!isset($floor['@attributes']) || !isset($floor['@attributes']['Floor_num'])) {
                            $errors .= "------ {$complex_item->title} - {$section_item->number} У этажа нет атрибутов или не установлен Floor_num, пропуск.. \n";
                            continue;
                        }
                        $floor_attributes = $floor['@attributes'];

                        $floor_item = Floor::findOne(['number' => intval($floor_attributes['Floor_num']), 'section_id' => $section_item->id]);
                        if (empty($floor_item)) {
                            $floor_item = new Floor();
                            // echo $this->stdout("------ Новый этаж " . $floor_item->number . ", добавлен \n", Console::FG_GREEN);
                            $floor_count ++;
                        } else {
                            // echo $this->stdout("------ Этаж " . $floor_item->number . ", найден \n", Console::BG_PURPLE);
                        }

                        $floor_item->setAttributes([
                            'number' => intval($floor_attributes['Floor_num']),
                            'flats_count' => isset($floor_attributes['Flats_quant']) ? intval($floor_attributes['Flats_quant']) : null,
                            'section_id' => $section_item->id,
                        ], false);
                        $floor_item->save(false);

                        //смотрим квартиры
                        if (!isset($floor['Flats']) || !isset($floor['Flats']['Flat'])) {
                            $errors .= "--------- {$complex_item->title} - {$section_item->number} - {$floor_item->number} У этажа не найдено квартир, пропуск.. \n";
                            continue;
                        }
                        foreach ($floor['Flats']['Flat'] as $flat) {
                            if (!isset($flat['@attributes']) || !isset($flat['@attributes']['ID1C'])) {
                                $errors .= "--------- {$complex_item->title} - {$section_item->number} - {$floor_item->number} У квартиры нет атрибутов или не установлен ID1C, пропуск.. \n";
                                continue;
                            }
                            $flat_attributes = $flat['@attributes'];

                            $flat_item = Flat::findOne(['external_id' => $flat_attributes['ID1C'], 'floor_id' => $floor_item->id]);
                            if (empty($flat_item)) {
                                $flat_item = new Flat();
                                // echo $this->stdout("--------- Новая квартира " . $flat_item->number . ", добавлена \n", Console::FG_GREEN);
                                $flat_count ++;
                            } else {
                                // echo $this->stdout("--------- Квартира " . $flat_item->number . ", найдена \n", Console::BG_PURPLE);
                            }

                            $flat_item->setAttributes([
                                'type' => isset($flat_attributes['Flat_type']) ? intval($flat_attributes['Flat_type']) : null,
                                'number' => isset($flat_attributes['Number']) ? $flat_attributes['Number'] : null,
                                'rooms_count' => isset($flat_attributes['Rooms']) ? intval($flat_attributes['Rooms']) : null,
                                'total_area' => isset($flat_attributes['Square_tot']) ? floatval($flat_attributes['Square_tot']) : null,
                                'live_area' => isset($flat_attributes['Square_live']) ? floatval($flat_attributes['Square_live']) : null,
                                'kitchen_area' => isset($flat_attributes['Square_kitchen']) ? floatval($flat_attributes['Square_kitchen']) : null,
                                'currency' => isset($flat_attributes['Currency']) ? intval($flat_attributes['Currency']) : null,
                                'price' => isset($flat_attributes['Price']) ? floatval($flat_attributes['Price']) : null,
                                'sale_price' => isset($flat_attributes['Sale_price']) ? floatval($flat_attributes['Sale_price']) : null,
                                'total_price' => isset($flat_attributes['Price_tot']) ? floatval($flat_attributes['Price_tot']) : null,
                                'status' => $this->getFlatStatus($flat_attributes),
                                'number_on_floor' => isset($flat_attributes['Num_on_floor']) ? intval($flat_attributes['Num_on_floor']) : null,
                                'binding' => isset($flat_attributes['Binding']) ? $flat_attributes['Binding'] : null,
                                'garage' => (isset($flat_attributes['Garage']) && $flat_attributes['Garage'] <> 'false') ? boolval($flat_attributes['Garage']) : null,
                                'decoration' => isset($flat_attributes['Decoration']) ? $flat_attributes['Decoration'] : null,
                                'furniture' => (isset($flat_attributes['Furniture']) && $flat_attributes['Furniture'] <> 'false') ? boolval($flat_attributes['Furniture']) : null,
                                'features' => isset($flat_attributes['Features']) ? $flat_attributes['Features'] : null,
                                'object_id' => isset($flat_attributes['Object_ID']) ? $flat_attributes['Object_ID'] : null,
                                'external_id' => $flat_attributes['ID1C'],
                                'floor_id' => $floor_item->id,
                            ], false);

                            // смотрим планировки
                            if ($section_item->getFloorPlans()->exists()) {

//                                if ($flat_item->external_id == '88236') {
//                                    $sql = $section_item->getFloorPlans()
//                                        ->andWhere(['>=', 'floor_num_starts', $floor_item->number])
//                                        ->andWhere(['<=', 'floor_num_ends', $floor_item->number])
//                                        ->andWhere(['floor_plan.number_on_floor' => $flat_item->number_on_floor])->createCommand()->getRawSql();
//                                    Yii::warning($sql);
//                                }

                                $plan = $section_item->getFloorPlans()
                                    ->andWhere(['<=', 'floor_num_starts', $floor_item->number])
                                    ->andWhere(['>=', 'floor_num_ends', $floor_item->number])
                                    ->andWhere(['floor_plan.number_on_floor' => $flat_item->number_on_floor])
                                    ->one();

                                if ($plan) {
                                    $flat_item->floor_plan_id = $plan->id;
                                }
                            }

                            $flat_item->save(false);

                        } // end foreach flat

                    } // end foreach floor

                } // end foreach section

                $iteration ++;
                Console::updateProgress($iteration, $steps, $complex_item->external_id . " " . $complex_item->title . " ");

            } // end foreach complex

            Console::endProgress();
        }

        $this->stdout("\n");
        $this->stdout("Завершено за " . Yii::$app->formatter->asDuration($start->diff(new \DateTime())) . "\n", Console::FG_GREEN);
        $this->stdout("Создано комплексов " . $complex_count . "\n", Console::FG_GREEN);
        $this->stdout("Создано секций " . $section_count . "\n", Console::FG_GREEN);
        $this->stdout("Создано корпусов " . $corpus_count . "\n", Console::FG_GREEN);
        $this->stdout("Создано этажей " . $floor_count . "\n", Console::FG_GREEN);
        $this->stdout("Создано квартир " . $flat_count . "\n", Console::FG_GREEN);

        if ($errors) {
            //Yii::warning($errors);
        }

        return ExitCode::OK;
    }

    /**
     * @param string $path
     * @return int
     */
    public function actionMortgage($path = '@console/uploads') {
        ini_set('memory_limit', '-1');

        $start = new \DateTime();
        $bank_count = 0;
        $mortgage_count = 0;

        $this->queue_path = FileHelper::normalizePath(Yii::getAlias($path . '/queue'));
        $this->done_path = FileHelper::normalizePath(Yii::getAlias($path . '/done'));

        if (!file_exists($this->queue_path)) mkdir($this->queue_path, 0755, true);
        if (!file_exists($this->done_path)) mkdir($this->done_path, 0755, true);
        $files = FileHelper::findFiles($this->queue_path, [
            'recursive' => false,
            'only' => ['mortgagesfile*.xml']
        ]);

        if (empty($files)) {
            echo $this->stdout("Files with pattern -mortgagesfile*.xml- was not found in " . $this->queue_path . "\n", Console::FG_RED);
            return ExitCode::OK;
        }

        $file_objects = $this->extractArray($files, 'Bank');

        foreach ($file_objects as $file_object) {

            $iteration = 0; $steps = count($file_object);
            Console::startProgress(0, $steps);

            foreach ($file_object as $bank) {
                //смотрим банки
                if (!isset($bank['@attributes']) || !isset($bank['@attributes']['BankID1C'])) {
                    echo $this->stdout("У банка нет атрибутов или не установлен BankID1C, пропуск.. \n", Console::FG_YELLOW);
                    continue;
                }
                $attributes = $bank['@attributes'];

                $bank_item = Bank::findOne(['external_id' => $attributes['BankID1C']]);
                if (empty($bank_item)) {
                    $bank_item = new Bank();
                    echo $this->stdout("Новый банк " . $bank_item->external_id . " " . $bank_item->title . ", добавлен \n", Console::FG_GREEN);
                    $bank_count ++;
                } else {
                    // echo $this->stdout("Банк " . $bank_item->external_id . " " . $bank_item->title . ", найден \n", Console::BG_PURPLE);
                }

                $bank_item->setAttributes([
                    'title' => isset($attributes['BankName']) ? $attributes['BankName'] : 'Temp Bank',
                    'license' => isset($attributes['LicenseNum']) ? $attributes['LicenseNum'] : null,
                    'date_license' => isset($attributes['LicenseDate']) ? Yii::$app->formatter->asDate($attributes['LicenseDate']) : null,
                    'external_id' => $attributes['BankID1C'],
                ]);
                $bank_item->save(false);

                //смотрим ипотеки
                if (!isset($bank['MortgageProgram'])) {
                    // echo $this->stdout("--- У банка не найдено ипотек, пропуск.. \n", Console::BG_YELLOW);
                    continue;
                }
                foreach ($bank['MortgageProgram'] as $mortgage) {
                    if (!isset($mortgage['@attributes']) || !isset($mortgage['@attributes']['ID1C'])) {
                        // echo $this->stdout("--- У ипотеки нет атрибутов или не установлен ID1C, пропуск.. \n", Console::BG_YELLOW);
                        continue;
                    }
                    $mortgage_attributes = $mortgage['@attributes'];

                    $mortgage_item = Mortgage::findOne(['external_id' => $mortgage_attributes['ID1C'], 'bank_id' => $bank_item->id]);
                    if (empty($mortgage_item)) {
                        $mortgage_item = new Mortgage();
                        echo $this->stdout("Новая ипотека " . $mortgage_item->external_id . " " . $mortgage_item->title . ", добавлена \n", Console::FG_GREEN);
                        $mortgage_count ++;
                    } else {
                        // echo $this->stdout("Ипотека " . $mortgage_item->external_id . " " . $mortgage_item->title . ", найдена \n", Console::BG_PURPLE);
                    }

                    $mortgage_item->setAttributes([
                        'title' => isset($mortgage_attributes['Name']) ? $mortgage_attributes['Name'] : 'Temp Mortgage',
                        'min_cash' => isset($mortgage_attributes['MinPervVznos']) ? floatval($mortgage_attributes['MinPervVznos']) : null,
                        'percent_rate' => isset($mortgage_attributes['ProcStav']) ? floatval($mortgage_attributes['ProcStav']) : null,
                        'max_period' => isset($mortgage_attributes['MaxSrok']) ? intval($mortgage_attributes['MaxSrok']) : null,
                        'max_amount' => isset($mortgage_attributes['MaxAmount']) ? intval($mortgage_attributes['MaxAmount']) : null,
                        'is_military' => (isset($mortgage_attributes['Military']) && $mortgage_attributes['Military'] <> 'false')
                            ? boolval($mortgage_attributes['Military']) : null,
                        'is_priority' => (isset($mortgage_attributes['Priority']) && $mortgage_attributes['Priority'] <> 'false')
                            ? boolval($mortgage_attributes['Priority']) : null,
                        'bank_id' => $bank_item->id,
                        'external_id' => $mortgage_attributes['ID1C'],
                    ]);
                    $mortgage_item->save(false);

                } // end foreach mortgage

                $iteration ++;
                Console::updateProgress($iteration, $steps, $bank_item->external_id . " " . $bank_item->title . " ");
            } // end foreach bank

            Console::endProgress();
        }

        $this->stdout("\n");
        $this->stdout("Завершено за " . Yii::$app->formatter->asDuration($start->diff(new \DateTime())) . "\n", Console::FG_GREEN);
        $this->stdout("Создано банков " . $bank_count . "\n", Console::FG_GREEN);
        $this->stdout("Создано ипотечных программ " . $mortgage_count . "\n", Console::FG_GREEN);

        return ExitCode::OK;
    }

    /**
     * @param $attributes
     * @return int
     */
    protected function getFlatStatus($attributes) {
        if (isset($attributes['Sold'])) {
            $sold = intval($attributes['Sold']);
            return $sold == 1 ? Flat::STATUS_SOLD
                : Flat::STATUS_ENABLED;
        }

        return Flat::STATUS_ENABLED;
    }

    /**
     * @param $status
     * @return int
     */
    protected function getSectionStatus($status) {
        switch ($status) {
            case 'строится':
                return Section::STATUS_IN_PROGRESS;

            case 'сдан':
                return Section::STATUS_IS_READY;

            default:
                return Section::STATUS_NOT_READY;
        }
    }

    /**
     * @param array $files
     * @param string $root
     * @return array
     * @throws \Exception
     */
    protected function extractArray(array $files, $root = 'Object') {
        $xml = [];
        foreach ($files as $file) {
            $this->file = fopen($file, 'r');
            $xml []= $this->parseToArray($file, $root);
            fclose($this->file);

            rename($file, $this->done_path . '/' . basename($file));
        }

        return $xml;
    }

    /**
     * @param $file
     * @param string $root
     * @return null
     * @throws \Exception
     */
    protected function parseToArray($file, $root) {
        try {
            $xml = new \SimpleXMLElement($file, 0 , true);
            $obj = $xml->addChild('Object');
            $result = $this->recursiveParseToArray($xml);

        } catch (\Exception $exception) {
            throw $exception;
        }

        return isset($result[$root]) ? $result[$root] : null;
    }

    /**
     * @param SimpleXMLElement
     * @return mixed
     */
    protected function recursiveParseToArray($xml) {
        if( $xml instanceof \SimpleXMLElement ) {
            $attributes = $xml->attributes();

            foreach( $attributes as $key => $value ) {
                if( $value ) {
                    $attribute_array[$key] = (string) $value;
                }
            }
            $previous_xml = $xml;
            $xml = get_object_vars($xml);
        }

        if(is_array($xml)) {

            if( count($xml) == 0 )
                return (string) $previous_xml; // for CDATA

            foreach($xml as $key => $value) {
                $row[$key] = $this->recursiveParseToArray($value);
            }

            return $row;
        }
        return (string) $xml;
    }

}