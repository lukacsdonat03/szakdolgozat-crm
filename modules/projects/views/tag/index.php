<?php

use app\modules\projects\models\Tag;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\projects\models\search\TagSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Projekt címkék';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-index">

    <p>
        <?= Html::a('Létrehoz', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
                    return '<span class="badge p-1 w-100     mx-auto" style="background-color:' . (!empty($model->color_code) ? $model->color_code : '#000') . '">&nbsp;</span>';
                },
                'filter' => false,
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
