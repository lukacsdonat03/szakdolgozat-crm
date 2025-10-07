<?php

use app\components\Params;

?>

<header class="sticky-top w-100 bg-white">
    <nav>
        <div class="container-fluid py-2">
            <div class="left-wrapper d-flex align-items-center gap-5">
                <a href="/" class="header-logo">
                    <img src="/img/logo.png" alt="<?= Params::getParam('name') ?>">
                </a>
                <button class="sidebar-toggler anim" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </div>
    </nav>
</header>