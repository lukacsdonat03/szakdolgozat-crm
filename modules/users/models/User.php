<?php

namespace app\modules\users\models;

use Yii;

/**
 * This is the model class for table "user_users".
 *
 * @property int $id Azonosító
 * @property string $username Felhasználónév
 * @property string $email E-mail cím
 * @property string $password Jelszó
 * @property string|null $registration_date Regisztráció dátuma
 * @property int $status Státusz
 *
 * @property UserProfiles[] $userProfiles
 */
class User extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['registration_date'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 0],
            [['username', 'email', 'password'], 'required'],
            [['registration_date'], 'safe'],
            [['status'], 'integer'],
            [['username', 'email'], 'string', 'max' => 128],
            [['password'], 'string', 'max' => 60],
            [['username'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Azonosító',
            'username' => 'Felhasználónév',
            'email' => 'E-mail cím',
            'password' => 'Jelszó',
            'registration_date' => 'Regisztráció dátuma',
            'status' => 'Státusz',
        ];
    }

    /**
     * Gets query for [[UserProfiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfiles()
    {
        return $this->hasMany(UserProfiles::class, ['user_id' => 'id']);
    }

}
