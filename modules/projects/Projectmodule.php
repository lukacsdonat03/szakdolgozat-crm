<?php

namespace app\modules\projects;

/**
 * projects module definition class
 */
class Projectmodule extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\projects\controllers';

    const PRIORITY_LOW = 0;
    const PRIORITY_MEDIUM = 1;
    const PRIORITY_HIGH = 2;
    const PRIORITY_SOS = 3;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }

    public static function getPriorities($item = false){
        $options = [
            self::PRIORITY_LOW => 'Alacsony',
            self::PRIORITY_MEDIUM => 'Közepes',
            self::PRIORITY_HIGH => 'Magas',
            self::PRIORITY_SOS => 'SOS',
        ];

        return ($item !== false && !empty($options[$item])) 
            ? $options[$item] 
            : $options;  
    }
}
