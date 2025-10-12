<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        A fenti hiba a kérés feldolgozása közben lépett fel a szerveren.
    </p>
    <p>
        Kérjük, vedd fel velünk a kapcsolatot, ha úgy gondolod, hogy ez egy szerveroldali hiba. Köszönjük!
    </p>

</div>