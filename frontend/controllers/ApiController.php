<?php
namespace frontend\controllers;

use common\models\ComplexSearch;
use common\models\Floor;
use common\models\SectionSearch;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\widgets\ActiveForm;
use common\components\controllers\FrontendController;
use common\models\FlatSearch;
use common\models\Complex;
use common\models\Flat;
use common\models\Section;
use frontend\widgets\FeedbackWidget;
use frontend\models\CallbackForm;
use frontend\models\FlatFeedbackForm;
use frontend\models\MailToForm;
use frontend\models\ContactForm;

/**
 * Class ApiController
 * @package frontend\controllers
 */
class ApiController extends FrontendController
{
    /**
     * @return string
     */
    public function actionFlats() {
        $params = ArrayHelper::merge(Yii::$app->request->queryParams, [
            'complex-id' => $this->complex_id,
        ]);
        $model = (new FlatSearch())->searchForFront($params);

        $result = ArrayHelper::toArray($model->all(), [Flat::className() => [
            'id',
            'block' => function($flat) {
                /** @var $flat Flat */
                return $flat->section->corpus_num;
            },
            'rooms_count',
            'bathrooms_count' => function($flat) {
                /** @var $flat Flat */
                return '';
            },
            'balkony_count' => function($flat) {
                /** @var $flat Flat */
                return '';
            },
            'number_on_floor' => function($flat) {
                /** @var $flat Flat */
                return $flat->floor->number;
            },
            'total_area',

            'total_price' => function($flat) {
                /** @var $flat Flat */
                return ($flat->total_price) ? $flat->total_price : '';
            },
            'url' => function($flat) {
                /** @var $flat Flat */
                return Url::toRoute(['flats/view','id'=>$flat->id]);
            },
            'sale_price' => function($flat) {
                /** @var $flat Flat */
                return ($flat->sale_price) ? $flat->sale_price : '';
            },
            'decoration' => function($flat) {
                /** @var $flat Flat */
                // return ($flat->decoration) ? explode(';', $flat->decoration) : 0;
                return ($flat->decoration) ? 1 : 0;
            },
            'features' => function($flat) {
                /** @var $flat Flat */
                return ($flat->features) ? explode('/', $flat->features) : '';
            }
        ]]);

        return $this->sendJSONResponse($result);
    }

    /**
     * @return mixed
     */
    public function actionComplexes() {
        $model = (new ComplexSearch())->searchForFront(Yii::$app->request->queryParams);

        $result = ArrayHelper::toArray($model->all(), [ComplexSearch::className() => [
            'complex_id' => 'id',
            'title',
            'default' => function($complex) {
                /** @var $complex Complex */
                return ($complex->id == $this->complex_id) ? 1 : 0;
            },
            'min_price',
        ]]);

        return $this->sendJSONResponse($result);
    }

    /**
     * @return mixed
     */
    public function actionFilterParams() {
        $params = Yii::$app->request->queryParams;
        $complex_ids = explode(',', $params['complex_id']);
        if (count($complex_ids) == 0) {
            return $this->sendJSONResponse([]);
        }

        $min_price = Flat::find()->innerJoinWith('section')->andWhere(['in', 'complex_id', $complex_ids])
            ->min('flat.total_price');

        $max_price = Flat::find()->innerJoinWith('section')->andWhere(['in', 'complex_id', $complex_ids])
            ->max('flat.total_price');

        $min_area = Flat::find()->innerJoinWith('section')->andWhere(['in', 'complex_id', $complex_ids])
            ->min('flat.total_area');

        $max_area = Flat::find()->innerJoinWith('section')->andWhere(['in', 'complex_id', $complex_ids])
            ->max('flat.total_area');

        $rooms = Flat::find()->select('rooms_count')->distinct()->innerJoinWith('section')
            ->andWhere(['in', 'complex_id', $complex_ids])->addOrderBy('rooms_count')->column();

        $floors = Floor::find()->select('floor.number')->distinct()->innerJoinWith('section')
            ->andWhere(['in', 'complex_id', $complex_ids])->addOrderBy('floor.number')->column();

        return $this->sendJSONResponse([
            'min_price' => $min_price,
            'max_price' => $max_price,
            'min_total_area' => $min_area,
            'max_total_area' => $max_area,
            'rooms' => $rooms,
            'floors' => $floors,
        ]);
    }

    /**
     * @param $flat_id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionChess($flat_id) {
        $flat = $this->findFlat($flat_id);
        $result = [
            'id' => $flat->section->id,
            'title' => "Корпус {$flat->section->corpus_num}",
        ];

        /**
         * все секции корпуса
         * @var Section $section
         */
        $data = [];
        $sections = Section::find()->andWhere(['complex_id' => $flat->section->complex_id])
            ->andWhere(['corpus_num' => $flat->section->corpus_num])->orderBy('number')->all();

        foreach ($sections as $section) {
            $flats = [];
            foreach ($section->floorsOrdered as $floor) {
                if (!$floor->getFlats()->exists())
                    continue;

                $flats[] = ArrayHelper::toArray($floor->flats, [Flat::className() => [
                    'flat_id' => function($flat) {
                        /** @var $flat Flat */
                        return $flat->id;
                    },
                    'flat_number' => function($flat) {
                        /** @var $flat Flat */
                        return $flat->number;
                    },
                    'rooms_count',
                    'status' => function($flat) use ($flat_id) {
                        /** @var $flat Flat */
                        if ($flat->id == $flat_id)
                            return 'current';

                        switch ($flat->status) {
                            case Flat::STATUS_ENABLED:
                                return 'available';

                            case Flat::STATUS_SOLD:
                                return 'sold';

                            default:
                                return 'unavailable';
                        }
                    },
                    'url' => function($flat) {
                        /** @var $flat Flat */
                        return Url::to(['/flats/view', 'id' => $flat->id]);
                    }
                ]]);
            }
            $data []= $flats;
        }

        $result['data'] = $data;
        return $this->sendJSONResponse($result);
    }

    /**
     * @return mixed
     */
    public function actionMasterPlan() {
        $params = ArrayHelper::merge(Yii::$app->request->queryParams, [
            'complex-id' => $this->complex_id,
        ]);
        $model = (new SectionSearch())->searchForFront($params);

        $result = ArrayHelper::toArray($model->all(), [SectionSearch::className() => [
            'complex_id',
            'title' => function($section) {
                /** @var Section $section */
                return 'Корпус ' . $section->corpus_num;
            },
            'in_stock' => function($section) {
                /**
                 * всего в продаже
                 * @var Section $section
                 */
                return $section->getFlats()->andWhere(['flat.status' => Flat::STATUS_ENABLED])->count();
            },
            'booked' => function($section) {
                /**
                 * забронировано
                 * @var Section $section
                 */
                return $section->getFlats()->andWhere(['flat.status' => Flat::STATUS_RESERVED])->count();
            },
            'available' => function($section) {
                /**
                 * доступность секции
                 * @var Section $section
                 */
                $count = $section->getFlats()->andWhere(['flat.status' => Flat::STATUS_ENABLED])->count();
                return $count > 0 ? true : false;
            },
            'is_park_available' => function($section) {
                /**
                 * есть ли в продаже парковки
                 * @var Section $section
                 */
                return true;
            },
            'is_pantry_available' => function($section) {
                /**
                 * есть ли в продаже кладовки
                 * @var Section $section
                 */
                return true;
            },
            'is_commercial_available' => function($section) {
                /**
                 * есть ли в продаже коммерческая недвижимость
                 * @var Section $section
                 */
                return true;
            },
            'flats' => function($section) {
                /**
                 * сюда попадают минимальные цены из отфильтрованных квартир
                 * @var Section $section
                 */
                $result = [];
                $rooms = $section->getFlats()->select('flat.rooms_count')->distinct()
                    ->orderBy('flat.rooms_count')->column();

                foreach ($rooms as $room) {
                    $min_price = $section->getFlats()
                        ->andWhere(['flat.rooms_count' => $room])->min('flat.total_price');
                    $result []= [
                        'rooms' => $room,
                        'min_price' => $min_price,
                    ];
                }

                return $result;
            },
        ]]);

        return $this->sendJSONResponse($result);
    }

    /**
     * @return string
     */
    public function actionFeedback () {
        if (!Yii::$app->request->post('type'))
            return $this->sendJSONResponse(['error' => true, 'message' => 'Type is not set']);
        $post = Yii::$app->request->post();
        
        switch (Yii::$app->request->post('type')) {
            case FeedbackWidget::FLAT:
                $form = new FlatFeedbackForm([
                    'name' => isset($post['FlatFeedbackForm[name]']) ? $post['FlatFeedbackForm[name]'] : null,
                    'email' => isset($post['FlatFeedbackForm[email]']) ? $post['FlatFeedbackForm[email]'] : null,
                    'phone' => isset($post['FlatFeedbackForm[phone]']) ? $post['FlatFeedbackForm[phone]'] : null,
                    'message' => isset($post['FlatFeedbackForm[message]']) ? $post['FlatFeedbackForm[message]'] : null,
                    'promo' => isset($post['FlatFeedbackForm[promo]']) ? $post['FlatFeedbackForm[promo]'] : null,
                    'flat_id' => Yii::$app->request->post('flat_id')
                ]);   
                break;

            case FeedbackWidget::CONTACT:
                $form = new ContactForm([
                    'name' => isset($post['ContactForm[name]']) ? $post['ContactForm[name]'] : null,
                    'email' => isset($post['ContactForm[email]']) ? $post['ContactForm[email]'] : null,
                    'phone' => isset($post['ContactForm[phone]']) ? $post['ContactForm[phone]'] : null,
                    'message' => isset($post['ContactForm[message]']) ? $post['ContactForm[message]'] : null,
                ]);
                break;

            case FeedbackWidget::MAILTO:
//                $form = new MailToForm();
//                $form->load($post);
//                $form->link = Yii::$app->request->post('link');

                $form = new MailToForm([
                    'name' => isset($post['MailToForm[name]']) ? $post['MailToForm[name]'] : null,
                    'email' => isset($post['MailToForm[email]']) ? $post['MailToForm[email]'] : null,
                    'link' => Yii::$app->request->post('link'),
                ]);
                break;

            case FeedbackWidget::CALLBACK:
                $form = new CallbackForm([
                    'phone' => isset($post['CallbackForm[phone]']) ? $post['CallbackForm[phone]'] : null,
                    'complex' => isset($post['CallbackForm[complex]']) ? $post['CallbackForm[complex]'] : null,
                    'time' => isset($post['CallbackForm[time]']) ? $post['CallbackForm[time]'] : null,
                ]);
                break;
            
            default:
                return $this->sendJSONResponse(['error' => true]);
        }

        if ($feedback = $form->create()) {
            return $this->sendJSONResponse(['error' => false]);
        }

        return $this->sendJSONResponse(['error' => true, 'validate' => ActiveForm::validate($form)]);
    }

    /**
     * @return string
     */
    public function actionTestJson() {
        $json = file_get_contents(Yii::getAlias("@frontend") . '/testjson/json.json');
        $jsonObj = json_decode($json, true);

        return $this->sendJSONResponse($jsonObj);
    }

    /**
     * @return Complex
     * @throws NotFoundHttpException
     */
    protected function findComplex() {
        $model = Complex::findOne($this->complex_id);
        if ($model === null) {
            throw new NotFoundHttpException('Комплекс не найден');
        }

        return $model;
    }

    /**
     * @param $id
     * @return Flat
     * @throws NotFoundHttpException
     */
    protected function findFlat($id) {
        $model = Flat::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('Квартира не найдена');
        }

        return $model;
    }
}