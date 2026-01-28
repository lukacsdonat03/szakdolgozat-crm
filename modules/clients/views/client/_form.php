<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

/** @var yii\web\View $this */
/** @var app\modules\clients\models\Client $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="client-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'company')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'phone')->widget(MaskedInput::class,[
                'mask' => '+36999999999',
                'options' => [
                    'maxlength' => true,
                ]
            ]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'tax_number')->widget(MaskedInput::class,[
                'mask' => '99999999-9-99',
                'clientOptions' => [
                    'clearIncomplete' => true
                ]
            ]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-12">
            <?= $form->field($model, 'notes')->textarea(['rows' => 3,'maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Módosít', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
