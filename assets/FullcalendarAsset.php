<?php

namespace app\assets;

use yii\web\AssetBundle;

class FullcalendarAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        
    ];
    public $js = [
        '/js/fullcalendar/dist/index.global.min.js'
    ];
    public $depends = [
    ];
}
