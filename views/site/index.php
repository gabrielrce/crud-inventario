<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<div class="site-index text-center mt-5">

    <h1 class="mb-4">Bienvenido al Sistema de Gestión de Inventario Simplificado</h1>

    <p>
        <a class="btn btn-lg btn-primary mx-2" href="<?= \yii\helpers\Url::to(['producto/index']) ?>">
            Productos
        </a>
        <a class="btn btn-lg btn-primary mx-2" href="<?= \yii\helpers\Url::to(['categoria/index']) ?>">
            Categorías
        </a>
    </p>

</div>