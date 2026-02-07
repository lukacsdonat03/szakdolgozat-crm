<?php

use app\assets\LoadingOverlayAsset;
use app\assets\SweetAlertAsset;
use yii\widgets\DetailView;
use app\modules\projects\models\Task;
use app\modules\projects\models\TaskMessage;
use app\modules\projects\Projectmodule;
use app\modules\users\models\User;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\YiiAsset;

YiiAsset::register($this);
LoadingOverlayAsset::register($this);
SweetAlertAsset::register($this);

/**
 * @var Task $model
 * @var TaskMessage[] $messages
 */
?>

<div class="modal-header bg-light">
    <h5 class="modal-title">
        <i class="fas fa-tasks me-2"></i><?= \yii\helpers\Html::encode($model->title) ?>
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
    <div class="mb-3">
        <h6><strong>Leírás</strong></h6>
        <p class="text-muted border-start ps-3">
            <?= $model->description ?? '<i>Nincs leírás megadva.</i>' ?>
        </p>
    </div>
    <div class="row mt-5 row-gap-3">
        <div class="col-md-6">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-striped table-bordered detail-view'],
                'attributes' => [
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $color = Task::getStatusColors($model->status);
                            return "<span class='badge' style='background-color: {$color}'>"
                                . Task::getStatuses($model->status) . "</span>";
                        },
                    ],
                    [
                        'attribute' => 'project_id',
                        'value' => function ($model) {
                            return !empty($model->project) ? $model->project->name : 'Nincs beállítva';
                        },
                    ],
                    [
                        'attribute' => 'created_by',
                        'value' => function ($model) {
                            return !empty($model->createdbyname) ? $model->createdbyname : 'Nincs beállítva';
                        },
                    ],
                    [
                        'attribute' => 'priority',
                        'format' => 'html',
                        'value' => function ($model) {
                            return "<span class='badge bg-" . Projectmodule::getPriorityClass($model->priority) . " '>" .
                                Html::encode(Projectmodule::getPriorities($model->priority))
                                . "</span>";
                        },
                    ],
                    [
                        'attribute' => 'due_date',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return !empty($model->due_date)
                                ? Yii::$app->formatter->asDatetime($model->due_date, 'php:Y.m.d H:i')
                                : 'Nincs beállítva';
                        }
                    ],
                    [
                        'attribute' => 'estimated_hours',
                        'label' => 'Becsült idő',
                        'value' => $model->estimated_hours . ' óra',
                    ],

                ],
            ]) ?>
        </div>
        <div class="col-md-6">
            <?php $form = ActiveForm::begin([
                'id' => 'task-ajax-form',
                'action' => Url::to(['/projects/task/ajax-update']),
            ]) ?>
            <?= $form->field($model, 'assigned_to')->dropDownList(User::getNamesForSelect(), ['id' => 'ajax-asigned-dropdown'])->label("Feladat hozzárendelve") ?>
            <?= $form->field($model, 'status')->dropDownList(Task::getStatuses(), ['id' => 'ajax-status-dropdown']) ?>
            <span class="d-none">
                <?= $form->field($model, 'id')->hiddenInput(['value' => $model->id, 'id' => 'task-id']) ?>
            </span>
            <?php
            ActiveForm::end();
            ?>
        </div>
        <div class="col-lg-8 col-12 mx-auto my-4">

            <div id="messages-ajax-wrapper" class="mb-3">
                <?php 
                    echo Yii::$app->controller->renderPartial('@app/modules/projects/views/task/_messages', [
                        'messages' => $messages ?? []
                    ]); 
                ?>
            </div>

            <?php $form = ActiveForm::begin([
                'id' => 'message-ajax-form',
                'action' => Url::to(['/projects/task/send-message-ajax']),
                'enableClientValidation' => false,
                'enableAjaxValidation' => false,
            ]) ?>
            <div class="mb-3 form-group">
                <?= Html::label('Címzett', 'receiver-id-dropdown', ['class' => 'form-label']) ?>
                <?= Html::dropDownList('receiver_id', null, User::getNamesForSelect(false, true), ['id' => 'receiver-id-dropdown', 'class' => 'form-select mb-3']) ?>
            </div>
            <?= Html::textarea('new_message', '', ['id' => 'modal-message-content', 'class' => 'form-control', 'placeholder' => 'Üzenet írása...', 'rows' => 2]) ?>

            <div class="d-flex w-100 justify-content-end">
                <?= Html::submitButton('Küldés',['class' => 'btn btn-primary mt-3']) ?>
            </div>

            <?php
            ActiveForm::end();
            ?>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezárás</button>
</div>