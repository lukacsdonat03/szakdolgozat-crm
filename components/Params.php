<?php

namespace app\components;

use Yii;

class Params extends \yii\base\Component
{
    /**
     * Visszadja a paraméter értékét, ha nincs, akkor üres stringet
     * @param $param string paraméter key
     * @return mixed|string
     */
    public static function getParam($param)
    {
        return (isset(Yii::$app->params[$param]))?Yii::$app->params[$param]:'';
    }
}