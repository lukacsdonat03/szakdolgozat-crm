<?php

namespace app\modules\projects\controllers;

use app\modules\projects\models\Task;
use app\modules\projects\models\search\TaskSearch;
use app\base\Controller;
use app\components\AppAlert;
use app\components\GlobalHelper;
use app\modules\projects\models\Schedule;
use app\modules\projects\models\TaskMessage;
use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Response;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
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

    public function actionSendMessageAjax(){
        
        if(!$this->request->isAjax){
            throw new BadRequestHttpException('Nem AJAX kérés!');
        }
    
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $request = Yii::$app->request;

        $taskId = $request->post('task_id');
        $content = $request->post('content');
        $receiverId = $request->post('receiver_id');

        if (empty($content)) {
            return ['success' => false, 'msg' => 'Az üzenet nem lehet üres!'];
        }

        $msg = new TaskMessage();
        $msg->task_id = $taskId;
        $msg->content = $content;
        $msg->receiver_id = $receiverId;
        $msg->sender_id = Yii::$app->user->id;
        $msg->created_at = date('Y-m-d H:i:s');

        if ($msg->save()) {
            $messages = TaskMessage::find()
                ->where(['task_id' => $taskId, 'is_deleted' => TaskMessage::NO])
                ->orderBy(['created_at' => SORT_ASC])
                ->all();

            return [
                'success' => true,
                'msg' => 'Üzenet elküldve!',
                'html' => $this->renderPartial('_messages', ['messages' => $messages])
            ];
        }

        return ['success' => false, 'msg' => 'Hiba történt a mentés során.'];
    }

    public function actionAjaxUpdate(){
        
        if(!$this->request->isAjax){
            throw new BadRequestHttpException('Nem AJAX kérés');
        }

        $this->response->format = Response::FORMAT_JSON;

        $postData = $this->request->post();
        
        $status = $postData['status'] ?? null;
        $asignedTo = $postData['asigned'] ?? null;
        $modelId = $postData['id'] ?? 0;
        $model = $this->findModel($modelId);
        if(!empty($model)){
            $change = [];
            if(isset($status)){
                $change['status'] = $status;
            }
            if(isset($asignedTo)){
                $change['assigned_to'] = $asignedTo;
            }
            if(!empty($change)){
                Task::updateAll($change,['id' => $modelId]);
            }

            return [
                'success' => true,
                'msg' => 'Sikeres mentés',
            ];
        }
        return [
            'success' => false,
            'msg' => 'Nem található ilyen erőforrás a rendszerben!',
        ];
    }

    public function actionViewAjax($id){
        $model = $this->findModel($id);
        $messages = $model->messages;

        $this->response = Response::FORMAT_JSON;

        return $this->renderPartial('@app/modules/projects/views/task/_view_modal',[
            'model' => $model,
            'messages' => $messages
        ]);
    }

    public function actionCalendarData($start = null, $end = null){
        $this->response->format = Response::FORMAT_JSON;

        $schedules = Schedule::getSchedulesByDates($start,$end);
        $events = [];

        if (!empty($schedules)) {
          foreach ($schedules as $schedule) {
                foreach ($schedule->getArrayForCalendar() as $event) {
                    $events[] = $event;
                }
            }
        }

        return $events;
    }

    public function actionCalendar(){
        return $this->render('calendar');
    }

    /**
     * Lists all Task models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Task model.
     * @param int $id Azonosító
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $project = $model->project;
        $client = !empty($project) ? $project->client : null;
        return $this->render('view', [
            'model' => $model,
            'project' => $project,
            'client' => $client
        ]);
    }

    /**
     * Creates a new Task model.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Task();
        $schedule = new Schedule();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                if($schedule->load($this->request->post())){
                    $schedule->task_id = $model->id;
                    if($schedule->save()){
                        AppAlert::addSuccessAlert('Sikeres mentés!');
                        return $this->redirect(['index']);
                    }
                }
            }else{
                AppAlert::addErrorAlert('Hiba történt mentés közben...');
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'schedule' => $schedule,
        ]);
    }

    /**
     * Updates an existing Task model.
     * @param int $id Azonosító
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $schedule = $model->schedule;
        if(empty($schedule)){
            $schedule = new Schedule();
            $schedule->task_id = $model->id;
        }

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save() && $schedule->load($this->request->post()) && $schedule->save()) {
            AppAlert::addSuccessAlert('Sikeres mentés');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'schedule' => $schedule,
        ]);
    }

    /**
     * Deletes an existing Task model.
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
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id Azonosító
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
