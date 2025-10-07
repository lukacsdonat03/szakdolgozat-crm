<?php

use app\assets\AppAsset;
use app\assets\AuthAsset;
use app\components\AppAlert;
use app\components\Params;
use yii\bootstrap5\Html;

AuthAsset::register($this);
AppAsset::register($this);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="min-vh-100">

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    
    <link rel="icon" type="image/png" href="/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicon/favicon.svg" />
    <link rel="shortcut icon" href="/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png" />
    <link rel="manifest" href="/favicon/site.webmanifest" />

    <title><?= Html::encode($this->title) ?></title>
    
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column container-background min-vh-100">
    <?php $this->beginBody() ?>
    
    <header>
        <div class="container">
            <a href="/" class="navbar-brand">
                <img src="/img/logo.png" alt="<?= Params::getParam('name') ?>">
            </a>
        </div>
    </header>

    <main id="main" class="flex-shrink-0 my-auto" role="main">
        <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center text-center">
            <div class="container">
                <?= AppAlert::showAlert() ?>
                <?= $content ?>
            </div>
        </div>
    </main>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>