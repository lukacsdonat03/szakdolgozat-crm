<?php

use app\modules\users\models\Profile;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\users\models\User $model */

$this->title = 'Felhasználó létrehozása';
$this->params['breadcrumbs'][] = ['label' => 'Felhasználók', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <?= $this->render('_form', [
        'model' => $model,
        'profile' => $profile,
    ]) ?>

</div>
