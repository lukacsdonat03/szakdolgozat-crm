<?php

namespace app\base;

use Yii;
use yii\filters\AccessControl;

class Controller extends \yii\web\Controller
{
        public function behaviors()
        {
            return [
                'access' => [
                    'class' => AccessControl::class,
                    'except' => [
                        'users/login/login',
                        'users/registration/registration',
                    ],
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'], 
                        ],
                    ],
                ],
            ];
        }

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            // modul/controller alapján állítjuk a layoutot
            $route = Yii::$app->controller->module->id . '/' . Yii::$app->controller->id;

            if (in_array($route, ['users/registration', 'users/login'])) {
                $this->layout = '@app/themes/main/layouts/auth';
            } else {
                $this->layout = '@app/themes/main/layouts/main';
            }

            return true;
        }
        return false;
    }
}
