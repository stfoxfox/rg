<?php
use frontend\widgets\FeedbackWidget;

/**
 * @var \yii\web\View $this
 */
$js = <<<JS
var s = document.createElement('script');
s.type = 'text/javascript';
s.async = true;
s.src = '//c.netrox.sc/1A7F23C6-0BC7-07BF-52FE-F57EC3529AB1/c.js?tmpl=1';

var ss = document.getElementsByTagName('script')[0];
ss.parentNode.insertBefore(s, ss);
JS;
$this->registerJs($js);
?>

<div class="popup__container">
    <div class="popup__background"></div>
    <div class="popup__content">
        <?=FeedbackWidget::widget(['type' => FeedbackWidget::FLAT])?>
        <?=FeedbackWidget::widget(['type' => FeedbackWidget::MAILTO])?>
    </div>
</div>

<div class="nsc_lw" style="display:none;">
    Netrox SC - <a href='https://www.netroxsc.ru' target='_blank' >онлайн-консультант для сайта</a>
</div>