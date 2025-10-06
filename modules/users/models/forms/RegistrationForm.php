<?php

namespace app\modules\users\models\forms;

use app\components\GlobalHelper;
use app\modules\users\models\Profile;
use app\modules\users\models\User;
use Yii;
use app\modules\users\Usermodule;

class RegistrationForm extends User{
    public $verifyPassword;
    public $username;
    public $name;

    public function rules(){
        return [
            [['email', 'password', 'verifyPassword','name','username'], 'required'],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email', 'unique', 'message' =>  'Ez az email cím foglalt.'],
            ['password', 'string', 'min' => 6],
            [['name','username'], 'string', 'max' => 128],
            ['verifyPassword', 'required'],
            ['verifyPassword', 'string', 'min' => 6],
            ['verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => "A két jelszó nem eggyezik."],
        ];
    }

    public function attributeLabels(){
        return [
            'email' => 'E-mail cím',
            'password' => 'Jelszó',
            'verifyPassword' => 'Jelszó megerősítése',
            'username' => 'Felhasználónév',
            'name' => 'Név',
        ];
    }

     public function registration()
    {
        $profile = new Profile();
        if ($this->validate()) {

            $password = $this->password;
            $this->token=Usermodule::generateToken($this->password);
            $this->password=$this->verifyPassword=Usermodule::encrypting($this->password);
            $this->status = Usermodule::STATUS_INACTIVE;
            
            if($this->save()) {
                $profile = new Profile();
                $profile->user_id = $this->id;
                $profile->name = $this->name;
                if($profile->save()) {
                    return true;
                }
            }
            $this->password=$password;
            $this->verifyPassword=$password;
        }else{
            GlobalHelper::debug([$this->errors,$profile->errors]);
        }

        return false;
    }
}