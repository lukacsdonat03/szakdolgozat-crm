<?php

namespace app\base;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Model extends ActiveRecord {

    const NO = 0;
    const YES = 1;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public static function getYesNo($item = false){
        $options = [
            self::NO => 'Nem',
            self::YES => 'Igen',
        ];
        return ($item === false) ? $options : $options[$item];
    }

    public static function getStatuses($item = false){
        $options = [
            self::STATUS_INACTIVE => 'Inaktív',
            self::STATUS_ACTIVE => 'Aktív',
        ];
        return ($item === false) ? $options : $options[$item];
    }

    /**
     * Előkészít egy tömböt lenyíló listához az aktuális model rekordjaiból
     * @param boolean $addEmpty - Ha true a lista elejére beszűr egy "Nincs" stringet 0-s kulccsal
     * @param string $key A kulcs mező neve (pl. 'id')
     * @param string $value Az érték mező neve (pl. 'name')
     * @return array Kulcs-érték párok
     */
    public static function getListForSelect($addEmpty = false,$key = 'id',$value = 'name',$order = false){
        $result = [];
        $query = static::find()->select([$key,$value])->asArray();
        if(!empty($order)){
            $query->orderBy([$order => SORT_ASC]);
        }else{
            $query->orderBy([$value => SORT_ASC]);
        }
        
        $items = $query->all();
        $result = ArrayHelper::map($items,$key,$value);

        if($addEmpty === true){
            $result = ArrayHelper::merge([0 => 'Nincs'],$result);
        }

        return $result;
    }

}