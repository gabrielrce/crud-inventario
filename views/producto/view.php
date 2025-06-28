<?php
/** @var app\models\Producto $model */

use yii\helpers\Html;

$this->title = 'Producto: ' . Html::encode($model->nombre);
?>

<div class="container my-4">
    <div class="card p-3 shadow-sm">
        <p><strong>ID:</strong> <?= Html::encode($model->id) ?></p>
        <p><strong>Nombre:</strong> <?= Html::encode($model->nombre) ?></p>
        <p><strong>Descripción:</strong> <?= Html::encode($model->descripcion) ?></p>
        <p><strong>Precio:</strong> $<?= number_format($model->precio, 2) ?></p>
        <p><strong>Stock:</strong> <?= Html::encode($model->stock) ?></p>
        <p><strong>Categoría ID:</strong> <?= Html::encode($model->categoria_id) ?></p>
    </div>
</div>
