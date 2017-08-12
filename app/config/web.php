<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'basic',
    'name' => 'All Indonesia',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'admins' => ['admin'],
            'enableConfirmation' => false,
            'enableRegistration' => false
        ],
        'rbac' => 'dektrium\rbac\RbacWebModule',
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
        'treemanager' =>  [
            'class' => '\kartik\tree\Module',
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ],
        'social'=>[
            'class' => 'kartik\social\Module',
            'facebook' => [
                'app_id' => '430945680280078',
                'app_secret' => '27f83d4e8eb2b54a18a7111769803d4c',
            ],
        ],
    ],
    'components' => [
        'global' => [
            'class' => 'app\modules\admin\components\Orezomi',
        ],
        'view' => [
             'theme' => [
                 'pathMap' => [
                    '@app/views' => '@app/views/adminlte',
                    '@dektrium/user/views' => '@app/views/user',
                    '@dektrium/rbac/views' => '@app/views/rbac'
                 ],
             ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'qylnHC23ESWf6xm1tr9Y9HgpcJg79EqS',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
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
        'db' => $db,
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
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
        'generators' => [
            'crud'   => [
                'class'     => 'yii\gii\generators\crud\Generator',
                'templates' => ['mycrud' => '@app/template/mycrud']
            ]
        ],
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
