<?php

namespace app\components;

use yii\base\Component;

class GlobalHelper extends Component
{

    /**
     * A paraméterként kapott változót adja vissza
     * és megszakítja a kódot
     * @param $var mixed változó vagy string
     * @return void
     */
    public static function debug($var){
        header('Content-type: text/plain; charset=utf-8');
        print_r($var);
        exit();
    }

    public static function getValueFromArray($array, $key){
        return (!empty($array[$key]))?$array[$key]:'';
    }

}