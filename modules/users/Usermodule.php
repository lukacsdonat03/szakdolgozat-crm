<?php

namespace app\modules\users;

use app\components\Constants;
use app\modules\users\models\User;

/**
 * user module definition class
 */
class Usermodule extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\users\controllers';

    //STATUSES
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_BANNED = 2;

    //RIGHTS
    const RIGHT_USER = 0;
    const RIGHT_ADMIN = 1;

    const REMEMBER_ME_TIME = Constants::DAY_IN_SECONDS * 30;
    const ACTIVATION_TIME = Constants::DAY_IN_SECONDS * 7;

    const USERNAME_REGEXP = '/^[-a-zA-Z0-9_\.@]+$/';

    const REGISTRATION_URL = ["/users/registration/registration"];
    const REGISTRATION_SUCCESS_URL = ["/users/registration/success"];
    const LOGIN_URL = ["/users/login/login"];
    const LOGOUT_URL = ["/users/logout/logout"];   //TODO
    const PROFILE_URL = ["/users/profile/profile"];
    const RETURN_URL = ["/users/profile/profile"];
    const RETURN_LOGOUT_URL = ["/"];

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

    }

    public static function status($item=false)
    {
        $values = [
            self::STATUS_ACTIVE => 'Aktív',
            self::STATUS_INACTIVE => 'Inaktív',
            self::STATUS_BANNED => 'Kitíltva',
        ];
        return ($item===false)? $values : ((!empty($values[$item]))?$values[$item]:'');
    }

    public static function getRights($item = false){
        $options = [
            self::RIGHT_USER => 'Felhasználó',
            self::RIGHT_ADMIN => 'Admin',
        ];
        return ($item === false) ? $options : $options[$item];
    }

     public static function encrypting($string="") {
        return password_hash($string, PASSWORD_DEFAULT);    //bcrypt a default
    }

    public static function passwordVerify($password, $hash) {
        return password_verify($password, $hash);
    }

    public static function generateToken($token) {
        return md5($token.microtime());
    }

     public static function generateUsername($email, $id = false) {
        $username = explode("@", $email);
        $username = $username[0];
        $baseusername = $username;
        if(!empty($id)) {
            $user = User::find()->where('username="' . $username . '" AND id!=' . $id)->one();
        } else {
            $user = User::find()->where('username="' . $username . '"')->one();
        }
        while (!empty($user)) {
            $username = $baseusername.'-'.rand(100, 999);
            if(!empty($id)) {
                $user = User::find()->where('username="' . $username . '" AND id!=' . $id)->one();
            } else {
                $user = User::find()->where('username="' . $username . '"')->one();
            }
        }

        return $username;
    }
}

