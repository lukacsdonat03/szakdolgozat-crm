<?php

namespace app\modules\projects\controllers;

use app\modules\projects\models\Status;
use app\modules\projects\models\search\StatusSearch;
use yii\filters\AccessControl;
use app\base\Controller;
use app\components\AppAlert;
use app\modules\users\Usermodule;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StatusController implements the CRUD actions for Status model.
 */
class StatusController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
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
        }

        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'delete' => ['POST'],
            ],
        ];

        return $behaviors;
    }

    /**
     * Lists all Status models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new StatusSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Creates a new Status model.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Status();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                AppAlert::addSuccessAlert('Sikeres mentés!');
                return $this->redirect(['index']);
            }else{
                AppAlert::addErrorAlert('Hiba történt mentés közben!');
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Status model.
     * @param int $id Azonosító
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            AppAlert::addSuccessAlert('Sikeres mentés!');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Status model.
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
     * Finds the Status model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id Azonosító
     * @return Status the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Status::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
