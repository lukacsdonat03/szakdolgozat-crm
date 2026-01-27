<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\projects\models\Tag $model */

$this->title = 'Módosítás: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Projekt tagek', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tag-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
