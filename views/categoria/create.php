<form id="form-crear" data-id="<?= $model->id ?>">
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($model->nombre) ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
</form>

<script>
$('#form-crear').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
        url: 'http://localhost:8080/categoria/create',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify($(this).serializeArray().reduce((obj, item) => {
            obj[item.name] = item.value;
            return obj;
        }, {})),
        success: function(response) {
            alert('Categoria creada');
            location.reload();
        },
        error: function() {
            alert('Error al crear categoria');
        }
    });
});
</script>
