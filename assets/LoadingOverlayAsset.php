<?php

namespace app\assets;

use yii\web\AssetBundle;

class LoadingOverlayAsset extends AssetBundle
{
    public $css = [
    ];
    public $js = [
        'js/loadingoverlay/loadingoverlay.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
    public $jsOptions = array(
        //'position' => \yii\web\View::POS_END,
    );
}