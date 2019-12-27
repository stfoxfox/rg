<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\MailToForm;

/**
 * @var \yii\web\View $this
 * @var string $phone
 */

$mail_form = new MailToForm();
?>

<div class="form_mailto" style="display:none;">
    <a class="form_mailto__close js_popup_close" href="#">
        <svg class="icon__icon-close" width="14px" height="14px">
            <use xlink:href="#icon-close"></use>
        </svg>
    </a>
    <?php ActiveForm::begin(['id' => 'mailto-form',
        'options' => [
            'class' => 'form_mailto__form js_form_mailto',
        ]
    ])?>
        <div class="form_mailto__content">
            <?=Html::tag('h4', 'Отправить на почту', ['class' => 'title--m'])?>

            <div class="form_mailto__item">
                <?=Html::activeTextInput($mail_form, 'name', [
                    'placeholder' => $mail_form->getAttributeLabel('name'),
                    'class' => 'form_mailto__input',
                    'required' => 'required',
                ])?>
            </div>

            <div class="form_mailto__item">
                <?=Html::activeInput('email', $mail_form, 'email', [
                    'placeholder' => $mail_form->getAttributeLabel('email'),
                    'class' => 'form_mailto__input',
                    'required' => 'required',
                ])?>
                <?=Html::hiddenInput('link')?>
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

        <?=Html::hiddenInput('type', \frontend\widgets\FeedbackWidget::MAILTO)?>
        <?=Html::submitButton(Html::tag('span', 'Отправить сообщение', ['class' => 'btn__label']), ['class' => 'btn btn--main'])?>
    <?php ActiveForm::end()?>

    <div class="form_mailto__bottom">
        <?=Html::tag('p', 'Или просто позвоните, менеджеры ждут!')?>
        <?=Html::a($phone, 'tel:' . $phone, ['class' => 'comnewramenskiy'])?>
    </div>
</div>