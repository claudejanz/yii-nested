<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');
Yii::setAlias('@vendor', dirname(__DIR__) . '/vendor');
Yii::setAlias('@webroot', dirname(__DIR__) . '/web');
Yii::setAlias('@web', '/web');

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

return [
    'id' => 'Klod.ch',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'fr-CH',
    'controllerNamespace' => 'claudejanz\toolbox\commands',
    'controllerMap' => [
        'rbac2' => 'app\commands\RbacController',
        'reset' => 'app\commands\ResetController',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl' => '/',
            'rules' => [
                'image-cache/<format:.+?>/<path:.+>' => 'image-cache/index',
                ['class' => 'app\controllers\rules\PageUrlRules'],
            // your url config rules
            ]
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'currencyCode' => 'CHF',
        ],
        'user' => [
            'class' => 'claudejanz\toolbox\models\fake\User',
        //'identityClass' => 'app\models\fake\User',
        ],
        'db' => $db,
    ],
    'params' => $params,
];
