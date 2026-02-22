<?php


/** @var yii\web\View $this */

use app\modules\projects\models\Project;
use app\modules\projects\models\Task;
use app\modules\projects\Projectmodule;
use app\modules\users\models\User;
use app\modules\users\Usermodule;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var app\modules\projects\models\search\TaskSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\modules\projects\models\Project $project */


$this->title = $project->name . ' - feladatok';

$this->params['breadcrumbs'][] = ['label' => 'Projektek', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="project-tasks">
    <p>
        <?= Html::a('Létrehozás', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
    
            [
                'attribute' => 'assigned_to',
                'format' => 'raw',
                'value' => function ($model){
                    return !empty($model->assignedto) ? User::getNamesForSelect($model->assigned_to) : 'Nincs beállítva';
                },
                'filter' => Html::activeDropDownList($searchModel,'assigned_to',User::getNamesForSelect(),['class'=>'form-select','prompt' => '']),
                'visible' => !Usermodule::isAssociate(),
            ],
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($model){
                    return isset($model->status) 
                    ? ('<span class="badge" style="background-color:'.Task::getStatusColors($model->status).'">'.Task::getStatuses($model->status).'</span>' )
                    : 'Nincs beállítva';
                },
                'filter' => Html::activeDropDownList($searchModel,'status',Task::getStatuses(),['class'=>'form-select','prompt' => '']),
            ],
            [
                'attribute' => 'priority',
                'format' => 'raw',
                'value' => function ($model){
                    return isset($model->priority) ? Projectmodule::getPriorities($model->priority) : 'Nincs beállítva';
                },
                'filter' => Html::activeDropDownList($searchModel,'priority',Projectmodule::getPriorities(),['class'=>'form-select','prompt' => '']),
            ],
            [
                'attribute' => 'due_date',
                'format' => 'raw',
                'value' => function ($model) {
                     return !empty($model->due_date) 
                        ? Yii::$app->formatter->asDatetime($model->due_date, 'php:Y.m.d H:i') 
                        : 'Nincs beállítva';
                }
            ],
            [
                'attribute' => 'estimated_hours',
                'format' => 'html',
                'value' => function ($model) {
                    return (!empty($model->estimated_hours) ? $model->estimated_hours . '<small class="mx-1">óra</small>' : 'Nincs bállítva');
                }
            ],
            'completed_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Task $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>
</div>