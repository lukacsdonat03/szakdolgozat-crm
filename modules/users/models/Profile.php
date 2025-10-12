<?php

namespace app\modules\users\models;

use Yii;

/**
 * This is the model class for table "user_profiles".
 *
 * @property int $id Azonosító
 * @property int $user_id Felhasználó
 * @property string $name Név
 * @property string|null $phone Telefonszám
 * @property int|null $position_id Beosztás
 *
 * @property Position $position
 * @property User $user
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
            [['user_id', 'position_id'], 'integer'],
            [['name'], 'string', 'max' => 128],
            [['phone'], 'string', 'max' => 32],
            [['position_id'], 'exist', 'skipOnError' => true, 'targetClass' => Position::class, 'targetAttribute' => ['position_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'position_id' => 'Beosztás',
        ];
    }

    /**
     * Gets query for [[Position]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosition()
    {
        return $this->hasOne(Position::class, ['id' => 'position_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
