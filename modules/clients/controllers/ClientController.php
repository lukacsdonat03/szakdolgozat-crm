<?php

namespace app\modules\clients\controllers;

use app\modules\clients\models\Client;
use app\modules\clients\models\search\ClientSearch;
use app\base\Controller;
use app\components\AppAlert;
use app\modules\users\Usermodule;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;

/**
 * ClientController implements the CRUD actions for Client model.
 */
class ClientController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors(){
        $behaviors = parent::behaviors();
        if (isset($behaviors['access']['rules'])) {
            
            array_unshift($behaviors['access']['rules'], [
                'allow' => false,
                'matchCallback' => function ($rule, $action) {
                    return Usermodule::isAssociate();
                },
                'denyCallback' => function ($rule, $action) {
                    throw new \yii\web\ForbiddenHttpException('Ezzel a jogosultássgal nem érhető el ez a modul.');
                }
            ]);

            array_unshift($behaviors['access']['rules'], [
                'actions' => ['delete'],
                'allow' => false,
                'matchCallback' => function ($rule, $action) {
                    return !Usermodule::isDeleteEnabledForRight();
                },
            ]);
        }

        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'delete' => ['POST'],
            ],
        ];

        return $behaviors;
    }

    public function beforeAction($action){
        if ($action->id === 'delete') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    /**
     * Lists all Client models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ClientSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Client model.
     * @param int $id Azonosító
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Client model.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Client();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                AppAlert::addSuccessAlert('Sikeres mentés!');
                return $this->redirect(['index']);
            }else{
                AppAlert::addErrorAlert('Hiba történt mentés közben...');
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Client model.
     * @param int $id Azonosító
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Client model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id Azonosító
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();
        $model = $this->findModel($id);
        $model->is_deleted = Client::YES;
        if(!$model->save()){
            throw new BadRequestHttpException('Sikertelen törlés!');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Client model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id Azonosító
     * @return Client the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Client::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
