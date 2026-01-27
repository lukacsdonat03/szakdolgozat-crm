<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\clients\models\Client $model */

$this->title = 'Létrehozás';
$this->params['breadcrumbs'][] = ['label' => 'Ügyfelek', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-create">
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
