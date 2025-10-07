<?php

use app\assets\AppAsset;
use app\assets\AuthAsset;
use app\assets\LayoutAsset;
use yii\bootstrap5\Html;

AppAsset::register($this);
LayoutAsset::register($this);

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

<body class="d-flex flex-column min-vh-100">
    <?php $this->beginBody() ?>
    
    <!-- HEADER -->
    <?= Yii::$app->controller->renderPartial('@app/themes/main/layouts/_header') ?>
    
    <!-- SIDEBAR -->
    <?= Yii::$app->controller->renderPartial('@app/themes/main/layouts/_sidebar') ?>
    
    <main id="main" class="flex-shrink-0 main-element anim" role="main">
        <div class="container">
            <?= $content ?>
        </div>
    </main>
    
    <!-- FOOTER -->
    <div class="main-element anim">
        <?= Yii::$app->controller->renderPartial('@app/themes/main/layouts/_footer') ?>
    </div>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>