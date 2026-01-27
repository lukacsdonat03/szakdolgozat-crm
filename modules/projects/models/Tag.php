<?php

namespace app\modules\projects\models;

use app\base\Model;
use Yii;

/**
 * This is the model class for table "project_tags".
 *
 * @property int $id Azonosító
 * @property string $name Név
 * @property string $color_code Szín
 */
class Tag extends Model
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_tags';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 68],
            [['color_code'], 'string', 'max' => 7],
        ];
    }

 public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
           
            //Alapértelmezett szín a fekete
            if(empty($this->color_code)){
                $this->color_code = '#000000';
            }

            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Azonosító',
            'name' => 'Név',
            'color_code' => 'Szín',
        ];
    }
}
