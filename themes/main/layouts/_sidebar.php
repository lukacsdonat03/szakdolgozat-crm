<?php

use app\modules\users\Usermodule;
use yii\helpers\Url;

?>

<nav id="sidebar" class="d-flex flex-column bg-white active border-end vh-100 position-fixed">
  <div class="p-3">
    <h5 class="mb-4 text-uppercase text-muted">Menü</h5>
    <ul class="nav flex-column">
      <li class="nav-item mb-2">
        <a href="#" class="nav-link anim text-dark d-flex align-items-center">
          <i class="bi bi-house me-2"></i> Dashboard
        </a>
      </li>
      <li class="nav-item mb-2">
        <a href="#" class="nav-link anim text-dark d-flex align-items-center">
          <i class="bi bi-people me-2"></i> Clients
        </a>
      </li>
      <li class="nav-item mb-2">
        <a href="#" class="nav-link anim text-dark d-flex align-items-center">
          <i class="bi bi-briefcase me-2"></i> Projects
        </a>
      </li>
      <li class="nav-item mb-2">
        <a href="#" class="nav-link anim text-dark d-flex align-items-center">
          <i class="bi bi-chat-dots me-2"></i> Messages
        </a>
      </li>
      <?php if (Usermodule::hasAdminRole()): ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle anim text-dark d-flex align-items-center" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-gear me-2"></i> Admin
          </a>
          <ul class="dropdown-menu" aria-labelledby="adminDropdown">
            <li>
              <a class="dropdown-item" href="<?= Url::to(['/users/user/index']) ?>">
                Felhasználók
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="<?= Url::to(['/users/position/index']) ?>">
                Szerepkörök
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