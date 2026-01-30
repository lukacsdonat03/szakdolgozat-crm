<?php

use app\components\GlobalHelper;
use yii\helpers\Html;
use app\modules\projects\models\Task;
use app\modules\projects\Projectmodule;

/** @var yii\web\View $this */
/** @var app\modules\projects\models\Task $model */
/** @var app\modules\projects\models\Project $project */
/** @var app\modules\clients\models\Client $client */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Feladatok', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="task-view">
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-sm-3 gap-1 flex-column flex-sm-row task-avatar-wrapper">
                    <div class="task-avatar">
                        <i class="bi bi-check2-square"></i>
                    </div>
                    <div>
                        <h2 class="mb-1 fw-bold"><?= Html::encode($model->title) ?></h2>
                        <?php if (!empty($project)): 
                                $postFix = (!empty($client) && !empty($client->company)) ? ' (' . $client->company . ')' : '';    
                        ?>
                            <p class="text-muted mb-0">
                                <i class="bi bi-briefcase me-1"></i>
                                <?= Html::a(
                                    Html::encode($project->name . $postFix),
                                    ['/projects/project/view', 'id' => $project->id],
                                    ['class' => 'anim']
                                ) ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="d-flex gap-2 flex-column flex-sm-row">
                    <?= Html::a(
                        '<i class="bi bi-pencil me-1"></i> Szerkesztés',
                        ['update', 'id' => $model->id],
                        ['class' => 'btn btn-outline-primary anim']
                    ) ?>
                    <?= Html::a(
                        '<i class="bi bi-trash me-1"></i> Törlés',
                        ['delete', 'id' => $model->id],
                        [
                            'class' => 'btn btn-outline-danger anim',
                            'data' => [
                                'confirm' => 'Biztosan törölni szeretnéd ezt a feladatot?',
                                'method' => 'post',
                            ],
                        ]
                    ) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0 d-flex align-items-center">
                        <i class="bi bi-info-circle me-2 text-primary"></i>
                        Feladat adatok
                    </h5>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <label><i class="bi bi-tag"></i> Státusz</label>
                        <div class="value">
                            <?php if (isset($model->status)): ?>
                                <span class="badge" style="background-color: <?= Html::encode(Task::getStatusColors($model->status)) ?>">
                                    <?= Html::encode(Task::getStatuses($model->status)) ?>
                                </span>
                            <?php else: ?>
                                <span class="text-muted">Nincs beállítva</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="info-item">
                        <label><i class="bi bi-exclamation-triangle"></i> Prioritás</label>
                        <div class="value">
                            <?php if (isset($model->priority)): ?>
                                 <span class="badge bg-<?= Projectmodule::getPriorityClass($model->priority) ?>">
                                    <?= Html::encode(Projectmodule::getPriorities($model->priority)) ?>
                                </span>
                            <?php else: ?>
                                <span class="text-muted">Nincs megadva</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="info-item">
                        <label><i class="bi bi-person-check"></i> Felelős</label>
                        <div class="value">
                            <?php if (!empty($model->assignedto)): ?>
                                <?= Html::encode($model->assignedto->profile->name ?? 'Ismeretlen') ?>
                            <?php else: ?>
                                <span class="text-muted">Nincs hozzárendelve</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="info-item mb-0">
                        <label><i class="bi bi-person-badge"></i> Létrehozta</label>
                        <div class="value">
                            <?php if (!empty($model->created_by)): ?>
                                <?= Html::encode($model->createdbyname ?? 'Ismeretlen') ?>
                            <?php else: ?>
                                <span class="text-muted">Nincs megadva</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0 d-flex align-items-center">
                        <i class="bi bi-clock-history me-2 text-primary"></i>
                        Időzítés
                    </h5>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <label><i class="bi bi-calendar-x"></i> Határidő</label>
                        <div class="value">
                            <?php if (!empty($model->due_date)): ?>
                                <?php
                                $deadline = new DateTime($model->due_date);
                                $now = new DateTime();
                                $isOverdue = $deadline < $now && $model->status != Task::STATUS_COMPLETED;
                                ?>
                                <span class="<?= $isOverdue ? 'text-danger fw-bold' : '' ?>">
                                    <?= Yii::$app->formatter->asDatetime($model->due_date, 'php:Y.m.d H:i') ?>
                                    <?php if ($isOverdue): ?>
                                        <i class="bi bi-exclamation-circle ms-1"></i>
                                    <?php endif; ?>
                                </span>
                            <?php else: ?>
                                <span class="text-muted">Nincs megadva</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="info-item">
                        <label><i class="bi bi-hourglass-split"></i> Becsült idő</label>
                        <div class="value">
                            <?php if (!empty($model->estimated_hours)): ?>
                                <strong><?= Html::encode($model->estimated_hours) ?> óra</strong>
                            <?php else: ?>
                                <span class="text-muted">Nincs megadva</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="info-item">
                        <label><i class="bi bi-check-circle"></i> Befejezve</label>
                        <div class="value">
                            <?php if (!empty($model->completed_at)): ?>
                                <span class="text-success fw-bold">
                                    <i class="bi bi-check2 me-1"></i>
                                    <?= Yii::$app->formatter->asDatetime($model->completed_at, 'php:Y.m.d H:i') ?>
                                </span>
                            <?php else: ?>
                                <span class="text-muted">Még nem fejeződött be</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($model->description)): ?>
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0 d-flex align-items-center">
                    <i class="bi bi-file-text me-2 text-primary"></i>
                    Leírás
                </h5>
            </div>
            <div class="card-body">
                <div class="task-description-content">
                    <?= $model->description ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>