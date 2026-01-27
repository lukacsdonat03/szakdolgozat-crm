<?php

namespace app\modules\projects\models;

use app\base\Model;
use Yii;

/**
 * This is the model class for table "project_statuses".
 *
 * @property int $id Azonosító
 * @property string $name Név
 * @property string $color_code Szín
 *
 * @property Project[] $projectProjects
 */
class Status extends Model
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_statuses';
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
     * Gets query for [[ProjectProjects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::class, ['status_id' => 'id']);
    }

}
