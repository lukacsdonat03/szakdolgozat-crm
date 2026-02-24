<?php

namespace app\assets;

use yii\web\AssetBundle;

class SweetAlertAsset extends AssetBundle
{
    public $css = [
    ];
    public $js = [
        'js/sweetalert/sweetalert.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
    public $jsOptions = array(
        //'position' => \yii\web\View::POS_END,
    );
}