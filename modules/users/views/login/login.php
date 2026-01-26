<?php

use app\modules\users\models\forms\LoginForm;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

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
        
        <div class="d-flex align-items-sm-center align-items-start gap-sm-3 gap-0 flex-column flex-sm-row">
            <?= Html::submitButton('Bejelentkezés',['class'=>'auth-btn anim d-flex align-items-center justify-content-center text-center']) ?>
        </div>
    <?php
        ActiveForm::end();
    ?>
</div>

