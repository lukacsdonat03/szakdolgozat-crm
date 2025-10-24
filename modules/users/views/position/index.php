<?php

use app\components\GlobalHelper;
use app\modules\users\models\Position;
use app\modules\users\Usermodule;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\users\models\search\PositionSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Munkakörök';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="position-index">
    <p>
        <?= Html::a('Létrehozás', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'rights',
                'value' => function($model){
                    return GlobalHelper::getValueFromArray(Usermodule::getRights(),$model->rights);
                },
                'filter' => Html::activeDropDownList($searchModel,'rights',Usermodule::getRights(),['class' => 'form-select','prompt' => ''])
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{update} {delete}'
            ],
        ],
    ]); ?>


</div>
