<?php
use yii\helpers\Html;
use common\models\Menu;
use common\models\SiteSettings;
use frontend\widgets\MenuWidget;

/**
 * @var $this \yii\web\View
 * @var SiteSettings $tel
 */
$tel = SiteSettings::findOne(['text_key' => 'phone']);
$phone = ($tel) ? $tel->string_value : '';
$menu = Menu::getEnabledOne(Menu::TYPE_MAIN);
?>

<header class="header header--cut">
    <div class="header__container">
        <div class="header__content">
            <?php if (isset($this->params['is_main']) && $this->params['is_main']) {
                echo Html::tag('span', 'Новый Раменский', ['class' => 'logo_main', 'title' => 'Новый Раменский']);
            } else {
                echo Html::a('Новый Раменский', '/', ['class' => 'logo_main', 'title' => 'Новый Раменский']);
            }?>

            <?=Html::a($phone, 'tel:' . $phone, ['class' => 'phone comnewramenskiy'])?>
            <a class="logo_lider" href="<?=\yii\helpers\Url::to(['site/about'])?>">
                <svg class="logo_lider__icon" width="118px" height="31px">
                    <?php if (isset($this->params['is_main']) && $this->params['is_main']) {
                        echo '<use xlink:href="#logo-lider-white"></use>';
                    } else {
                        echo '<use xlink:href="#logo-lider"></use>';
                    }?>
                </svg>
            </a>

            <div class="favorites">
                <span>В избранном пусто.</span>
                <a href="#"><span>Что это такое?</span></a>
            </div>

            <?=MenuWidget::widget(['model' => $menu])?>
        </div>
    </div>
</header>