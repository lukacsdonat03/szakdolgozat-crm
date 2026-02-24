<?php

namespace app\assets;

use yii\web\AssetBundle;

class LayoutAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/themes/main/css/layout.css'
    ];
    public $js = [
        '/js/layout.js'
    ];
    public $depends = [
    ];
}
