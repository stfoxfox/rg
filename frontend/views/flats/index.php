<?php
/**
 * @var $this \yii\web\View
 * @var $model \common\models\FlatSearch
 * @var $complex \common\models\Complex
 */
?>

<section class="section">
    <div class="section__container">

        <div class="section__content">
            <div class="flats_filter">
                <?=$this->render('_form', [
                    'model' => $model,
                    'floors' => $complex->getFloorList()
                ])?>
            </div>

            <div class="hr"></div>

            <div class="flats_result">
                <?=$this->render('_table')?>
            </div>
        </div>

        <div class="js_flats_not_found" style="display:none;">
            <div class="flats_filter_not_found">
                <div class="flats_filter_not_found__content">
                    <p class="text--l">По вашим параметрам ничего не найдено.</p><a class="text--l link--second" href="#">Посмотрите квартиры от 1 230 000 руб.</a>
                </div>
            </div>
        </div>

    </div>
</section>