<?php

use app\modules\users\models\forms\ChangePasswordForm;
use app\modules\users\models\Position;
use app\modules\users\models\User;
use app\modules\users\models\Profile;

/**
 * @var User $user
 * @var Profile $profile
 * @var Position|null $position
 * @var ChangePasswordForm $passwordForm
 */

$this->title = 'Profilom';
?>

<div class="profile-view">
    <h1 class="subpage-title">
        <?= $this->title ?>
    </h1>
    <div class="profile-content">
        <div class="row">
            <div class="col-lg-4 col-12">
                <div class="avatar-card crm-card w-100 d-flex gap-3 flex-column align-items-center">
                    <img src="/img/avatar.svg" alt="<?= $profile->name ?>" class="object-fit-cover profile-avatar-img">
                    <div class="username-and-role d-flex flex-column text-center">
                        <div class="username">
                            <?= $user->username ?>
                        </div>
                        <?php if(!empty($position)){ ?>
                            <div class="position-label fst-italic">
                                <?= $position->name ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-12">
                <div class="profile-data crm-card">
                    <?= Yii::$app->controller->renderPartial('@app/modules/users/views/profile/_profile_tabs',['user' => $user,'profile' => $profile,'passwordForm' => $passwordForm]) ?>
                </div>
            </div>
        </div>
    </div>
</div>