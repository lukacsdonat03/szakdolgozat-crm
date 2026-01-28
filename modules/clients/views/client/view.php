<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\clients\models\Client $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ügyfelek', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="client-view">
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-sm-3 gap-1 flex-column flex-sm-row client-avatar-wrapper">
                    <div class="client-avatar">
                        <i class="bi bi-building"></i>
                    </div>
                    <div>
                        <h2 class="mb-1 fw-bold"><?= Html::encode($model->name) ?></h2>
                        <?php if (!empty($model->company)): ?>
                            <p class="text-muted mb-0">
                                <i class="bi bi-briefcase me-1"></i>
                                <?= Html::encode($model->company) ?>
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
                                'confirm' => 'Biztosan törölni szeretnéd ezt az ügyfelet?',
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
                        <i class="bi bi-person-lines-fill me-2 text-primary"></i>
                        Kapcsolati adatok
                    </h5>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <label><i class="bi bi-envelope"></i> Email</label>
                        <div class="value">
                            <?php if (!empty($model->email)): ?>
                                <a href="mailto:<?= Html::encode($model->email) ?>" class="anim">
                                    <?= Html::encode($model->email) ?>
                                </a>
                            <?php else: ?>
                                <span class="text-muted">Nincs megadva</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="info-item">
                        <label><i class="bi bi-telephone"></i> Telefon</label>
                        <div class="value">
                            <?php if (!empty($model->phone)): ?>
                                <a href="tel:<?= Html::encode($model->phone) ?>" class="anim">
                                    <?= Html::encode($model->phone) ?>
                                </a>
                            <?php else: ?>
                                <span class="text-muted">Nincs megadva</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="info-item mb-0">
                        <label><i class="bi bi-geo-alt"></i> Cím</label>
                        <div class="value">
                            <?php if (!empty($model->address)): ?>
                                <?= Html::encode($model->address) ?>
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
                        <i class="bi bi-building me-2 text-primary"></i>
                        Céges adatok
                    </h5>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <label><i class="bi bi-bank"></i> Adószám</label>
                        <div class="value">
                            <?php if (!empty($model->tax_number)): ?>
                                <span class="badge bg-light text-dark">
                                    <?= Html::encode($model->tax_number) ?>
                                </span>
                            <?php else: ?>
                                <span class="text-muted">Nincs megadva</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if (!empty($model->notes)): ?>
                        <div class="info-item">
                            <label><i class="bi bi-sticky"></i> Jegyzetet</label>
                            <div class="value">
                                <span class="text-dark">
                                    <?= nl2br(Html::encode($model->notes)) ?>
                                </span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
