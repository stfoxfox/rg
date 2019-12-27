<?php
use yii\helpers\Html;
use common\components\MyExtensions\MyImagePublisher;
use frontend\widgets\FeedbackWidget;

/**
 * @var \yii\web\View $this
 * @var \common\models\Flat $model
 * @var \common\models\Page $page
 */

$js = <<<JS
    var flat_id = {$model->id};
JS;
$this->registerJs($js, \yii\web\View::POS_HEAD);

$rooms = Yii::t('app', '{n, plural, one{# комната} few{# комнаты} many{# комнат} other{# комнат}}', ['n' => $model->rooms_count]);
$floor = $model->floor->number . '-й этаж';
$flat_info = 'Квартира ' . $model->number . ', ' . $rooms . ', ' . $floor;

$price = ($model->sale_price) ? $model->sale_price : $model->total_price;
$price = Yii::$app->formatter->asCurrency($price);
$discount = ($model->sale_price) ? Yii::$app->formatter->asCurrency($model->total_price - $model->sale_price) : 0;

$plan_img = null;
if ($model->floorPlan) {
//    $plan_img = Html::img((new MyImagePublisher($model->floorPlan->file))
//        ->resizeInBox(600, 400, true, 'file_name', (new ReflectionClass($model->floorPlan))->getShortName()), ['alt' => '']);
    $plan_img = $model->floorPlan->file->getOriginal((new ReflectionClass($model->floorPlan))->getShortName());
}

?>


<section class="section">
    <div class="section__container">
        <div class="section__content">
            <div class="flat">
                <div class="flat__header">
<!--                    <div class="flat__service_controls">-->
<!--                        <a href="#">Сохранить</a>-->
<!--                        <a href="#" class='js_print'>-->
<!--                            <svg class="flat__service_controls_icon" width="24px" height="24px">-->
<!--                                <use xlink:href="#printer"></use>-->
<!--                            </svg>-->
<!--                            Распечатать-->
<!--                        </a>-->
<!--                        <a class="js_popup_mailto" href="#">-->
<!--                            <svg class="flat__service_controls_icon" width="24px" height="24px">-->
<!--                                <use xlink:href="#mail"></use>-->
<!--                            </svg>-->
<!--                            Отправить на почту-->
<!--                        </a>-->
<!--                    </div>-->
<!--                    <div class="flat__watchers">Сейчас объект просматривает 9125 человек</div>-->
                    <?=Html::tag('div', $flat_info, ['class' => 'flat__title h1 title--xxl'])?>
                    <div class="flat__price">
                        <?=Html::tag('span', Yii::$app->formatter->asCurrency($model->total_price), ['class' => 'price'])?>
                        <?=Html::tag('span', Yii::$app->formatter->asCurrency($model->price), ['class' => 'square_price'])?>
                        <?=Html::tag('span', '(Цена за м2)', ['class' => 'description'])?>
                    </div>
                </div>

                <div class="flat__body">
                    <div class="row">
                        <div class="col-6">
                            <div class="flat__description">
                                <?php $a=1; /*
                                <div class="flat__prices_more">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="flat__prices_more_title">Обычная цена</div>
                                            <?=Html::tag('div', Yii::$app->formatter->asCurrency($model->total_price), ['class' => 'flat__prices_more_value'])?>
                                        </div>

                                        <?php if ($model->sale_price) :?>
                                        <div class="col-4">
                                            <div class="flat__prices_more_title">Выгода</div>
                                            <div class="flat__prices_more_value">
                                                <?=Html::tag('span', Yii::$app->formatter->asCurrency($model->total_price - $model->sale_price), ['class' => 'attention'])?>
                                                <svg class="icon--percent" width="25px" height="25px">
                                                    <use xlink:href="#percent"></use>
                                                </svg>
                                            </div>
                                        </div>
                                        <?php endif?>

                                        <div class="col-4">
                                            <div class="flat__prices_more_title">Цена за м2</div>
                                            <?=Html::tag('div', Yii::$app->formatter->asCurrency($model->price), ['class' => 'flat__prices_more_value'])?>
                                        </div>
                                    </div>
                                </div>
                                */?>
                                <div class="flat__actions">
                                    <a class="btn btn--main js_popup_feedback" href="#">
                                        <div class="btn__label">Оставить заявку</div>
                                    </a>
<!--                                    <a class="btn btn--second" href="#">-->
<!--                                        <div class="btn__label">Добавить к сравнению</div>-->
<!--                                    </a>-->
                                </div>
                                <div class="flat__characteristics">
                                    <div class="flat__table_title">Все характеристики</div>
                                    <table class="flat__table">
                                        <tr>
                                            <th>Площадь, общая</th>
                                            <td></td>
                                            <td><?=Yii::$app->formatter->asDecimal($model->total_area,2)?> м2</td>
                                        </tr>
                                        <tr>
                                            <th>Номер квартиры</th>
                                            <td></td>
                                            <td><?=$model->number?></td>
                                        </tr>
                                        <tr>
                                            <th>Этаж</th>
                                            <td></td>
                                            <td><?=$model->floor->number?></td>
                                        </tr>
                                        <?php if ($model->kitchen_area) :?>
                                        <tr>
                                            <th>Кухня</th>
                                            <td>
                                                <svg class="flat__table_icon flat__table_icon--orange" width="18px" height="25px">
                                                    <use xlink:href="#present"></use>
                                                </svg>

                                            </td>
                                            <td><?=Yii::$app->formatter->asDecimal($model->kitchen_area,2)?> м2</td>
                                        </tr>
                                        <?php endif?>

                                        <?php if ($model->decoration) :?>
                                        <tr>
                                            <th>Отделка</th>
                                            <td></td>
                                            <td><?=Html::tag('span', 'в подарок', ['class' => 'tag tag--green'])?></td>
                                        </tr>
                                        <?php endif?>

                                        <tr>
                                            <th>Количество комнат</th>
                                            <td></td>
                                            <td>
                                                <?=($model->rooms_count) ? $model->rooms_count : '-'?>
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                                <!--
                                <div class="flat__socials">...</div>
                                -->
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="flat__plans">
                                <?php if ($plan_img) :?>
                                <div class="flat__floor">
                                    <div class="flat__floor_title">Планировка этажа</div>
                                    <div class="flat__floor_description">Вы можете выбрать другую квартиру</div>
                                    <div class="flat__floor_plan">
                                        <?=Html::a(Html::img($plan_img, ['alt' => 'flat_plan']), $plan_img, [
                                            'class' => 'js-plan-open'
                                        ])?>
                                    </div>
                                </div>
                                <?php endif?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</section>

<?=$this->render('@frontend/views/common/_pageBlocks', ['page' => $page])?>
