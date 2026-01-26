<?php

namespace app\modules\users\controllers;

use app\base\Controller;
use app\components\AppAlert;
use app\components\GlobalHelper;
use app\modules\users\models\forms\RegistrationForm;
use app\modules\users\Usermodule;
use yii\filters\AccessControl;
use Yii;

class RegistrationController extends Controller{

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => ['registration', 'success'],
                            'allow' => false /* true */,    //Nincs szükség regisztrációra
                        ],
                    ],
                ],
            ]
        );
    }

    public function actionRegistration(){
        if(!Yii::$app->user->isGuest){
            return $this->redirect(Usermodule::PROFILE_URL);
        }
        
        $model = new RegistrationForm();

        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post())){
            if($model->registration()){
                $session = Yii::$app->session;
                $session->set('registration','sucesss');
                return $this->redirect(['success']);
            }else{
                AppAlert::addErrorAlert('Hiba történt regisztráció közben!');
            }
        }

        return $this->render('registration',[
            'model' => $model,
        ]);
    }

    public function actionSuccess(){
        return $this->render('success');
    }
}