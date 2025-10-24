<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\users\models\Position $model */

$this->title = 'Munkakör létrehozása';
$this->params['breadcrumbs'][] = ['label' => 'Munkakörök', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="position-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
