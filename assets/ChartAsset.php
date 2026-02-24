<?php 

namespace app\assets;

use yii\web\AssetBundle;

class ChartAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/apexcharts/dist/apexcharts.min.js', 
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}