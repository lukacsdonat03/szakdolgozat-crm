<?php

use app\modules\projects\models\Project;
use app\modules\projects\models\Task;
use app\modules\projects\Projectmodule;
use app\modules\users\models\User;
use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\projects\models\Task $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'project_id')->widget(Select2::class,[
                'data' => Project::getListForSelect(),
                'options' => ['placeholder' => 'Válassz projektet...'],
                'pluginOptions' => [
                    'multiple' => false,
                ],
            ]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'assigned_to')->widget(Select2::class,[
                'data' => User::getNamesForSelect(),
                'options' => ['placeholder' => 'Feladat hozzárendelve...'],
                'pluginOptions' => [
                    'multiple' => false,
                ],
            ]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'estimated_hours')->textInput() ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'status')->widget(Select2::class, [
                'data' => Task::getStatuses(),
                'options' => ['placeholder' => 'Válassz státuszt...'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'templateResult' => new \yii\web\JsExpression('function(state) {
                        if (!state.id) return state.text;
                        
                        var colors = ' . json_encode(Task::getStatusColors()) . ';
                        var color = colors[state.id] || "#6c757d";
                        
                        var $state = $(
                            "<div style=\"border-left: 4px solid " + color + "; padding-left: 10px;\">" +
                                state.text +
                            "</div>"
                        );
                        return $state;
                    }'),
                    'templateSelection' => new \yii\web\JsExpression('function(state) {
                        if (!state.id) return state.text;
                        
                        var colors = ' . json_encode(Task::getStatusColors()) . ';
                        var color = colors[state.id] || "#6c757d";
                        
                        var $state = $(
                            "<div style=\"border-left: 4px solid " + color + "; padding-left: 10px;\">" +
                                state.text +
                            "</div>"
                        );
                        return $state;
                    }')
                ],
            ]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'priority')->dropDownList(Projectmodule::getPriorities()) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'due_date')->widget(DateTimePicker::class,[
                'options' => ['placeholder' => 'Határidő...'],
                'pluginOptions' => [
                    'autoclose' => true,
                ],
                'removeIcon' => '<i class="bi bi-x-lg"></i>',
                'pickerIcon' => '<i class="bi bi-calendar3"></i>',
            ]) ?>
        </div>
        <div class="col-12">
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
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Módosítás', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
