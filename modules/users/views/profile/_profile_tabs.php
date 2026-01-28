<?php

use app\modules\users\models\forms\ChangePasswordForm;
use app\modules\users\models\User;
use app\modules\users\models\Profile;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\MaskedInput;

/**
 * @var User $user
 * @var Profile $profile
 * @var ChangePasswordForm $passwordForm
 */

?>

<ul class="nav nav-tabs nav-tabs-bordered">

    <li class="nav-item">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Profilom</button>
    </li>

    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Profil módosítás</button>
    </li>

    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Jelszó módosítás</button>
    </li>

</ul>
<div class="tab-content pt-2">

    <div class="tab-pane fade show active profile-overview" id="profile-overview">

        <h5 class="card-title">Profil adataok</h5>

        <?= DetailView::widget([
            'model' => $user,
            'template' => '<div class="row"><div class="col-lg-3 col-md-4 label">{label}</div><div class="col-lg-9 col-md-8">{value}</div></div>',
            'attributes' => [
                'email:email',
                'username',
                'registration_date',
                [
                    'label' => 'Név',
                    'value' => function ($model) {
                        return $model->profile ? $model->profile->name : '-';
                    },
                ],
                [
                    'label' => 'Telefonszám',
                    'value' => function ($model) {
                        return $model->profile ? $model->profile->phone : '-';
                    },
                ],
            ],
        ]) ?>

    </div>
    <div class="tab-pane fade profile-edit content pt-3" id="profile-edit">

        <?php $form = ActiveForm::begin([
            'id' => 'password-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-md-8 col-lg-9\">{input}\n{error}</div>",
                'labelOptions' => ['class' => 'col-md-4 col-lg-3 col-form-label'],
                'inputOptions' => ['class' => 'form-control'],
            ],
        ]); ?>

        <?= $form->field($user, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($user, 'username')->textInput(['maxlength' => true]) ?>

        <?= $form->field($profile, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($profile, 'phone')->widget(MaskedInput::class,[
            'mask' => '+36999999999',
            'options' => [
                'maxlength' => true,
            ]
        ]) ?>

        <div class="text-center text-lg-end">
            <?= Html::submitButton('Profil módosítása', ['class' => 'btn btn-crm', 'name' => 'password-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <div class="tab-pane fade profile-change-password pt-3" id="profile-change-password">
        <?php $form = ActiveForm::begin([
            'id' => 'password-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-md-8 col-lg-9\">{input}\n{error}</div>",
                'labelOptions' => ['class' => 'col-md-4 col-lg-3 col-form-label'],
                'inputOptions' => ['class' => 'form-control'],
            ],
        ]); ?>

        <?= $form->field($passwordForm, 'old_password')->passwordInput() ?>

        <?= $form->field($passwordForm, 'password')->passwordInput() ?>

        <?= $form->field($passwordForm, 'verify_password')->passwordInput() ?>

        <div class="text-center">
            <?= Html::submitButton('Jelszó módosítása', ['class' => 'btn btn-crm', 'name' => 'password-button']) ?>
        </div>
        <?php ActiveForm::end(); ?>

    </div>

</div>