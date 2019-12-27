<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\FlatFeedbackForm;

/**
 * @var \yii\web\View $this
 * @var string $phone
 */

$feedback_form = new FlatFeedbackForm();
?>

<div class="form_feedback" style="display:none;">
    <a class="form_feedback__close js_popup_close" href="#">
        <svg class="icon__icon-close" width="14px" height="14px">
            <use xlink:href="#icon-close"></use>
        </svg>
    </a>
    <?php ActiveForm::begin(['id' => 'feedback-form',
//        'action' => \yii\helpers\Url::to(['/api/feedback']),
        'options' => [
            'class' => 'form_feedback__form js_form_feedback',
        ]])?>
    <div class="form_feedback__content">
        <?=Html::tag('h4', 'Пишите нашим менеджерам!', ['class' => 'title--m'])?>

        <div class="form_feedback__item">
            <div class="field field__text form_feedback__input">
                <div class="field__container">
                    <?=Html::activeTextInput($feedback_form, 'name', [
                        'placeholder' => $feedback_form->getAttributeLabel('name'),
                        'required' => 'required',
                    ])?>
                </div>
            </div>
        </div>

        <div class="form_feedback__item">
            <div class="field field__text form_feedback__input field__text--email">
                <div class="field__container">
                    <?=Html::activeInput('email', $feedback_form, 'email', [
                        'placeholder' => $feedback_form->getAttributeLabel('email'),
                        'required' => 'required',
                    ])?>
                </div>
            </div>
        </div>

        <div class="form_feedback__item form_feedback__item--short">
            <div class="field field__text form_feedback__input field__text--tel">
                <div class="field__container">
                    <?=Html::activeInput('tel', $feedback_form, 'phone', [
                        'placeholder' => $feedback_form->getAttributeLabel('phone'),
                        'required' => 'required',
                    ])?>
                </div>
            </div>
        </div>

        <div class="form_feedback__item">
            <?=Html::activeTextarea($feedback_form, 'message', [
                'placeholder' => $feedback_form->getAttributeLabel('message'),
                'class' => 'form_feedback__textarea',
                'required' => 'required',
            ])?>
        </div>

        <div class="form_feedback__item form_feedback__item--short">
            <div class="field field__text form_feedback__input">
                <div class="field__container">
                    <?=Html::activeTextInput($feedback_form, 'promo', [
                        'placeholder' => $feedback_form->getAttributeLabel('promo'),
                    ])?>
                </div>
            </div>
            <?=Html::hiddenInput('flat_id')?>
        </div>

    </div>

    <div class="form_feedback__accept">
        <div class="accept_popup">
            <div class="accept_popup__content">
                <div class="accept_popup__illu">
                    <svg class="icon__arrow-accept" width="165px" height="129px">
                        <use xlink:href="#arrow-accept"></use>
                    </svg>
                </div>
                <div class="accept_popup__text">
                    <p class="title--m">Подтверждение заявки</p>
                    <p class="text--m">Ваша заявка принята!<br/>Наши менеджеры свяжутся с&nbsp;вами в&nbsp;ближайшее время.</p>
                </div>
            </div>
        </div>
    </div>

    <?=Html::hiddenInput('type', \frontend\widgets\FeedbackWidget::FLAT)?>
    <?=Html::submitButton(Html::tag('span', 'Отправить сообщение', ['class' => 'btn__label']), ['class' => 'btn btn--main'])?>
    <?php ActiveForm::end()?>

    <div class="form_feedback__bottom">
        <?=Html::tag('p', 'Или просто позвоните, менеджеры ждут!')?>
        <?=Html::a($phone, 'tel:' . $phone, ['class' => 'comnewramenskiy'])?>
    </div>
</div>