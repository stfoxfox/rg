<?php
use yii\helpers\Html;

/**
 * @var $this \yii\web\View
 * @var $asset \frontend\assets\DummyAsset
 */
?>
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <?= Html::csrfMetaTags() ?>
    <title><?=Html::encode($this->title)?></title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?=$asset->baseUrl?>/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="<?=$asset->baseUrl?>/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?=$asset->baseUrl?>/favicon-16x16.png" />
    <link rel="manifest" href="<?=$asset->baseUrl?>/manifest.json" />
    <link rel="mask-icon" href="<?=$asset->baseUrl?>/safari-pinned-tab.svg" color="#5bbad5" />
    <meta name="theme-color" content="#ffffff" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="telephone=no" name="format-detection" />
    <meta name="HandheldFriendly" content="true" />

    <link rel="icon" type="image/x-icon" href="<?=$asset->baseUrl?>/favicon.ico" />
    <script>
        (function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)
    </script>

    <?php $this->head() ?>
    <script type="text/javascript">
        var __cs = __cs || [];
        __cs.push(["setCsAccount", "cHbiPxR3HSXSEmuYNi1uNNeQhPnncV2o"]);
    </script>
    <script type="text/javascript" async src="//app.comagic.ru/static/cs.min.js"></script>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-MCHRKFT');</script>
    <!-- End Google Tag Manager -->

</head>