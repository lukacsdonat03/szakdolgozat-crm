<?php

use app\modules\messages\models\Message;
use app\modules\messages\models\search\MessageSearch;
use yii\bootstrap5\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = 'Üzenőfal';

/**
 * @var MessageSearch $searchModel
 * @var ActiveDataProvider $dataProvider
 * @var Message $newMessage
 */
?>


<div class="container-fluid py-4">
    <div class="wall-container d-flex flex-column flex-md-row">
        <div class="wall-sidebar">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Új bejegyzés</h5>
                    <?php $form = ActiveForm::begin([
                        'id' => 'wall-post-form',
                        'action' => ['send-wall-message'],
                    ]); ?>
                    
                    <div id="reply-to-box" class="alert alert-secondary d-none py-2 px-3 small">
                        <span>Válasz: <strong id="reply-to-user"></strong></span>
                        <button type="button" class="btn-close float-end" style="font-size: 0.6rem;"></button>
                    </div>

                    <?= $form->field($newMessage, 'content')->textarea(['rows' => 3, 'id' => 'wall-content', 'placeholder' => 'Mondd el mindenkinek...'])->label(false) ?>
                    <?= $form->field($newMessage, 'reply_to_id')->hiddenInput(['id' => 'reply-to-id'])->label(false) ?>

                    <div class="text-end">
                        <?= Html::submitButton('Közzététel', ['class' => 'btn btn-primary px-4']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>

        <?php Pjax::begin(['id' => 'wall-pjax-container', 'timeout' => 5000,'scrollTo' => false]); ?>
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_message_item',
                'summary' => false,
                'layout' => "{items}\n<div class='mt-4 d-flex justify-content-center pb-md-5 pb-2'>{pager}</div>",
                'itemOptions' => ['tag' => false],
                'pager' => [
                    'class' => \yii\bootstrap5\LinkPager::class,
                    'maxButtonCount' => 5,
                ],
            ]) ?>
        <?php Pjax::end(); ?>
    </div>
</div>
