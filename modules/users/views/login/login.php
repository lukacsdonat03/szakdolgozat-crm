<?php

use app\modules\users\models\forms\LoginForm;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = "Bejelentkezés";

/**
 * @var LoginForm $model
 */

?>

<div class="login-view">
    <h1 class="text-white text-center main-h1">
        <?= $this->title ?>
    </h1>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => [
            'class' => 'auth-form w-100 mx-auto'
        ]
    ]) ?>
        
        <?= $form->field($model,'username')->textInput(['class'=>'auth-form-input','placeholder' => $model->getAttributeLabel('username')])->label(false) ?>

        <?= $form->field($model, 'password')->passwordInput(['class'=>'auth-form-input','placeholder' => $model->getAttributeLabel('password')])->label(false) ?>
        
        <?= Html::submitButton('Bejelentkezés',['class'=>'auth-btn anim d-flex align-items-center justify-content-center text-center']) ?>
    <?php
        ActiveForm::end();
    ?>
</div>

