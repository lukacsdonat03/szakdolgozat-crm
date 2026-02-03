<?php

use yii\widgets\DetailView;
use app\modules\projects\models\Task;
use app\modules\projects\Projectmodule;
use yii\helpers\Html;

/**
 * @var Task $model
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
                'value' => function ($model){
                    return !empty($model->project) ? $model->project->name : 'Nincs beállítva';
                },
            ],
            [
                'attribute' => 'created_by',
                'value' => function ($model){
                    return !empty($model->createdbyname) ? $model->createdbyname : 'Nincs beállítva';
                },
            ],
            [
                'attribute' => 'priority',
                'format' => 'html',
                'value' => function ($model){
                    return "<span class='badge bg-".Projectmodule::getPriorityClass($model->priority)." '>".
                        Html::encode(Projectmodule::getPriorities($model->priority))
                    ."</span>";
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

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezárás</button>
</div>