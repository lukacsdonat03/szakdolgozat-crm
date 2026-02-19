<?php

use app\modules\clients\models\Client;
use app\modules\projects\models\Project;
use app\modules\projects\models\Status;
use app\modules\projects\Projectmodule;
use app\modules\users\Usermodule;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\projects\models\search\ProjectSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Projektek';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <p>
        <?= Html::a('Projekt létrehozása', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'client_id',
                'format' => 'raw',
                'value' => function ($model){
                    return !empty($model->client) ? $model->client->name .(!empty($model->client->company) ? ('('.$model->client->company.')') : '') : 'Nincs beállítva';
                },
                'filter' => Html::activeDropDownList($searchModel,'client',Client::getClientsForSelect(),['class'=>'form-select','prompt' => '']),
            ],
            [
                'attribute' => 'status_id',
                'format' => 'raw',
                'value' => function ($model){
                    return !empty($model->status) ? $model->status->name : 'Nincs beállítva';
                },
                'filter' => Html::activeDropDownList($searchModel,'status_id',Status::getListForSelect(false,'id','name','id'),['class'=>'form-select','prompt' => '']),
            ],
            [
                'attribute' => 'priority',
                'format' => 'raw',
                'value' => function ($model){
                    return isset($model->priority) ? Projectmodule::getPriorities($model->priority) : 'Nincs beállítva';
                },
                'filter' => Html::activeDropDownList($searchModel,'priority',Projectmodule::getPriorities(),['class'=>'form-select','prompt' => '']),
            ],
            'start_date',
            'deadline',
            [
                'attribute' => 'created_by',
                'format' => 'raw',
                'value' => function ($model){
                    return !empty($model->createdbyuser) ? $model->createdbyuser->profile->name : 'Nincs beállítva';
                },
                'filter' => Html::activeDropDownList($searchModel,'created_by',Usermodule::getNamesForSelect(),['class'=>'form-select','prompt' => '']),
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {update} {delete} {tasks}',
                'buttons' => [
                    'tasks' => function($url, $model, $key){
                        return Html::a('<i class="bi bi-card-checklist"></i>', $url, [
                        'title' => 'Feladatok',
                        'data-pjax' => '0',
                        'class' => 'anim'
                    ]);
                    }
                ],
                'urlCreator' => function ($action, Project $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
