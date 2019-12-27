<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var \yii\web\View $this
 * @var \common\models\FlatSearch $model
 * @var \common\models\Floor[] $floors
 */
?>

<?php $form = ActiveForm::begin(['id' => 'flats-form', 'options' => ['class' => 'js_flats_filter_form']])?>

<div class="row p-34">
    <div class="col-3">
        <div class="field field__range">
            <div class="field__label">
                <?=Html::activeLabel($model, 'total_area')?>
            </div>

            <div class="field__container">
                <div class="field field__text">
                    <?=Html::activeLabel($model, 'total_area_starts', ['class' => 'field__label'])?>
                    <div class="field__container">
                        <?=Html::activeTextInput($model, 'total_area_starts')?>
                    </div>
                </div>

                <div class="field field__text">
                    <?=Html::activeLabel($model, 'total_area_ends', ['class' => 'field__label'])?>
                    <div class="field__container">
                        <?=Html::activeTextInput($model, 'total_area_ends')?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-3">
        <div class="field field__range">
            <div class="field__label">
                <?=Html::activeLabel($model, 'price')?>
            </div>

            <div class="field__container">
                <div class="field field__text">
                    <?=Html::activeLabel($model, 'price_starts', ['class' => 'field__label'])?>
                    <div class="field__container">
                        <?=Html::activeTextInput($model, 'price_starts')?>
                    </div>
                </div>

                <div class="field field__text">
                    <?=Html::activeLabel($model, 'price_ends', ['class' => 'field__label'])?>
                    <div class="field__container">
                        <?=Html::activeTextInput($model, 'price_ends')?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-3">
        <div class="field field__checkbox_group field__checkbox_group--buttons">
            <div class="field__label">
                <?=Html::activeLabel($model, 'rooms_count')?>
            </div>

            <div class="field__container">
                <?php for($i = 1; $i < 4; $i++) :?>
                    <div class="field field__checkbox">
                        <div class="field__label">
                            <?=Html::label('', 'rooms-' . $i)?>
                        </div>
                        <div class="field__container">
                            <?=Html::checkbox('FlatSearch[rooms_count]', false, [
                                'id' => 'rooms-' . $i,
                                'value' => $i,
                            ])?>
                            <?=Html::tag('span', $i)?>
                        </div>
                    </div>
                <?php endfor?>
            </div>
        </div>
    </div>

    <div class="col-3">
        <div class="field field__checkboxes_dropdown">
            <div class="field__label">
                <?=Html::activeLabel($model, 'floor_num')?>
            </div>

            <div class="field__container">

                <div class="field__checkboxes_dropdown__selected">
                    <div class="field__checkboxes_dropdown__result_text"></div>
                    <span class="ico--triangle">
                        <svg class="icon__triangle" width="13px" height="9px">
                            <use xlink:href="#triangle"></use>
                        </svg>
                    </span>
                </div>

                <div class="field__checkboxes_dropdown__select">
                    <div class="field__checkboxes_dropdown__inner">
                        <?php foreach ($floors as $id => $floor) :?>

                            <div class="field__checkboxes_dropdown__item">
                                <div class="field field__checkbox">
                                    <div class="field__label">
                                        <?=Html::label($floor . '-й этаж', 'floor-' . $id)?>
                                    </div>
                                    <div class="field__container">
                                        <?=Html::checkbox('FlatSearch[floor_num]', false, [
                                            'id' => 'floor-' . $id,
                                            'value' => $id,
                                        ])?>
                                        <span>
                                            <svg class="icon__arrow-checkbox" width="12px" height="10px">
                                                <use xlink:href="#arrow-checkbox"></use>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row p-34 ai-c">

    <?php $a=1;/*
                <div class="col">
                    <div class="field field__checkbox">
                        <div class="field__label">
                            <?=Html::activeLabel($model, 'is_euro')?>
                        </div>
                        <div class="field__container">
                            <?=Html::checkbox('FlatSearch[is_euro]', false, ['id' => 'flatsearch-is_euro'])?>
                            <span>
                                <svg class="icon__arrow-checkbox" width="12px" height="10px">
                                    <use xlink:href="#arrow-checkbox"></use>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="field field__checkbox">
                        <div class="field__label">
                            <?=Html::activeLabel($model, 'is_classic')?>
                        </div>
                        <div class="field__container">
                            <?=Html::checkbox('FlatSearch[is_classic]', false, ['id' => 'flatsearch-is_classic'])?>
                            <span>
                                <svg class="icon__arrow-checkbox" width="12px" height="10px">
                                    <use xlink:href="#arrow-checkbox"></use>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="field field__checkbox">
                        <div class="field__label">
                            <?=Html::activeLabel($model, 'is_decoration')?>
                        </div>
                        <div class="field__container">
                            <?=Html::checkbox('FlatSearch[is_decoration]', false, ['id' => 'flatsearch-is_decoration'])?>
                            <span>
                                <svg class="icon__arrow-checkbox" width="12px" height="10px">
                                    <use xlink:href="#arrow-checkbox"></use>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
                */?>

    <?=Html::tag('div', '', ['class' => 'col-8'])?>

    <div class="col-1">
        <?=Html::tag('div', Html::a('Сбросить', '#', ['class' => 'js_form_clear']), [
            'class' => 'field field__button'
        ])?>
    </div>

    <div class="col-2">
        <div class="field field__submit">
            <?=Html::submitButton(Html::tag('div', 'Применить', ['class' => 'btn__label']), [
                'class' => 'btn btn--main btn--low'
            ])?>
        </div>
    </div>

    <?=Html::hiddenInput('FlatSearch[block]')?>

</div>

<?php ActiveForm::end()?>

