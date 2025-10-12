<?php

use app\components\GlobalHelper;
use app\modules\users\models\User;
use app\modules\users\Usermodule;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\users\models\search\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Felhasználók kezelése';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <p>
        <?= Html::a('Létrehozása', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
        $gridColumns =  [
        ['class' => 'yii\grid\SerialColumn'],
        'username',
        'email:email',
        'registration_date',
        [
            'attribute' => 'status',
            'value' => function ($model) {
                return GlobalHelper::getValueFromArray(Usermodule::status(),$model->status);
            },
            'filter' => Html::activeDropDownList($searchModel,'status',Usermodule::status(),['class' => 'form-select','prompt' => ''])
        ],
        [
            'class' => ActionColumn::className(),
            'template' => '{update} {delete}'
        ],
    ];

    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
    ]); ?>


</div>
