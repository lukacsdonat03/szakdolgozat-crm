<?php

namespace app\modules\messages\controllers;

use app\modules\messages\models\Message;
use app\modules\messages\models\search\MessageSearch;
use app\base\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MessageController implements the CRUD actions for Message model.
 */
class MessageController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function beforeAction($action){
        if ($action->id === 'delete-wall-message') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionDeleteWallMessage()    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');

        $model = Message::findOne($id);

        if (!$model) {
            return ['success' => false, 'msg' => 'Az üzenet nem található.'];
        }

        if ($model->sender_id !== Yii::$app->user->id) {
            return ['success' => false, 'msg' => 'Nincs jogosultságod törölni ezt az üzenetet!'];
        }

        $model->is_deleted = Message::YES;
        
        if ($model->save(false)) {
            return [
                'success' => true,
                'msg' => 'Üzenet törölve.'
            ];
        }

        return ['success' => false, 'msg' => 'Nem sikerült elmenteni a változtatásokat.'];
    }

    public function actionMessages(){
        $searchModel = new MessageSearch(['is_deleted' => Message::NO]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $newMessage = new Message();
        return $this->render('messages',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'newMessage' => $newMessage,
        ]);
    }

    public function actionSendWallMessage()
{
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $model = new Message();

    if ($model->load(Yii::$app->request->post())) {
        $model->sender_id = Yii::$app->user->id;
      
        if ($model->save()) {
            return [
                'success' => true,
                'msg' => 'Üzenet elküldve!'
            ];
        }
    }

    return [
        'success' => false, 
        'msg' => 'Hiba történt a mentés során.',
        'errors' => $model->getErrors()
    ];
}

    /**
     * Finds the Message model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id Azonosító
     * @return Message the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Message::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
