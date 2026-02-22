<?php

use app\modules\users\Usermodule;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\users\models\Position $model */
/** @var yii\bootstrap5\ActiveForm $form */

$hint = Usermodule::getRightHint();
?>

<div class="position-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model,'rights')->dropDownList(Usermodule::getRights()) ?>

    <div class="row">
        <div class="col-md-8 col-12">
            <div class="hint-container mb-4 mt-4">
                <h2 class="text-muted mb-3 fs-4 fst-italic">
                    Jogosultságok:
                </h2>
                <div class="d-flex flex-column gap-1">
                    <?php foreach(Usermodule::getRights()  as $key => $name){ ?>
                        <div class="d-flex aling-items-center gap-2 text-muted">
                            <div class="right-name fw-bolder">
                                <?= $name.":" ?>
                            </div>
                            <div class="right-info">
                                <?= !empty($hint[$key]) ? $hint[$key] : 'Nincs beállítva' ?>
                            </div>
                        </div>    
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Mentés', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
