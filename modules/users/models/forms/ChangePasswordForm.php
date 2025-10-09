<?php

namespace app\modules\users\models\forms;

use app\components\AppAlert;
use app\modules\users\models\User;
use app\modules\users\Usermodule;
use Yii;

/**
 * Jelszómódosítás
 */
class ChangePasswordForm extends \yii\base\Model
{
    public $verify_password;
    public $old_password;
    public $password;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['old_password', 'required'],
            ['old_password', 'verifyoldpassword'],
            ['verify_password', 'required'],
            ['verify_password', 'string', 'min' => 6],
            ['verify_password', 'compare', 'compareAttribute'=>'password', 'message' => "A két jelszó nem eggyezik."],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'password' => 'Jelszó',
            'verify_password' =>  'Jelszó újra',
            'old_password' => 'Régi jelszó',
        ];
    }

    /**
     * Régi jelszó validálás
     * @param $attribute
     * @param $params
     * @return void
     */
    public function verifyoldpassword($attribute, $params)
    {
        if (!Usermodule::passwordVerify($this->$attribute, User::findOne(Yii::$app->user->id)->password)) {
            $msg = "A régi jelszó helytelen.";
            AppAlert::addErrorAlert($msg);
            $this->addError($attribute, $msg);
        }
    }

    /**
     * Jelszó módosítása
     * @return bool
     */
    public function changepassword()
    {
        if ($this->validate()) {

            $user=User::findOne(Yii::$app->user->id);

            $user->token=Usermodule::generateToken($user->id);
            $user->password=Usermodule::encrypting($this->password);

            $user->save();

            return true;
        }

        return false;
    }
}