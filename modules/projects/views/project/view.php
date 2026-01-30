<?php

use app\components\GlobalHelper;
use app\modules\projects\models\Project;
use app\modules\projects\Projectmodule;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\projects\models\Project $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Projektek', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="project-view">
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-sm-3 gap-1 flex-column flex-sm-row project-avatar-wrapper">
                    <div class="project-avatar">
                        <i class="bi bi-briefcase"></i>
                    </div>
                    <div>
                        <h2 class="mb-1 fw-bold"><?= Html::encode($model->name) ?></h2>
                        <?php if (!empty($model->client)): ?>
                            <p class="text-muted mb-0">
                                <i class="bi bi-building me-1"></i>
                                <?= Html::a(
                                    Html::encode($model->client->name),
                                    ['/clients/client/view', 'id' => $model->client_id],
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
                                'confirm' => 'Biztosan törölni szeretnéd ezt a projektet?',
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
                        Projekt adatok
                    </h5>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <label><i class="bi bi-tag"></i> Státusz</label>
                        <div class="value">
                            <?php if (!empty($model->status)): ?>
                                <span class="badge" style="background-color: <?= Html::encode($model->status->color_code ?? '#000') ?>">
                                    <?= Html::encode($model->status->name) ?>
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
                        <label><i class="bi bi-cash-stack"></i> Költségvetés</label>
                        <div class="value">
                            <?php if (!empty($model->budget)): ?>
                                <strong><?= GlobalHelper::priceFormat($model->budget) ?></strong>
                            <?php else: ?>
                                <span class="text-muted">Nincs megadva</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="info-item mb-0">
                        <label><i class="bi bi-person-badge"></i> Létrehozta</label>
                        <div class="value">
                            <?php if (!empty($model->createdbyuser)): ?>
                                <?= Html::encode($model->createdbyuser->profile->name ?? 'Ismeretlen') ?>
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
                        <i class="bi bi-calendar-event me-2 text-primary"></i>
                        Időzítés
                    </h5>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <label><i class="bi bi-calendar-check"></i> Kezdés</label>
                        <div class="value">
                            <?php if (!empty($model->start_date)): ?>
                                <?= Yii::$app->formatter->asDate($model->start_date, 'long') ?>
                            <?php else: ?>
                                <span class="text-muted">Nincs megadva</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="info-item">
                        <label><i class="bi bi-calendar-x"></i> Határidő</label>
                        <div class="value">
                            <?php if (!empty($model->deadline)): ?>
                                <?php
                                $deadline = new DateTime($model->deadline);
                                $now = new DateTime();
                                $isOverdue = $deadline < $now;
                                ?>
                                <span class="<?= $isOverdue ? 'text-danger fw-bold' : '' ?>">
                                    <?= Yii::$app->formatter->asDate($model->deadline, 'long') ?>
                                    <?php if ($isOverdue): ?>
                                        <i class="bi bi-exclamation-circle ms-1"></i>
                                    <?php endif; ?>
                                </span>
                            <?php else: ?>
                                <span class="text-muted">Nincs megadva</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="info-item mb-0">
                        <label><i class="bi bi-tags"></i> Címkék</label>
                        <div class="value">
                            <?php if (!empty($model->tagitems)): ?>
                                <div class="d-flex flex-wrap gap-1">
                                    <?php foreach ($model->tagitems as $tag): ?>
                                        <span class="badge bg-light text-dark border">
                                            <?= Html::encode($tag->name) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <span class="text-muted">Nincsenek címkék</span>
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
                <div class="description-content">
                    <?= $model->description ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>