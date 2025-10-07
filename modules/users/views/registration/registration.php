<?php

use app\modules\users\models\forms\RegistrationForm;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

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
        
        <div class="d-flex align-items-sm-center align-items-start gap-sm-3 gap-0 flex-column flex-sm-row">
            <?= Html::submitButton('Regisztráció',['class'=>'auth-btn anim d-flex align-items-center justify-content-center text-center']) ?>
            <?= Html::a('Bejelentkezés',Url::to(['/users/login/login']),['class' => 'auth-btn btn-dark anim d-flex align-items-center justify-content-center text-center']) ?>
        </div>

    <?php
        ActiveForm::end();
    ?>
</div>
