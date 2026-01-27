<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\projects\models\Task $model */

$this->title = 'Létrehozás';
$this->params['breadcrumbs'][] = ['label' => 'Feladatok', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
