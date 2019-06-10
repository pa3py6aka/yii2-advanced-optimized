<?php

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        //'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
        'https://use.fontawesome.com/releases/v5.8.2/css/all.css',
        'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext',
        'css/dashboard.css',
        'css/style.css',
    ];

    public $js = [
        'js/dashboard.js',
    ];

    public $depends = [
        YiiAsset::class,
    ];
}
