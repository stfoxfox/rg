<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\components\MyExtensions\MyImagePublisher;
use common\components\MyExtensions\MyHelper;

/**
 * @var $this \yii\web\View
 * @var $promos \common\models\Promo[]
 */

?>

<section class="section section--special_offers">
    <div class="section__container">
        <div class="section__content">

            <?php foreach ($promos as $promo) :?>
                <?=Html::beginTag('a', ['href' => Url::to(['/promo/view', 'id' => $promo->id]), 'class' => 'block_special_offer'])?>
                    <div class="block_special_offer__col">
                        <div class="block_special_offer__content">
                            <?=Html::tag('h3', $promo->title, ['class' => 'block_special_offer__title title--l'])?>
                            <div class="block_special_offer__description">
                                <?=Html::tag('p', MyHelper::formatTextToHTML($promo->description), ['class' => 'text--m'])?>
                            </div>
                        </div>
                    </div>

                    <div class="block_special_offer__col">
                        <?php if ($promo->file) {
                            echo Html::img((new MyImagePublisher($promo->file))->resizeInBox(659, 300, false, 'file_name', (new ReflectionClass($promo))->getShortName()), [
                                'alt' => $promo->title,
                                'class' => 'block_special_offer__illu'
                            ]);
                        }?>
                    </div>
                <?=Html::endTag('a')?>
            <?php endforeach?>

        </div>
    </div>
</section>

