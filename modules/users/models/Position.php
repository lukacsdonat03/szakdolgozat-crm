<?php

namespace app\modules\users\models;

use Yii;

/**
 * This is the model class for table "user_positions".
 *
 * @property int $id Azonosító
 * @property string $name Megnevezés
 * @property int $rights Jogosultság
 *
 * @property UserProfiles[] $userProfiles
 */
class Position extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_positions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rights'], 'default', 'value' => 0],
            [['name'], 'required'],
            [['rights'], 'integer'],
            [['name'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Azonosító',
            'name' => 'Megnevezés',
            'rights' => 'Jogosultság',
        ];
    }

    /**
     * Gets query for [[UserProfiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfiles()
    {
        return $this->hasMany(UserProfiles::class, ['position_id' => 'id']);
    }

}
