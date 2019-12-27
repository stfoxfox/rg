<?php
use yii\helpers\Html;
use common\components\MyExtensions\MyImagePublisher;

/**
 * @var $this \yii\web\View
 * @var $model \common\widgets\flat\forms\FlatSelectionWidgetForm
 * @var $flats \yii\db\ActiveQuery
 * @var $flats_without_complex \yii\db\ActiveQuery
 * @var $complex \common\models\Complex
 */

$items = $flats->all();
$other_text = 'В других жилых комплексах ФСК Лидер найдено ' . $flats_without_complex->count()
    . ' квартир с такими параметрами.' . Html::a('Посмотреть', '#', ['class' => 'link--second']);
?>

<section class="section">
    <div class="section__container">
        <div class="section__content">
            <div class="apartments_unique">
                <?=Html::tag('h1', $model->title, ['class' => 'title--xxl'])?>
                <div class="apartments_unique__list">

                    <div class="row p-14">
                        <?php for ($i = 0; $i < 4; $i ++) :?>
                            <?php /** @var \common\models\Flat $item */
                                if (!isset($items[$i])) continue;
                                $item = $items[$i];

                                $square = Yii::$app->formatter->asDecimal($item->total_area) . ' м2';
                                $price = Yii::$app->formatter->asCurrency($item->total_price);
                                $sale_price = Yii::$app->formatter->asCurrency($item->sale_price);

                                $plan = null;
                                if ($item->floorPlan) {
                                    $plan = (new MyImagePublisher($item->floorPlan->file))->resizeInBox(222, 265, false, 'file_name', 'FloorPlan');
                                }
                            ?>
                            <div class="col-3">
                                <div class="lk_flat_card">
                                    <div class="lk_flat_card__content">

                                        <?=Html::a($complex->title, '#', ['class' => 'lk_flat_card__complex'])?>
                                        <a class="lk_flat_card__inner" href="#">
                                            <div class="lk_flat_card__item">
                                                <?=Html::tag('div', $item->rooms_count . ' комнатная квартира', [
                                                    'class' => 'lk_flat_card__title text--m'
                                                ])?>
                                                <?=Html::tag('div', '3 санузла, есть отделка', [
                                                    'class' => 'lk_flat_card__subtitle'
                                                ])?>
                                            </div>
                                            <div class="lk_flat_card__item lk_flat_card__options">
                                                <div class="row p-14">
                                                    <div class="col">
                                                        <?=Html::tag('span', $square, ['class' => 'text--m'])?>
                                                    </div>
                                                    <div class="col">
                                                        <?php if ($item->sale_price) {
                                                            echo Html::tag('span', $sale_price, ['class' => 'price_new title--m ']) . '<br/>';
                                                        }?>
                                                        <?=Html::tag('span', $price, ['class' => 'price_old text--m'])?>
                                                        <br/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="lk_flat_card__item">
                                                <div class="lk_flat_card__illu">
                                                    <?php if ($plan) {
                                                        echo Html::img($plan, ['alt' => 'План квартиры']);
                                                    }?>
                                                </div>
                                            </div>
                                        </a>

                                    </div>
                                </div>
                            </div>
                        <?php endfor?>
                    </div>

                </div>
                <div class="apartments_unique__actions">
                    <div class="row jc-sb">
                        <div class="col-6">
                            <?=Html::a(Html::tag('span', 'Посмотреть ' . $flats->count() . ' подходящих квартир в ' . $complex->title, [
                                'class' => 'btn__label'
                            ]), '#', ['class' => 'btn btn--second'])?>
                        </div>
                        <div class="col-3">
                            <?=Html::tag('span', $other_text, ['class' => 'apartments_unique__look'])?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>