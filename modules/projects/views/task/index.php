<?php

use app\modules\projects\models\Task;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\projects\models\search\TaskSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Feladatok';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <p>
        <?= Html::a('Létrehozás', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'project_id',
            'assigned_to',
            'title',
            'description:ntext',
            //'status',
            //'priority',
            //'due_date',
            //'estimated_hours',
            //'sort_order',
            //'created_by',
            //'created_at',
            //'updated_at',
            //'completed_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Task $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
