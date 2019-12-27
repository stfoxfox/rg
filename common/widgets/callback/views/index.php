<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\CallbackForm;
use common\models\Complex;

/**
 * @var \yii\web\View $this
 * @var string $phone
 * @var \common\widgets\callback\CallbackWidget $context
 * @var $model \common\widgets\callback\forms\CallbackWidgetForm
 */

$callback_form = new CallbackForm();
$context = $this->context;
?>

<section class="section section--form_callback">
    <div class="section__container">
        <div class="section__content">

            <?php ActiveForm::begin(['id' => 'callback-form',
                'action' => \yii\helpers\Url::to(['/api/feedback']),
                'options' => [
                    'class' => 'form_callback js_form_callback',
                ]
            ])?>
            <?=Html::tag('div', $model->title, ['class' => 'form_callback__title h1 title--xxl'])?>
            <?=Html::tag('div', $model->subtitle, ['class' => 'form_callback__description'])?>

            <div class="form_callback__content">

                <div class="form_callback__item">
                    <div class="field field__text field__text--tel">
                        <div class="field__container">
                            <?=Html::activeInput('tel', $callback_form, 'phone', [
                                'placeholder' => $callback_form->getAttributeLabel('phone'),
                                'required' => 'required',
                            ])?>
                        </div>
                    </div>
                </div>

                <div class="form_callback__item">
                    <div class="field field__select">
                        <div class="field__container">
                            <?=Html::activeDropDownList($callback_form, 'complex', Complex::getList(), [
                                'data-placeholder' => $callback_form->getAttributeLabel('complex')
                            ])?>
                        </div>
                    </div>
                </div>

                <div class="form_callback__item">
                    <div class="field field__select">
                        <div class="field__container">
                            <?=Html::activeDropDownList($callback_form, 'time', $context->times, [
                                'data-placeholder' => $callback_form->getAttributeLabel('time'),
                                'placeholder' => 'Во сколько вам позвонить?'
                            ])?>
                        </div>
                    </div>
                </div>

                <div class="form_callback__item">
                    <?=Html::submitButton(Html::tag('span', 'Позвоните мне', ['class' => 'btn__label']), ['class' => 'form_callback__btn btn btn--main'])?>
                </div>
            </div>

            <?=Html::hiddenInput('type', \frontend\widgets\FeedbackWidget::CALLBACK)?>

            <?php ActiveForm::end()?>
            <?=Html::tag('div', 'Нажимая кнопку «Позвоните мне» вы подтверждаете свое<br/>согласие на обработку персональных данных', [
                'class' => 'form_callback__agreement'
            ])?>
        </div>
    </div>
</section>
