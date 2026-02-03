<?php

use app\components\GlobalHelper;
use app\modules\users\Usermodule;
use yii\helpers\Url;

$moduleId = GlobalHelper::getModuleId();
?>

<nav id="sidebar" class="d-flex flex-column bg-white active border-end vh-100 position-fixed">
  <div class="p-3">
    <h5 class="mb-4 text-uppercase text-muted">Menü</h5>
    <ul class="nav flex-column">
      <li class="nav-item mb-2">
        <a href="<?= Url::to(['/projects/task/calendar']) ?>" class="nav-link anim text-dark d-flex align-items-center">
          <i class="bi bi-calendar-range-fill me-2"></i> Naptár
        </a>
      </li>
      <li class="nav-item mb-2">
        <a href="#" class="nav-link anim text-dark d-flex align-items-center">
          <i class="bi bi-house me-2"></i> Dashboard
        </a>
      </li>
      <li class="nav-item mb-2">
        <a href="<?= Url::to(['/clients/client/index']) ?>" class="nav-link anim text-dark d-flex align-items-center">
          <i class="bi bi-people me-2"></i> Ügyfelek
        </a>
      </li>
      <li class="nav-item mb-2">
        <a href="#projectSubmenu" class="nav-link anim text-dark d-flex align-items-center justify-content-between"
          data-bs-toggle="collapse" aria-expanded="<?= ($moduleId == 'projects') ? 'true' : 'false' ?>">
          <span><i class="bi bi-briefcase me-2"></i> Projektek</span>
          <i class="bi bi-chevron-down transition-transform"></i>
        </a>
        <ul class="collapse list-unstyled ps-4 <?= ($moduleId == 'projects') ? 'show' : '' ?>" id="projectSubmenu">
          <li class="mb-2">
            <a class="nav-link anim text-dark" href="<?= Url::to(['/projects/project/index']) ?>">
              <i class="bi bi-list-ul me-2"></i> Összes projekt
            </a>
          </li>
          <li class="mb-2">
            <a class="nav-link anim text-dark" href="<?= Url::to(['/projects/task/index']) ?>">
              <i class="bi bi-journal-bookmark-fill me-2"></i> Feladatok
            </a>
          </li>
          <li class="mb-2">
            <a class="nav-link anim text-dark" href="<?= Url::to(['/projects/status/index']) ?>">
              <i class="bi bi-palette2"></i> Projekt státuszok
            </a>
          </li>
          <li class="mb-2">
            <a class="nav-link anim text-dark" href="<?= Url::to(['/projects/tag/index']) ?>">
             <i class="bi bi-tags"></i> Projekt címkék
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item mb-2">
        <a href="#" class="nav-link anim text-dark d-flex align-items-center">
          <i class="bi bi-chat-dots me-2"></i> Messages
        </a>
      </li>
      <?php if (Usermodule::hasAdminRole()): ?>
        <li class="nav-item mb-2">
          <a href="#adminSubmenu" class="nav-link anim text-dark d-flex align-items-center justify-content-between"
            data-bs-toggle="collapse" aria-expanded="<?= ($moduleId == 'users') ? 'true' : 'false' ?>">
            <span><i class="bi bi-gear me-2"></i> Admin</span>
            <i class="bi bi-chevron-down transition-transform"></i>
          </a>
          <ul class="collapse list-unstyled ps-4 <?= ($moduleId == 'users') ? 'show' : '' ?>" id="adminSubmenu">
            <li class="mb-2">
              <a class="nav-link anim text-dark" href="<?= Url::to(['/users/user/index']) ?>">
                <i class="bi bi-person-circle me-2"></i> Felhasználók
              </a>
            </li>
            <li class="mb-2">
              <a class="nav-link anim text-dark" href="<?= Url::to(['/users/position/index']) ?>">
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