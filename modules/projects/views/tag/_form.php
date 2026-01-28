<?php

use kartik\color\ColorInput;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\projects\models\Tag $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="tag-form">

    <?php $form = ActiveForm::begin(); ?>

     <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'color_code')->widget(ColorInput::class,[
                'options' => ['placeholder' => 'Válassz színt...']
            ])->hint('Ha nincs megadva, akkor fekete az alapértelmezett szín') ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Módosít', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
