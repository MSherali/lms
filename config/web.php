<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'language' => 'uz-Latn',
    'id' => 'uLMS',
    'name' => 'LMS',
    'timeZone' => 'Asia/Tashkent',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log',
        [
            'class' => 'app\components\LanguageSelector',
            'supportedLanguages' => ['ru-RU', 'uz-CY', 'uz-Latn', 'en'],
        ]
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '7ZVwz1WOXWofMx4bAW7TCW12qOptu_sH',
        ],
        /*'cache' => [
            'class' => 'yii\caching\FileCache',
        ],*/
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => require(__DIR__ . '/db.php'),

        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Hide index.php
            'showScriptName' => false,
            // Use pretty URLs
            'enablePrettyUrl' => true,
            'rules' => [
            ],
        ],

        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],

        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                ],
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
