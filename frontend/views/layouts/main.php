<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use frontend\assets\MainAsset;

/**
 * @var $this \yii\web\View
 * @var $content string
 */

$asset = MainAsset::register($this);
$this->title = 'Новый Раменский';

$svg_revision = filemtime($asset->basePath . '/static/img/svg-symbols.svg') ;
$js = <<<JS
window.config = window.config || {};
window.config.svg = {
	root: '{$asset->baseUrl}/static/img/',
	filename: 'svg-symbols.svg',
	revision: {$svg_revision}
};
JS;

$this->registerJs($js, \yii\web\View::POS_HEAD);
?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?=Yii::$app->language?>">
    <?=$this->render('head', ['asset' => $asset])?>

    <?=Html::beginTag('body', [
        'class' => isset($this->params['bodyClass']) ? 'page ' . $this->params['bodyClass'] : 'page'
    ])?>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MCHRKFT"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <script type="text/javascript">
        var yaParams = {ip_address: "<?=Yii::$app->getRequest()->getUserIP()?>"};
    </script>


    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
        (function (d, w, c) {
            (w[c] = w[c] || []).push(function() {
                try {
                    w.yaCounter46889058 = new Ya.Metrika({
                        id:46889058,
                        params:window.yaParams,
                        clickmap:true,
                        trackLinks:true,
                        accurateTrackBounce:true,
                        webvisor:true
                    });
                } catch(e) { }
            });

            var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function () { n.parentNode.insertBefore(s, n); };
            s.type = "text/javascript";
            s.async = true;
            s.src = "https://mc.yandex.ru/metrika/watch.js";

            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else { f(); }
        })(document, window, "yandex_metrika_callbacks");
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/46889058" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->

    <?php $this->beginBody()?>


        <div class="page__wrapper">
            <?=$this->render('header')?>

            <?php if (isset($this->params['pageHeader']) || isset($this->params['breadcrumbs'])) {?>
                <div class="page_header">
                    <div class="page_header__container">
                        <div class="page_header__content">

                            <?php if (isset($this->params['breadcrumbs'])) {?>
                                <?php $breadcrumbs = ArrayHelper::merge(
                                    [['label' => 'Главная', 'url' => '/']],
                                    $this->params['breadcrumbs']
                                )?>
                                <div class="page_breadcrumbs">
                                    <?php foreach ($breadcrumbs as $breadcrumb) {
                                        if(isset($breadcrumb['url'])) {
                                            echo Html::a($breadcrumb['label'], Url::to($breadcrumb['url']), [
                                                'class' => 'page_breadcrumbs__item'
                                            ]);
                                        } else {
                                            echo Html::tag('span', $breadcrumb['label'], [
                                                'class' => 'page_breadcrumbs__item'
                                            ]);
                                        }
                                    }?>
                                </div>
                            <?php }?>

                            <div class="page_title">
                                <?=Html::tag('h1', $this->params['pageHeader'], ['class' => 'title--xxl'])?>
                            </div>

                        </div>
                    </div>
                </div>
            <?php }?>

            <?=$content?>

            <?=$this->render('modals')?>
        </div>

        <div class="page__footer">
            <?=$this->render('footer')?>
        </div>

    <?php $this->endBody()?>

    <?=Html::endTag('body')?>

    </html>
<?php $this->endPage()?>