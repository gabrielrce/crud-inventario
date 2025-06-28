<?php
/** @var app\models\Producto $model */
?>

<form id="form-editar" data-id="<?= $model->id ?>">
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($model->nombre) ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
</form>