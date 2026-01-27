<?php

use app\modules\clients\models\Client;
use app\modules\projects\models\Status;
use app\modules\projects\models\Tag;
use app\modules\projects\Projectmodule;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/** @var yii\web\View $this */
/** @var app\modules\projects\models\Project $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6"><?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?></div>

        <div class="col-sm-6"><?= $form->field($model, 'client_id')->widget(Select2::class,[
            'data' => Client::getListForSelect(),
            'pluginOptions' => [
                'multiple' => false,
            ]
        ]) ?></div>

        <div class="col-sm-6"><?= $form->field($model, 'status_id')->dropDownList(Status::getListForSelect(false, 'id', 'name', 'id')) ?></div>

        <div class="col-sm-6">
            <?= $form->field($model, 'taglist')->widget(Select2::class, [
                'data' => Tag::getListForSelect(),
                'pluginOptions' => [
                    'multiple' => true,
                ]
            ]) ?>
        </div>

        <div class="col-sm-6">
            <?= $form->field($model, 'priority')->dropDownList(Projectmodule::getPriorities()) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'budget')->textInput() ?>
        </div>

        <div class="col-sm-6">
            <?= $form->field($model, 'start_date')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Kezdés ...'],
                'pluginOptions' => [
                    'autoclose' => true,
                ],
                'removeIcon' => '<i class="bi bi-x-lg"></i>',
                'pickerIcon' => '<i class="bi bi-calendar3"></i>',
            ]); ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'deadline')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Határidő ...'],
                'pluginOptions' => [
                    'autoclose' => true,
                ],
                'removeIcon' => '<i class="bi bi-x-lg"></i>',
                'pickerIcon' => '<i class="bi bi-calendar3"></i>',
            ]); ?>
        </div>
    </div>

    <?= $form->field($model, 'description')->widget(
        alexantr\ckeditor\CKEditor::className(),
        [
            'clientOptions' => [
                'linkShowAdvancedTab' => true,
                'extraPlugins' => ['font', 'justify', 'dialogadvtab'],
                'removeDialogTabs' => '',
            ],
        ]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Mentés', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>