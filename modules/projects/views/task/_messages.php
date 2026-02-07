<?php

use app\modules\projects\models\TaskMessage;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var TaskMessage[] $messages
 */

$isEmpty = empty($messages);

$loggedInUserId = Yii::$app->user->id;
?>

<div class="task-messages-container <?= ($isEmpty ? 'empty' : '') ?>">
    <?php if($isEmpty){ ?>
        <p class="text-muted text-center py-3 no-messages-yet">Még nincsenek üzenetek.</p>
    <?php }else{ ?>
        <?php foreach ($messages as $msg): ?>
            <div id="msg-<?= $msg->id ?>" class="message mb-2 <?= $msg->sender_id == Yii::$app->user->id ? 'text-end' : '' ?>">
                <small class="text-muted mb-1 d-block">
                    <?php if($loggedInUserId == $msg->sender_id){
                        echo '<a href="#" class="text-danger delete-msg me-2" data-id="'.$msg->id.'" title="Törlés">
                            <i class="fas fa-trash-alt" style="font-size: 0.8rem;"></i>
                        </a>';
                    } ?>
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

<script>
    var deleteMsgUrl = '<?= Url::to(["/projects/task/delete-message-ajax"]) ?>';
    var csrfToken = '<?= Yii::$app->request->getCsrfToken() ?>';
    var csrfParam = '<?= Yii::$app->request->csrfParam ?>';
</script>