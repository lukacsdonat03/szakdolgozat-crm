<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\users\models\Position $model */

$this->title = 'Munkakör módosítása: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Munkakörök', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Módosítás';
?>
<div class="position-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
