<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\clients\models\Client $model */

$this->title = 'Módosítás: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ügyfelek', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="client-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
