<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'getup',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'layout' => 'main',
    'components' => [
    	  'eauth' => require('eauth.php'),
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '9ybV0IsZz7v0qj8snv7fz7Dr2YCUDbJh',
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
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'search/?' => 'main/search',
                'inst/?' => 'main/inst',
                'tech/?' => 'main/tech',
                'feedback' => 'main/feedback',
                'about' => 'main/about',
                //ajax
                'getlink' => 'main/getlink',
                    //regions
                'sumy' => 'main/region',
                'kiev' => 'main/region',
                'donetsk' => 'main/region',
                'lviv' => 'main/region',
                'odessa' => 'main/region',
                'volyn' => 'main/region',
                'vinnytsia' => 'main/region',
                'dnipropetrovsk' => 'main/region',
                'zhytomyr' => 'main/region',
                'zakarpattia' => 'main/region',
                'zaporizhia' => 'main/region',
                'ivano-frankivsk' => 'main/region',
                'kirovohrad' => 'main/region',
                'crimea' => 'main/region',
                'lugansk' => 'main/region',
                'mykolaiv' => 'main/region',
                'poltava' => 'main/region',
                'rivne' => 'main/region',
                'ternopil' => 'main/region',
                'kharkiv' => 'main/region',
                'herson' => 'main/region',
                'khmelnytsky' => 'main/region',
                'cherkasy' => 'main/region',
                'chernigov' => 'main/region',
                'chernivtsi' => 'main/region',
                //directions
                'directions/?<instance:\w*>/?<id:\d*>/?' => 'main/directions',
                // selected institutions
                'inst/<id:\d+>/?' => 'main/iselected',
                'tech/<id:\d+>/?' => 'main/tselected',
                '<en_title:\w+>' => 'main/iselected',
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
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
