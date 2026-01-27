<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\projects\models\Status $model */

$this->title = 'Létrehozás';
$this->params['breadcrumbs'][] = ['label' => 'Projekt státuszok', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="status-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
