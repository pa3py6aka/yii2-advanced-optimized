<?php

namespace frontend\widgets\ModalAuthWidget;

use yii\web\AssetBundle;
use yii\web\YiiAsset;
use yii\bootstrap4\BootstrapAsset;

/**
 * Main frontend application asset bundle.
 */
class ModalAuthAsset extends AssetBundle
{
    public $sourcePath = '@frontend/widgets/ModalAuthWidget/assets';

    public $css = [
        'modal-auth.css',
    ];
}
