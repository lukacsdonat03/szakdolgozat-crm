<?php

use app\modules\users\models\forms\RegistrationForm;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/**
 * @var RegistrationForm $model
 */

$this->title = 'Regisztráció';

?>
<div class="registration-view">
    <h1 class="text-white text-center main-h1">
        <?= $this->title ?>
    </h1>

    <?php $form = ActiveForm::begin([
        'id' => 'registration-form',
        'options' => [
            'class' => 'auth-form w-100 mx-auto'
        ]
    ]) ?>

        <?= $form->field($model,'name')->textInput(['class'=>'auth-form-input','placeholder' => $model->getAttributeLabel('name')])->label(false) ?>
        
        <?= $form->field($model,'username')->textInput(['class'=>'auth-form-input','placeholder' => $model->getAttributeLabel('username')])->label(false) ?>
        
        <?= $form->field($model,'email')->textInput(['class'=>'auth-form-input','placeholder' => $model->getAttributeLabel('email')])->label(false) ?>

        <?= $form->field($model, 'password')->passwordInput(['class'=>'auth-form-input','placeholder' => $model->getAttributeLabel('password')])->label(false) ?>

        <?= $form->field($model, 'verifyPassword')->passwordInput(['class'=>'auth-form-input','placeholder' => $model->getAttributeLabel('verifyPassword')])->label(false) ?>

        <?= Html::submitButton('Regisztráció',['class'=>'auth-btn anim d-flex align-items-center justify-content-center text-center']) ?>
    <?php
        ActiveForm::end();
    ?>
</div>
