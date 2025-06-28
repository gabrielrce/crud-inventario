<?php
/** @var app\models\Producto $model */
?>

<form id="form-editar" data-id="<?= $model->id ?>">
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($model->nombre) ?>" required>
    </div>

    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcion" name="descripcion"><?= htmlspecialchars($model->descripcion) ?></textarea>
    </div>

    <div class="mb-3">
        <label for="precio" class="form-label">Precio</label>
        <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="<?= htmlspecialchars($model->precio) ?>" required>
    </div>

    <div class="mb-3">
        <label for="stock" class="form-label">Stock</label>
        <input type="number" class="form-control" id="stock" name="stock" value="<?= htmlspecialchars($model->stock) ?>" required>
    </div>

    <div class="mb-3">
        <label for="categoria_id" class="form-label">Categoría</label>
        <input type="number" class="form-control" id="categoria_id" name="categoria_id" value="<?= htmlspecialchars($model->categoria_id) ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
</form>