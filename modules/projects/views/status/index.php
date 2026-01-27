<?php

use app\modules\projects\models\Status;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\projects\models\search\StatusSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Projekt státuszok';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="status-index">

    <p>
        <?= Html::a('Létrehozás', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'color_code',
                'format' => 'html',
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return '<span class="badge p-1 w-50 mx-auto" style="background-color:' . (!empty($model->color_code) ? $model->color_code : '#000') . '">&nbsp;</span>';
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<i class="fa-solid fa-eye"></i>', ['adminview', 'id' => $model->id]);
                    },
                ]
            ]
        ],
    ]); ?>


</div>