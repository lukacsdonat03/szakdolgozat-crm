<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\projects\models\Tag $model */

$this->title = 'Módosítás: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Projekt címkék', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Módosítás';
?>
<div class="tag-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
