<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\users\models\User $model */

$this->title = $profile->name . " módosítása";
$this->params['breadcrumbs'][] = ['label' => 'Felhasználók', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Módosítás';
?>
<div class="user-update">

    <?= $this->render('_form', [
        'model' => $model,
        'profile' => $profile,
    ]) ?>

</div>
