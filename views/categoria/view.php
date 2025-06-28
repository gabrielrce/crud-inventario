<?php
/** @var app\models\Categoria $model */

use yii\helpers\Html;

$this->title = 'Categoría: ' . Html::encode($model->nombre);
?>

<div class="container my-4">
    <div class="card p-3 shadow-sm">
        <p><strong>ID:</strong> <?= Html::encode($model->id) ?></p>
        <p><strong>Nombre:</strong> <?= Html::encode($model->nombre) ?></p>
    </div>
</div>