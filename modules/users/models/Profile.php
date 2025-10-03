<?php

namespace app\modules\users\models;

use Yii;

/**
 * This is the model class for table "user_profiles".
 *
 * @property int $id Azonosító
 * @property int $user_id Felhasználó
 * @property string $name Név
 * @property int|null $phone Telefonszám
 * @property int|null $position_id Beosztés
 *
 * @property UserPositions $position
 * @property UserUsers $user
 */
class Profile extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_profiles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone', 'position_id'], 'default', 'value' => null],
            [['user_id', 'name'], 'required'],
            [['user_id', 'phone', 'position_id'], 'integer'],
            [['name'], 'string', 'max' => 128],
            [['position_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserPositions::class, 'targetAttribute' => ['position_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserUsers::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Azonosító',
            'user_id' => 'Felhasználó',
            'name' => 'Név',
            'phone' => 'Telefonszám',
            'position_id' => 'Beosztés',
        ];
    }

    /**
     * Gets query for [[Position]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosition()
    {
        return $this->hasOne(UserPositions::class, ['id' => 'position_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(UserUsers::class, ['id' => 'user_id']);
    }

}
