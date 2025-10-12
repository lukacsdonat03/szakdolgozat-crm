<?php

namespace app\modules\users\controllers;

use app\components\AppAlert;
use app\components\GlobalHelper;
use app\modules\users\models\Profile;
use app\modules\users\models\User;
use app\modules\users\models\search\UserSearch;
use app\modules\users\Usermodule;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => ['logout'],
                            'allow' => true,
                            'roles' => ['@']
                        ],
                        [
                            'actions' => ['index','create','update','delete'],
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => function($rule, $action){
                                return Usermodule::hasAdminRole();
                            }
                        ]
                    ]
                ]
            ],
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                        'logout' => ['POST']
                    ],
                ],
            ]
        );
    }

    public function beforeAction($action)
    {
        

        if (in_array($action->id, ['logout'])) {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actionLogout()
    {
        if (!Yii::$app->user->isGuest && Yii::$app->request->isPost) {
            Yii::$app->user->logout();
        }
        return $this->redirect(Usermodule::RETURN_LOGOUT_URL);
    }

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new User();
        $model->scenario = 'create';

        $profile = new Profile();

        $postData = Yii::$app->request->post();

        if ($this->request->isPost) {
            if ($model->load($postData) && $profile->load($postData)) {
                 if($model->save()) {
                    $profile->user_id=$model->id;
                    if($profile->save()) {
                        AppAlert::addSuccessAlert("Sikeres mentés");
                        return $this->redirect(['index']);
                    }else{
                        GlobalHelper::debug([$profile->errors]);
                    }
                }else{
                    GlobalHelper::debug([$model->errors]);    
                }
            }else{
                GlobalHelper::debug([$model,$profile]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'profile' => $profile,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id Azonosító
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $profile = $model->profile;

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            AppAlert::addSuccessAlert('Sikeres mentés');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'profile' => $profile,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id Azonosító
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id Azonosító
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
