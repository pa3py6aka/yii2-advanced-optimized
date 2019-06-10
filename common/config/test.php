<?php
return [
    'id' => 'app-common-tests',
    'basePath' => dirname(__DIR__),
    'components' => [
        'user' => [
            'class' => \components\YiiUser::class,
            'identityClass' => \common\models\User\User::class,
        ],
    ],
];
