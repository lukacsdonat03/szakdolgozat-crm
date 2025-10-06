<?php

namespace app\modules\users\models\forms;

use app\components\AppAlert;
use app\components\GlobalHelper;
use app\modules\users\models\User;
use app\modules\users\Usermodule;
use Yii;
use yii\base\Model;

class LoginForm extends Model{

    public $username;
    public $password;
    public $_user = false;

      public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['password', 'validatePassword'],    
        ];
    }

     /**
     * Jelszó validálás
     * @param $attribute
     * @param $params
     * @return void
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !Usermodule::passwordVerify($this->password, $user->password)) {
                $msg = 'Helytelen e-mail cím jelszó páros.';
                AppAlert::addErrorAlert($msg);
                $this->addError($attribute, $msg);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Felhasználónév vagy e-mail',
            'password' => 'Jelszó',
        ];
    }

    /**
     * Bejelentkezés
     * @return bool
     */
    public function login()
    {
        if ($this->validate()) {
            $user=$this->getUser();
            if($user->status==Usermodule::STATUS_BANNED)
            {
                AppAlert::addErrorAlert('Felhasználói profilja tíltva.');
                return false;
            } elseif($user->status==Usermodule::STATUS_INACTIVE)  {
                AppAlert::addErrorAlert(  'Profilja még nem aktív!');
                return false;
            }


            if(Yii::$app->user->login($user,Usermodule::REMEMBER_ME_TIME)) {
                return true;
            }

            return false;
        } else {
            return false;
        }
    }

    /**
     * Felhasznűló keresése
     * @return User|null
     */
    public function getUser()
    {
        
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }
        if ($this->_user == false) {
            $this->_user = User::findByEmail($this->username);
        }

        return $this->_user;
    }
}
