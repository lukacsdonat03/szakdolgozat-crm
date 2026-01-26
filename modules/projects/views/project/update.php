<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\projects\models\Project $model */

$this->title = 'Módosítás: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Projektek', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Módosítás';
?>
<div class="project-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
