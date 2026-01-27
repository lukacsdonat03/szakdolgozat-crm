<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\projects\models\Tag $model */

$this->title = 'Létrehoz';
$this->params['breadcrumbs'][] = ['label' => 'Projekt tagek', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
