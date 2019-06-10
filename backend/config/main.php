<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'admin-cp', // If change, you must know - its use in /core/forms/auth/LoginForm
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'class' => \components\YiiUser::class,
            'identityClass' => \common\models\User\User::class,
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
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
                \yii\bootstrap\BootstrapPluginAsset::class => ['js' => []],
                \yii\bootstrap\BootstrapAsset::class => ['css' => []],
                \yii\bootstrap4\BootstrapPluginAsset::class => ['js' => []],
                \yii\bootstrap4\BootstrapAsset::class => ['css' => []],
            ],
        ],
        'frontendUrlManager' => require __DIR__ . '/../../frontend/config/urlManager.php',
        'backendUrlManager' => require __DIR__ . '/urlManager.php',
        'urlManager' => function () {
            return Yii::$app->get('backendUrlManager');
        },
    ],
    'params' => $params,
    'container' => [
        'definitions' => [
            \yii\data\Pagination::class => ['forcePageParam' => false],
            \yii\grid\GridView::class => [
                'pager' => ['class' => \yii\bootstrap4\LinkPager::class],
                'layout' => "{items}\n{pager}",
                'tableOptions' => ['class' => 'table table-hover table-outline table-vcenter text-nowrap card-table']
            ],
            \yii\bootstrap4\LinkPager::class => ['options' => ['class' => 'float-right mt-3']],
            \yii\grid\ActionColumn::class => [
                'template' => '{view}&nbsp; &nbsp;{update}&nbsp; &nbsp;{delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return \yii\bootstrap4\Html::a('<i class="fa fa-eye"></i>', $url, ['data-toggle' => 'tooltip', 'title' => 'View']);
                    },
                    'update' => function ($url, $model, $key) {
                        return \yii\bootstrap4\Html::a('<i class="fas fa-edit"></i>', $url, ['data-toggle' => 'tooltip', 'title' => 'Edit', 'class' => 'text-green']);
                    },
                    'delete' => function ($url, $model, $key) {
                        return \yii\bootstrap4\Html::a('<i class="fa fa-trash"></i>', $url, [
                            'data-confirm' => 'Remove this item??',
                            'data-method' => 'post',
                            'data-toggle' => 'tooltip',
                            'title' => 'Remove',
                            'class' => 'text-red'
                        ]);
                    },
                ],
            ],
            \yii\widgets\DetailView::class => ['options' => ['class' => 'table table-striped table-bordered detail-view mb-0']],
        ],
    ],
    'as access' => [
        'class' => \yii\filters\AccessControl::class,
        'except' => ['site/login', 'site/error'],
        'rules' => [
            [
                'allow' => true,
                'roles' => [\core\access\Rbac::ROLE_ADMIN, \core\access\Rbac::ROLE_MODERATOR],
            ],
        ],
    ],
];
