<?php
use yii\helpers\Inflector;

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],

    'params' => [
        'siteMap' => [
            'flats' => [
                'name' => 'Контроллер квартир',
                'actions' => [
                    Inflector::camel2id('Index') => [
                        'name' => 'Список квартир',
                    ],
                    Inflector::camel2id('View') => [
                        'name' => 'Просмотр квартиры',
                        'params' => [
                            'id' => [
                                'name' => 'Квартира',
                                'class' => \common\models\Flat::className(),
                                'title_attr' => 'number',
                            ],
                        ]
                    ],
                ],
            ],

            'promo' => [
                'name' => 'Контроллер спецпредложений',
                'actions' => [
                    Inflector::camel2id('Index') => [
                        'name' => 'Спецпредложения',
                    ],
                ],
            ],

            'site' => [
                'name' => 'Контроллер сайта',
                'actions' => [
                    Inflector::camel2id('About') => [
                        'name' => 'О застройщике',
                    ],
                    Inflector::camel2id('Documents') => [
                        'name' => 'Документы',
                    ],
                    Inflector::camel2id('Contact') => [
                        'name' => 'Контакты',
                    ],
                ],
            ],
        ]
    ],

];
