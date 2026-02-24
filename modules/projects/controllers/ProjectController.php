<?php

namespace app\modules\projects\controllers;

use app\modules\projects\models\Project;
use app\modules\projects\models\search\ProjectSearch;
use yii\filters\AccessControl;
use app\base\Controller;
use app\components\AppAlert;
use app\modules\projects\models\search\TaskSearch;
use app\modules\projects\Projectmodule;
use app\modules\users\Usermodule;
use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;

/**
 * ProjectController implements the CRUD actions for Project model.
 */
class ProjectController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors(){
        $behaviors = parent::behaviors();
        if (isset($behaviors['access']['rules'])) {
            
            array_unshift($behaviors['access']['rules'], [
                'actions' => ['update','dashboard'],
                'allow' => false,
                'matchCallback' => function ($rule, $action) {
                    return Usermodule::isAssociate();
                },
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

    public function actionDashboard(){
        
        $db = Yii::$app->db;

        $statusData = $db->createCommand('
            SELECT s.name, COUNT(p.id) as count 
            FROM project_projects p 
            JOIN project_statuses s ON p.status_id = s.id 
            WHERE p.is_deleted = 0 
            GROUP BY s.id
        ')->queryAll();

        $budgetData = $db->createCommand('
            SELECT name, budget 
            FROM project_projects 
            WHERE is_deleted = 0 AND budget > 0 
            ORDER BY budget DESC 
            LIMIT 5
        ')->queryAll();

        $workerData = $db->createCommand('
            SELECT up.name, COUNT(pt.id) as task_count 
            FROM user_profiles up
            LEFT JOIN project_tasks pt ON up.user_id = pt.assigned_to
            WHERE pt.is_deleted = 0 AND pt.status != 3 -- feltételezve, hogy a 3-as a lezárt
            GROUP BY up.user_id
        ')->queryAll();

        $priorityRaw = $db->createCommand('
            SELECT priority, COUNT(id) as count 
            FROM project_projects 
            WHERE is_deleted = 0 
            GROUP BY priority
        ')->queryAll();

        $priorityLabels = [];
        $priorityCounts = [];
        $allPriorities = Projectmodule::getPriorities();

        foreach ($priorityRaw as $row) {
            $priorityLabels[] = $allPriorities[$row['priority']] ?? 'Ismeretlen';
            $priorityCounts[] = (int)$row['count'];
        }

        return $this->render("dashboard",[
            'statusLabels' => array_column($statusData, 'name'),
            'statusCounts' => array_map('intval', array_column($statusData, 'count')),
            'budgetLabels' => array_column($budgetData, 'name'),
            'budgetValues' => array_map('floatval', array_column($budgetData, 'budget')),
            'workerLabels' => array_column($workerData, 'name'),
            'workerCounts' => array_map('intval', array_column($workerData, 'task_count')),
            'priorityLabels' => $priorityLabels,
            'priorityCounts' => $priorityCounts,
        ]);
    }

    public function actionTasks($id){
        $model = $this->findModel($id);
        $filter = ['project_id' => $model->id];
        
        if(Usermodule::isAssociate()){
            $filter['assigned_to'] =  Yii::$app->user->id;
        }

        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search($this->request->queryParams,$filter);
        
        return $this->render('tasks',[
            'project' => $model,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Lists all Project models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProjectSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Project model.
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
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Project();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                AppAlert::addSuccessAlert('Sikeres mentés!');
                return $this->redirect(['update', 'id' => $model->id]);
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
     * Updates an existing Project model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id Azonosító
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            AppAlert::addSuccessAlert('Sikeres mentés!');
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Project model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id Azonosító
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();
        $model = $this->findModel($id);
        $model->is_deleted = Project::YES;
        if(!$model->save()){
            throw new BadRequestHttpException('Sikertelen törlés!');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id Azonosító
     * @return Project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Project::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
