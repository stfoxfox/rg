<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\components\MyExtensions\MyImagePublisher;
use common\components\MyExtensions\MyHelper;

/**
 * @var $this \yii\web\View
 * @var $model \common\models\Promo
 * @var $page \common\models\Page
 * @var $promos \common\models\Promo[]
 */
?>

<div class="section__container">
    <div class="section__content">
        <div class="row p-34">
            <div class="col-7">
                <div class="special_offer_gift_container">
                    <div class="block_offer_gift_head">
                        <?=Html::tag('h3', $model->title, ['class' => 'block_special_offer__title title--l'])?>
                        <div class="special__offer_1_heading block_special_offer__description">
                            <?=Html::tag('div', MyHelper::formatTextToHTML($model->description), ['class' => 'text--m'])?>
                        </div>
                    </div>

                    <?php if ($model->button_text) {
                        echo Html::a(Html::tag('span', $model->button_text, ['class' => 'btn__label']), $model->button_link, [
                            'class' => 'btn btn--main btn--low special_offer_gift_btn'
                        ]);
                    }?>
                </div>
            </div>

            <div class="col-5">
                <div class="block_special_offer__gift">
                    <?php if ($model->file) {
                        echo Html::img((new MyImagePublisher($model->file))->resizeInBox(468, 468, false, 'file_name', (new ReflectionClass($model))->getShortName()), [
                            'alt' => $model->title,
                            'class' => 'block_special_offer__illu'
                        ]);
                    }?>
                </div>
            </div>

        </div>
    </div>
</div>

<?=$this->render('@frontend/views/common/_pageBlocks', ['page' => $page])?>

<?php if ($promos) :?>
<section class="section section--special_offers">
    <div class="section__container">
        <div class="page_header__content">
            <?=Html::tag('h1', 'Еще предложения', ['class' => 'title--xxl'])?>
        </div>

        <?php foreach ($promos as $promo) :?>
        <div class="section__content">
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
        </div>
        <?php endforeach?>

    </div>
</section>
<?php endif?>