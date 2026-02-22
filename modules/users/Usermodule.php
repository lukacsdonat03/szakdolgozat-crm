<?php

namespace app\modules\users;

use app\components\Constants;
use app\components\GlobalHelper;
use app\modules\users\models\User;
use Yii;
use yii\helpers\ArrayHelper;

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
    const RIGHT_MANAGER = 0;
    const RIGHT_ADMIN = 1;
    const RIGHT_FINANCIAL = 2;
    const RIGHT_ASSOCIATE = 3;

    const REMEMBER_ME_TIME = Constants::DAY_IN_SECONDS * 30;
    const ACTIVATION_TIME = Constants::DAY_IN_SECONDS * 7;

    const USERNAME_REGEXP = '/^[-a-zA-Z0-9_\.@]+$/';

    const REGISTRATION_URL = ["/users/registration/registration"];
    const REGISTRATION_SUCCESS_URL = ["/users/registration/success"];
    const LOGIN_URL = ["/users/login/login"];
    const LOGOUT_URL = ["/users/user/logout"];
    const PROFILE_URL = ["/users/profile/profile"];
    const RETURN_URL = ["/users/profile/profile"];
    const RETURN_LOGOUT_URL = ["/users/login/login"];

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
            self::RIGHT_MANAGER => 'Vezető',
            self::RIGHT_FINANCIAL => 'Pénzügyi',
            self::RIGHT_ASSOCIATE => 'Munkatárs',
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

    /**
     * 
     * TRUE-val tér vissza ha a bejelentkezett felhasználónak van ADMIN jogosultsága
     * amúgy FALSE-al
     * @return boolean
     */
    public static function hasAdminRole(){
        if(!Yii::$app->user->isGuest){
            $user = Yii::$app->user->identity;
            return ($user->rights == self::RIGHT_ADMIN);
        }
        return false;
    }

    public static function getNamesForSelect()
    {
        $models = User::find()
            ->alias('u')
            ->joinWith(['profile p'], false) 
            ->where(['u.status' => self::STATUS_ACTIVE])
            ->select(['u.id', 'name' => 'p.name']) 
            ->asArray() 
            ->all();

        $result = ArrayHelper::map($models, 'id', 'name');

        asort($result); 
        return $result;
    }

    public static function getRightHint($right = false){
        $options = [
            self::RIGHT_ADMIN => "Minden jogosultság.",
            self::RIGHT_MANAGER => "Mindenhez hozzáfér és kezelni is tudja azt, kivétel a felhasználókat.",
            self::RIGHT_FINANCIAL => "Mindent tud kezelni, de nincs törlési jogosultsága a projektekhez, feladatokhoz és az ügyfelekhez.",
            self::RIGHT_ASSOCIATE => "A feladatokat, projekteket, feladaton belüli üzenet küldést és az üzenőfalat eléri, de csak olvasási jogosultsága van hozzá, illetve nem látja a pénzügyi adatokat."
        ];
        return ($right === false) ? $options :$options[$right];
    }

    /**
     * Törlési jogosultság engedélyezése projekthez, feladatokhoz és ügyfelekhez (saját üzenetet törölhet)
     * @return boolean
     */
    public static function isDeleteEnabledForRight(){
        $user = Yii::$app->user->identity;
        $position = $user->position;
        if(!empty($position) && in_array($position->rights,self::getDeleteRights())){
            return true;
        }
        return false;
    }

    public static function getDeleteRights(){
        return [self::RIGHT_ADMIN,self::RIGHT_MANAGER];
    }

    public static function isAssociate(){
        $user = Yii::$app->user->identity;
        $position = $user->position;
        if(!empty($position) && in_array($position->rights,[self::RIGHT_ASSOCIATE])){
            return true;
        }
        return false;
    }
}

