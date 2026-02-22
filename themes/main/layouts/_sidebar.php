<?php

use app\components\GlobalHelper;
use app\modules\users\Usermodule;
use yii\helpers\Url;

$notAssociate = !Usermodule::isAssociate();
?>

<nav id="sidebar" class="d-flex flex-column bg-white active border-end vh-100 position-fixed">
  <div class="p-3">
    <h5 class="mb-4 text-uppercase text-muted">Menü</h5>
    <ul class="nav flex-column">
      <li class="nav-item mb-2">
        <a href="<?= Url::to(['/projects/task/calendar']) ?>" class="nav-link anim text-dark d-flex align-items-center <?= GlobalHelper::isSelected('projects/task/calendar') ? 'selected' : '' ?>">
          <i class="bi bi-calendar-range-fill me-2"></i> Naptár
        </a>
      </li>
      <?php if($notAssociate){ ?>
        <li class="nav-item mb-2">
          <a href="#" class="nav-link anim text-dark d-flex align-items-center">
            <i class="bi bi-house me-2"></i> Dashboard
          </a>
        </li>
      <?php } ?>
      <?php if($notAssociate){ ?>
        <li class="nav-item mb-2">
          <a href="<?= Url::to(['/clients/client/index']) ?>" class="nav-link anim text-dark d-flex align-items-center <?= GlobalHelper::isSelected('clients') ? 'selected' : '' ?>">
            <i class="bi bi-people me-2"></i> Ügyfelek
          </a>
        </li>
      <?php } ?>
      <li class="nav-item mb-2">
        <?php
        // Akkor nyitott, ha a projektek modulban vagyunk, DE NEM a naptárnál
        $isProjectModuleActive = GlobalHelper::isSelected('projects') && !GlobalHelper::isSelected('projects/task/calendar');
        ?>
        <a href="#projectSubmenu" class="nav-link anim text-dark d-flex align-items-center justify-content-between"
          data-bs-toggle="collapse" aria-expanded="<?= $isProjectModuleActive ? 'true' : 'false' ?>">
          <span><i class="bi bi-briefcase me-2"></i> Projektek</span>
          <i class="bi bi-chevron-down transition-transform"></i>
        </a>
        <ul class="collapse list-unstyled ps-4 <?= $isProjectModuleActive ? 'show' : '' ?>" id="projectSubmenu">
          <li class="mb-2">
            <a class="nav-link anim text-dark <?= (GlobalHelper::isSelected('projects/project/index') || GlobalHelper::isSelected('projects/project/tasks')) ? 'selected' : '' ?>" href="<?= Url::to(['/projects/project/index']) ?>">
              <i class="bi bi-list-ul me-2"></i> Összes projekt
            </a>
          </li>
          <li class="mb-2">
            <a class="nav-link anim text-dark <?= GlobalHelper::isSelected('projects/task/index') ? 'selected' : '' ?>" href="<?= Url::to(['/projects/task/index']) ?>">
              <i class="bi bi-journal-bookmark-fill me-2"></i> Feladatok
            </a>
          </li>
          <?php if($notAssociate){ ?>
            <li class="mb-2">
              <a class="nav-link anim text-dark <?= GlobalHelper::isSelected('projects/status/index') ? 'selected' : '' ?>" href="<?= Url::to(['/projects/status/index']) ?>">
                <i class="bi bi-palette2"></i> Projekt státuszok
              </a>
            </li>
            <li class="mb-2">
              <a class="nav-link anim text-dark <?= GlobalHelper::isSelected('projects/tag/index') ? 'selected' : '' ?>" href="<?= Url::to(['/projects/tag/index']) ?>">
                <i class="bi bi-tags"></i> Projekt címkék
              </a>
            </li>
          <?php } ?>
        </ul>
      </li>
      <li class="nav-item mb-2">
        <a href="<?= Url::to(['/messages/message/messages']) ?>" class="nav-link anim text-dark d-flex align-items-center <?= GlobalHelper::isSelected('messages') ? 'selected' : '' ?>">
          <i class="bi bi-chat-dots me-2"></i> Üzenőfal
        </a>
      </li>
      <?php if (Usermodule::hasAdminRole()): ?>
        <?php $isAdminActive = GlobalHelper::isSelected('users'); ?>
        <li class="nav-item mb-2">
          <a href="#adminSubmenu" class="nav-link anim text-dark d-flex align-items-center justify-content-between"
            data-bs-toggle="collapse" aria-expanded="<?= $isAdminActive ? 'true' : 'false' ?>">
            <span><i class="bi bi-gear me-2"></i> Admin</span>
            <i class="bi bi-chevron-down transition-transform"></i>
          </a>
          <ul class="collapse list-unstyled ps-4 <?= $isAdminActive ? 'show' : '' ?>" id="adminSubmenu">
            <li class="mb-2">
              <a class="nav-link anim text-dark <?= GlobalHelper::isSelected('users/user/index') ? 'selected' : '' ?>" href="<?= Url::to(['/users/user/index']) ?>">
                <i class="bi bi-person-circle me-2"></i> Felhasználók
              </a>
            </li>
            <li class="mb-2">
              <a class="nav-link anim text-dark <?= GlobalHelper::isSelected('users/position/index') ? 'selected' : '' ?>" href="<?= Url::to(['/users/position/index']) ?>">
                <i class="bi bi-award me-2"></i> Szerepkörök
              </a>
            </li>
          </ul>
        </li>
      <?php endif; ?>

    </ul>
  </div>
  <div class="p-3 avatar-wrapper">
    <div class="sidebar-footer w-100 pt-2 dropup">
      <button type="button" class="avatar-container anim rounded-circle d-flex align-items-center justify-content-center"
        data-bs-toggle="dropdown" aria-expanded="false">
        <img src="/img/avatar.svg" alt="Avatar">
      </button>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="<?= Url::to(['/users/profile/profile']) ?>">Profilom</a></li>
        <li>
          <hr class="dropdown-divider">
        </li>
        <li><a class="dropdown-item" href="<?= Url::to(Usermodule::LOGOUT_URL) ?>" data-method="POST">Kijelentkezés</a></li>
      </ul>
    </div>
  </div>
</nav>