<?php
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $this yii\web\View
 * @var $exception Exception
 * @var $flats \common\models\Flat[]
 */

$code = null;
if ($exception instanceof \yii\web\HttpException) {
    $code = $exception->statusCode;
}
$message = $exception->getMessage();
$href = $this->assetManager->getPublishedUrl('@frontend/assets/app') . '/';
?>

<section class="section" style="margin-top: 60px">
    <div class="section__container">
        <div class="section__content">
            <div class="not-found-img">
                <img class="block_special_offer__illu" src="<?=$href?>static/img/assets/blocks/not_found/cloud_404.png" alt="Страница не найдена. Попробуйте еще раз" />
                <div class="not-found-info">
<!--                    --><?//=Html::tag('h3', $code ? 'Ошибка ' . $code : 'Ошибка')?>
                    <?=Html::tag('div', $message, ['class' => 'not-found_title title--xxl'])?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="section__container">
        <div class="section__content">
            <div class="apartments_unique">
                <?=Html::tag('h1', 'Посмотритe квартиры с другими параметрами', ['class' => 'not_found-title'])?>
                <div class="apartments_unique__list">
                    <div class="row p-14">
                        <?php foreach ($flats as $flat) :?>
                        <div class="col-3">
                            <div class="lk_flat_card">
                                <div class="lk_flat_card__content">
                                    <?=Html::a($flat->complex->title, '#', ['class' => 'lk_flat_card__complex'])?>
                                    <?=Html::beginTag('a', ['href' => Url::to(['/flats/view', 'id' => $flat->id]), 'class' => 'lk_flat_card__inner'])?>

                                        <div class="lk_flat_card__item">
                                            <?=Html::tag('div', $flat->rooms_count . ' комнатная квартира', ['class' => 'lk_flat_card__title text--m'])?>
                                            <div class="lk_flat_card__subtitle">3 санузла, есть отделка и 2 балкона</div>
                                        </div>

                                        <div class="lk_flat_card__item lk_flat_card__options">
                                            <div class="row p-14">
                                                <div class="col">
                                                    <?=Html::tag('span', Yii::$app->formatter->asDecimal($flat->total_area) . '  м2', ['class' => 'text--m'])?>
                                                </div>
                                                <div class="col">
                                                    <?php if ($flat->sale_price) {
                                                        echo Html::tag('span', Yii::$app->formatter->asCurrency($flat->sale_price), ['class' => 'price_new title--m']);
                                                        echo '<br/>' . Html::tag('span', Yii::$app->formatter->asCurrency($flat->total_price), ['class' => 'price_old text--m']);
                                                    } else {
                                                        echo Html::tag('span', Yii::$app->formatter->asCurrency($flat->total_price), ['class' => 'text--m']);
                                                    }?>
                                                    <br/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="lk_flat_card__item">
                                            <div class="lk_flat_card__illu">
                                                <?php if ($flat->floorPlan) {
                                                    echo Html::img($flat->floorPlan->file->getOriginal((new ReflectionClass($flat->floorPlan))->getShortName()), ['alt' => 'План квартиры']);
                                                }?>
                                            </div>
                                        </div>

                                    <?=Html::endTag('a')?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach?>
                    </div>
                </div>
            </div>
        </div>
</section>