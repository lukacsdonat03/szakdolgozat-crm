<?php

namespace app\modules\users\models;

use Yii;
use yii\web\IdentityInterface;
use app\modules\users\models\Profile;

/**
 * This is the model class for table "user_users".
 *
 * @property int $id Azonosító
 * @property string $username Felhasználónév
 * @property string $email E-mail cím
 * @property string $password Jelszó
 * @property string|null $registration_date Regisztráció dátuma
 * @property int $status Státusz
 * @property string|null $token AuthToken
 *
 * @property Profile[] $userProfiles
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
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
            [['token'], 'string', 'max' => 32],
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
            'token' => 'Token',
        ];
    }

    public function beforeSave($insert){
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->registration_date = date("Y-m-d H:i:s");
            }
            return true;
        }
        return false;
    }

    /**
     * Gets query for [[UserProfiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasMany(Profile::class, ['user_id' => 'id']);
    }

    //Implemented functions from IdentityInterface
     
    public static function findIdentity($id) {
        $user = self::findOne($id);
        return (!empty($user))?$user:null;
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        $user = self::find()->where(["token" => $token])->one();
        return (!empty($user))?$user:null;
    }
     public function getId() {
        return $this->id;
    }

    public function getAuthKey() {
        return $this->token;
    }

    public function validateAuthKey($authKey) {
        return $this->token === $authKey;
    }


      /**
     * Felhasználó keresése felhasználónév alapján
     * @param $username string Felhasználónév
     * @return static|null
     */
    public static function findByUsername($username) {
        $user = self::find()->where(["username" => $username])->one();
        return (!empty($user))?$user:null;
    }

    /**
     * Felhasználó keresése e-mail cím alapján
     * @param $email string E-mail cím
     * @return static|null
     */
    public static function findByEmail($email) {
        $user = self::find()->where(["email" => $email])->one();
        return (!empty($user))?$user:null;
    }
}
