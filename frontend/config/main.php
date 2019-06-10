<?php

use yii\log\FileTarget;
use yii\authclient\Collection;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'class' => \components\YiiUser::class,
            'identityClass' => \common\models\User\User::class,
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
                    'class' => FileTarget::class,
                    'levels' => ['error', 'warning'],
                    'except' => [
                        'yii\web\HttpException:404',
                    ],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'assetManager' => [
            'appendTimestamp' => true,
            'bundles' => [
                \yii\bootstrap\BootstrapAsset::class => ['css' => []],
                \yii\bootstrap\BootstrapPluginAsset::class => ['js' => []],
            ]
        ],
        'authClientCollection' => [
            'class' => Collection::class,
            'clients' => [
                'vkontakte' => [
                    'class' => \yii\authclient\clients\VKontakte::class,
                    'clientId' => 'Client ID',
                    'clientSecret' => 'Client Secret',
                    'scope' => 'email'
                ],
                'facebook' => [
                    'class' => \yii\authclient\clients\Facebook::class,
                    'clientId' => 'Client ID',
                    'clientSecret' => 'Client Secret',
                ],
                'google' => [
                    'class' => \yii\authclient\clients\Google::class,
                    'clientId' => 'Client ID',
                    'clientSecret' => 'Client Secret',
                    'scope' => 'profile email',
                ],
            ],
        ],
        'backendUrlManager' => require __DIR__ . '/../../backend/config/urlManager.php',
        'frontendUrlManager' => require __DIR__ . '/urlManager.php',
        'urlManager' => function () {
            return Yii::$app->get('frontendUrlManager');
        },
    ],
    'params' => $params,
];
