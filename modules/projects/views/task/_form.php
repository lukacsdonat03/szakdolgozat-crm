<?php

use app\components\GlobalHelper;
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
/** @var app\modules\projects\models\Schedule $schedule*/
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>

    <ul class="nav nav-tabs nav-tabs-bordered">

        <li class="nav-item">
            <button class="nav-link active" type="button" data-bs-toggle="tab" data-bs-target="#data">Adatok</button>
        </li>

        <li class="nav-item">
            <button class="nav-link" type="button" data-bs-toggle="tab" data-bs-target="#tasks">Ütemezés</button>
        </li>

    </ul>
    <div class="tab-content no-decoration pt-2">
        <div class="tab-pane fade show active" id="data">
            <div class="row">
                <div class="col-sm-12">
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'project_id')->widget(Select2::class, [
                        'data' => Project::getListForSelect(),
                        'options' => ['placeholder' => 'Válassz projektet...'],
                        'pluginOptions' => [
                            'multiple' => false,
                        ],
                    ]) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'assigned_to')->widget(Select2::class, [
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
                    <?= $form->field($model, 'due_date')->widget(DateTimePicker::class, [
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
        </div>
        <div class="tab-pane fade content pt-3" id="tasks">
            <span class="d-none">
                <?= $form->field($schedule,'task_id')->hiddenInput(['value' => (!$model->isNewRecord) ? $model->id : null]) ?>
            </span>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($schedule,'start_date')->widget(DatePicker::class,[
                        'options' => ['placeholder' => 'Kezdés ...'],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'todayHighlight' => true,
                            'startDate' => 'today',
                        ],
                        'removeIcon' => '<i class="bi bi-x-lg"></i>',
                        'pickerIcon' => '<i class="bi bi-calendar3"></i>',
                    ]) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($schedule,'day_spread')->textInput()->hint('Opcionális mező, ha ki van töltve, a megadott napra lesz elosztva a feladat') ?>
                </div>
            </div>
        </div>
    </div>


    <div class="form-group mt-3">
        <?= Html::submitButton('Módosítás', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
