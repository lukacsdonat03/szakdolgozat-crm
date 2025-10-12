<?php

use app\modules\users\models\Position;
use app\modules\users\Usermodule;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\users\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($profile, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($profile, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'new_password')->widget(
        \kartik\password\PasswordInput::classname()
    ) ?>

    <?= $form->field($model, 'status')->dropDownList(Usermodule::status()) ?>
    
    <?= $form->field($profile, 'position_id')->dropDownList(Position::getToDropdwon(),['prompt' => '']) ?>
    
    <div class="form-group">
        <?= Html::submitButton('Mentés', ['class' => 'btn btn-crm anim']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
