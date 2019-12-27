<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru-RU',
    'sourceLanguage' =>'ru-RU',

    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                ],
            ],
        ],

        'formatter' => [
            'dateFormat' => 'dd.MM.yyyy',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'numberFormatterOptions' => [
                NumberFormatter::MIN_FRACTION_DIGITS => 0,
                NumberFormatter::MAX_FRACTION_DIGITS => 0,
            ],
            'numberFormatterSymbols' => [
                NumberFormatter::CURRENCY_SYMBOL => '&#8381;',
            ]
        ],

        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => '@frontend/assets/app/static',
                    'js' => [
                        'js/separate-js/jquery.js',
                    ]
                ],
            ],
        ],

        'urlManager' => [

            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'suffix' => '.html',
            'rules' => [
                '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
                '<_c:[\w\-]+>' => '<_c>/index',
                '<_c:[\w\-]+>/<_a:[\w\-]+>/<id:\d+>' => '<_c>/<_a>',
            ],
        ],
    ],
    'params' => $params,
];
