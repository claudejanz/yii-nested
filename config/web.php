<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'Mulaff Training Planner',
    'name' => 'Mulaff Training Planner',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'fr-CH',
//    'defaultRoute'=>'pages',
    'modules' => [
        'social' => [
// the module class
            'class' => 'kartik\social\Module',
// the global settings for the google-analytics widget
            'googleAnalytics' => [
                'id' => 'UA-74462010-1',
                'domain' => 'coach.mulaff.ch'
            ],
        ],
      
        'redactor' => 'yii\redactor\RedactorModule',
        'gridview' => [
            'class' => 'kartik\grid\Module',
        ],
        'datecontrol' => [
            'class' => 'kartik\datecontrol\Module',
            // format settings for displaying each date attribute
            'displaySettings' => [
                'date' => 'php:d-m-Y',
                'time' => 'php:H:i:s',
                'datetime' => 'php:d-m-Y H:i:s',
            ],
            // format settings for saving each date attribute
            'saveSettings' => [
                'date' => 'php:Y-m-d',
                'time' => 'php:H:i:s',
                'datetime' => 'php:Y-m-d H:i:s',
            ],
            'autoWidgetSettings' => [
                'datetime' => [
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'startView'=>3,
                        'minView'=>1,
                    ]
                ],
            ],
            // automatically use kartik\widgets for each of the above formats
            'autoWidget' => true,
        ]
    ],
    'components' => [
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                ],
            ],
        ],
        'request' => [
            'class' => 'claudejanz\toolbox\components\Request',
            'cookieValidationKey' => 'YAO0QHYbNUrODV0O7cH6M_9sbVzPiTIf',
            'web' => '/web',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'image-cache/<format:.+?>/<path:.+>' => 'image-cache/index',
//                ['class' => 'app\controllers\rules\PageUrlRules'],
//                ['class' => 'app\controllers\rules\ProjectUrlRules'],
            // your url config rules
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'mail.infomaniak.ch',
                'username' => 'no-reply@klod.ch',
                'password' => 'f96e0133ca1ec98035ab3abfd0b21c40',
                'port' => '587',
            //'encryption' => 'tls',
            ],
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'currencyCode' => 'CHF',
        ],
//        'session' => [
//            'class' => 'yii\web\Session',
//        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        // image extention
        'image' => [
            'class' => 'yii\image\ImageDriver',
            'driver' => 'GD', //GD or Imagick
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'doubleModel' => [
                'class' => 'claudejanz\mygii\generators\model\Generator',
            ],
           
            'kartikgii-crud' => ['class' => 'warrence\kartikgii\crud\Generator'],
        ],
    ];
}

return $config;