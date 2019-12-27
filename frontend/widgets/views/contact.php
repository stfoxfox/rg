<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\ContactForm;

/**
 * @var \yii\web\View $this
 * @var string $phone
 */

$feedback_form = new ContactForm();
?>

<div class="form_contacts">
    <?=Html::tag('h5', 'Звоните нашим менеджерам!', ['class' => 'title--m'])?>
    <?=Html::a($phone, 'tel:' . $phone, ['class' => 'title--l form_contacts__link comnewramenskiy'])?>

    <?php ActiveForm::begin(['id' => 'contact-form',
//        'action' => \yii\helpers\Url::to(['/api/feedback']),
        'options' => [
            'class' => 'js_form_contacts',
    ]])?>
        <div class="form_contacts__content">
            <?=Html::tag('h5', 'Пишите нашим менеджерам!', ['class' => 'title--m'])?>

            <div class="form_contacts__item">
                <div class="field field__text form_feedback__input field__text--email">
                    <div class="field__container">
                        <?=Html::activeTextInput($feedback_form, 'email', [
                            'placeholder' => $feedback_form->getAttributeLabel('email'),
                            'required' => 'required',
                        ])?>
                    </div>
                </div>
            </div>

            <div class="form_contacts__item">
                <div class="field field__text form_feedback__input field__text--tel">
                    <div class="field__container">
                        <?=Html::activeInput('tel', $feedback_form, 'phone', [
                            'placeholder' => $feedback_form->getAttributeLabel('phone'),
                            'required' => 'required',
                        ])?>
                    </div>
                </div>
            </div>

            <div class="form_contacts__item">
                <div class="field field__text">
                    <div class="field__container">
                        <?=Html::activeTextInput($feedback_form, 'name', [
                            'placeholder' => $feedback_form->getAttributeLabel('name'),
                            'required' => 'required',
                        ])?>
                    </div>
                </div>
            </div>

            <div class="form_contacts__item">
                <?=Html::activeTextarea($feedback_form, 'message', [
                    'placeholder' => $feedback_form->getAttributeLabel('message'),
                    'required' => 'required',
                ])?>
            </div>

        </div>

        <div class="form_contacts__action">
            <?=Html::hiddenInput('type', \frontend\widgets\FeedbackWidget::CONTACT)?>
            <?=Html::submitButton(Html::tag('span', 'Отправить сообщение', ['class' => 'btn__label']), ['class' => 'btn btn--second'])?>
        </div>

        <div class="form_contacts__accept">
            <div class="accept_popup accept_popup--contacts">
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

    <?php ActiveForm::end()?>
</div>