<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\widgets\MaskedInput;

/** @var yii\web\View $this */
/** @var app\modules\users\models\Profile $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="profile-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

     <?= $form->field($model, 'phone')->widget(MaskedInput::class,[
        'mask' => '+36999999999',
        'options' => [
            'maxlength' => true,
        ]
    ]) ?>

    <?= $form->field($model, 'position_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
