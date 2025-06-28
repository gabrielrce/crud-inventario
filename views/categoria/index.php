<?php
use yii\web\JqueryAsset;
use yii\helpers\Url;

$this->title = 'Lista de Categorías';

JqueryAsset::register($this);

$this->registerCssFile('https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css');
$this->registerJsFile('https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerJsFile('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>

<h1>Lista de Categorías</h1>
<button id="btn-nuevo" style="margin-bottom: 15px;" class="btn btn-success">Añadir Nueva Categoría</button>

<table id="tabla-categorias" class="display" style="width:100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th></th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<div class="modal fade" id="modal-categoria" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Nueva Categoría</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" id="modal-contenido">
      </div>
    </div>
  </div>
</div>

<?php
$script = <<<'JS'
$(document).ready(function() {
    var tabla = $('#tabla-categorias').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'http://localhost:8080/categoria/search',
            dataSrc: 'data'
        },
        columns: [
            { 
                data: 'id',
                render: function(data, type, row) {
                    return `<a href="http://localhost:8080/categoria/${data}" target="_blank">${data}</a>`;
                }
            },
            { data: 'nombre' },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `
                        <button class="btn-editar btn btn-primary" data-id="${row.id}">Editar</button>
                        <button class="btn-eliminar btn btn-danger" data-id="${row.id}">Eliminar</button>
                    `;
                }
            }
        ],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json'
        }
    });

    var modalCategoria = new bootstrap.Modal(document.getElementById('modal-categoria'));

    $('#btn-nuevo').on('click', function() {
        $('#modal-contenido').html('Cargando...');
        $.get('http://localhost:8080/categoria/create-form', function(data) {
            $('#modal-contenido').html(data);
            modalCategoria.show();
        });
    });

    $('#tabla-categorias').on('click', '.btn-editar', function() {
        var id = $(this).data('id');
        $('#modal-contenido').html('Cargando...');
        $.get('http://localhost:8080/categoria/update-form?id=' + id, function(data) {
            $('#modal-contenido').html(data);
            modalCategoria.show();
        });
    });

    $(document).on('submit', '#form-editar', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var datos = $(this).serializeArray().reduce(function(obj, item) {
            obj[item.name] = item.value;
            return obj;
        }, {});

        $.ajax({
            url: 'http://localhost:8080/categoria/' + id,
            type: 'PUT',
            contentType: 'application/json',
            data: JSON.stringify(datos),
            success: function(response) {
                location.reload();
            },
            error: function(xhr) {
                alert('Error al actualizar categoría: ' + xhr.responseText);
            }
        });
    });

    $('#tabla-categorias').on('click', '.btn-eliminar', function() {
        var id = $(this).data('id');
        if (confirm('¿Estás seguro de eliminar esta categoría?')) {
            $.ajax({
                url: 'http://localhost:8080/categoria/' + id,
                type: 'DELETE',
                success: function(response) {
                    alert(response.mensaje || 'Categoría eliminada');
                    $('#tabla-categorias').DataTable().ajax.reload();
                },
                error: function() {
                    alert('Error al eliminar categoría');
                }
            });
        }
    });
});
JS;

$this->registerJs($script);
?>
