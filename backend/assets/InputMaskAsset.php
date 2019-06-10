<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Asset for Input Mask Plugin
 */
class InputMaskAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'plugins/input-mask/plugin.js',
    ];

    public $depends = [
        AppAsset::class,
    ];
}
