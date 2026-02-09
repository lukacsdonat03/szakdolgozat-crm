<?php
use yii\helpers\Html;
$isMine = ($model->sender_id == Yii::$app->user->id);
?>

<div class="d-flex <?= $isMine ? 'justify-content-end' : 'justify-content-start' ?> mb-3 wall-message" data-id="<?= $model->id ?>">
    <div class="message-bubble shadow-sm p-3 <?= $isMine ? 'bg-primary text-white rounded-start-lg' : 'bg-white border rounded-end-lg' ?>">
        
        <?php if ($model->reply_to_id && $model->replyto): ?>
            <div class="reply-box p-2 mb-2 rounded <?= $isMine ? 'bg-white bg-opacity-25' : 'bg-light' ?> small">
                <strong class="d-block"><?= Html::encode($model->replyto->sender->username) ?></strong>
                <?= Html::encode(\yii\helpers\StringHelper::truncate($model->replyto->content, 50)) ?>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-1">
            <small class="fw-bold"><?= Html::encode($model->sender->username) ?></small>
            <small class="message-content <?= $isMine ? 'text-white-50' : 'text-muted' ?> ms-3">
                <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?>
            </small>
        </div>

        <div class="content">
            <?= nl2br(Html::encode($model->content)) ?>
        </div>

        <div class="actions mt-2 text-end">
            <a href="#" class="btn-reply text-decoration-none <?= $isMine ? 'text-white-50' : 'text-muted' ?> small" 
               data-id="<?= $model->id ?>" data-user="<?= Html::encode($model->sender->username) ?>">
                <i class="fas fa-reply"></i> Válasz
            </a>
        </div>
    </div>
</div>