<?php

namespace app\modules\projects\models;

use app\base\Model;
use Yii;

/**
 * This is the model class for table "project_tag_relation".
 *
 * @property int $id Azonosító
 * @property int $project_id Projekt
 * @property int $tag_id Tag
 */
class ProjectTagRelation extends Model
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_tag_relation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'tag_id'], 'required'],
            [['project_id', 'tag_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Azonosító',
            'project_id' => 'Projekt',
            'tag_id' => 'Tag',
        ];
    }

}
