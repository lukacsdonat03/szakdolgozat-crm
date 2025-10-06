<?php

namespace app\base;

use Yii;

class Controller extends \yii\web\Controller{
    
    public function beforeAction($action){
        if(parent::beforeAction($action)) {
            if(in_array(Yii::$app->controller->id,['registration','login'])){
                $this->layout = '@app/themes/main/layouts/auth';
            }else{
                $this->layout = '@app/themes/main/layouts/main';
            }
            return true;
        }
        return false;
    }

}