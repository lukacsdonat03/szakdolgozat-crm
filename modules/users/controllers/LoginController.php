<?php

namespace app\modules\users\controllers;

use app\base\Controller;
use app\components\AppAlert;
use app\components\GlobalHelper;
use app\modules\users\Usermodule;
use app\modules\users\models\forms\LoginForm;
use Yii;
use yii\filters\AccessControl;


class LoginController extends Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => ['login'],
                            'allow' => true,
                        ],
                    ],
                ],
            ]
        );
    }

    public function actionLogin(){
          if(!Yii::$app->user->isGuest) {
            return $this->redirect(Usermodule::PROFILE_URL);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            if($model->login()){
                return $this->redirect("/");
            }else{
                Yii::error($model->errors);
            }
        } else if(Yii::$app->request->isPost){
            AppAlert::addErrorAlert('Hiba történt bejelentkezés közben');
        }
    
        return $this->render('login', [
            'model' => $model,
        ]);   
    }
}
