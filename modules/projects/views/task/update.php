<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\projects\models\Task $model */
/** @var app\modules\projects\models\Schedule $schedule */

$this->title = 'Módosítás: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Feladatok', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Módosítás';
?>
<div class="task-update">

    <?= $this->render('_form', [
        'model' => $model,
        'schedule' => $schedule,
    ]) ?>

</div>
