<?php

use app\modules\projects\models\TaskMessage;
use yii\helpers\Html;

/**
 * @var TaskMessage[] $messages
 */

$isEmpty = empty($messages);
?>

<div class="task-messages-container <?= ($isEmpty ? 'empty' : '') ?>">
    <?php if($isEmpty){ ?>
        <p class="text-muted text-center py-3 no-messages-yet">Még nincsenek üzenetek.</p>
    <?php }else{ ?>
        <?php foreach ($messages as $msg): ?>
            <div class="message mb-2 <?= $msg->sender_id == Yii::$app->user->id ? 'text-end' : '' ?>">
                <small class="text-muted mb-1 d-block">
                    <?= Html::encode($msg->sendername) ?> -
                    <?php
                        $timestamp = strtotime($msg->created_at);
                        // Ha 24 óránál frissebb akkor a relatív idő
                        if (time() - $timestamp < 86400) {
                            echo Yii::$app->formatter->asRelativeTime($msg->created_at);
                        } else {
                            echo Yii::$app->formatter->asDate($msg->created_at, 'php:Y.m.d H:i');
                        }
                    ?>
                </small>
                <div class="p-2 rounded <?= $msg->sender_id == Yii::$app->user->id ? 'bg-primary text-white' : 'bg-white' ?>">
                    <?= Html::encode($msg->content) ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php } ?>
</div>