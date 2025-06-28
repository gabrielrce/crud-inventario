<?php
use yii\web\JqueryAsset;
use yii\helpers\Url;

$this->title = 'Lista de Productos';

JqueryAsset::register($this);

$this->registerCssFile('https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css');
$this->registerJsFile('https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerJsFile('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>

<h1>Lista de Productos</h1>
<button id="btn-nuevo" class="btn btn-success" style="margin-bottom: 15px;">Añadir Nuevo Producto</button>
<form id="filtros" style="margin-bottom: 15px;">
    <select id="filter-categoria">
        <option value="">Todas las categorías</option>
        <option value="1">Categoría 1</option>
        <option value="2">Categoría 2</option>
        <option value="3">Categoría 3</option>
    </select>

    <input type="number" id="filter-precio-min" placeholder="Precio mínimo" step="0.01">
    <input type="number" id="filter-precio-max" placeholder="Precio máximo" step="0.01">

    <button class="btn btn-success" type="submit">Aplicar Filtros</button>
</form>
<table id="tabla-productos" class="display" style="width:100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Categoría ID</th>
            <th></th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
<div class="modal fade" id="modal-producto" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Nuevo Producto</h5>
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
    var tabla = $('#tabla-productos').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'http://localhost:8080/producto/search',
            data: function(d) {
                d.categoria_id = $('#filter-categoria').val();
                d.precio_min = $('#filter-precio-min').val();
                d.precio_max = $('#filter-precio-max').val();
            },
            dataSrc: 'data'
        },
        columns: [
            { 
                data: 'id',
                render: function(data, type, row) {
                    return `<a href="http://localhost:8080/producto/${data}" target="_blank">${data}</a>`;
                }
            },
            { data: 'nombre' },
            { data: 'descripcion' },
            { data: 'precio' },
            { data: 'stock' },
            { data: 'categoria_id' },
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

    $('#filtros').on('submit', function(e){
        e.preventDefault();
        tabla.ajax.reload();
    });

    var modalProducto = new bootstrap.Modal(document.getElementById('modal-producto'));

    $('#btn-nuevo').on('click', function() {
        $('#modal-contenido').html('Cargando...');

        $.get('http://localhost:8080/producto/create-form', function(data) {
            $('#modal-contenido').html(data);
            modalProducto.show();
        });
    });

    $('#tabla-productos').on('click', '.btn-editar', function() {
        var id = $(this).data('id');
        $('#modal-contenido').html('Cargando...');
        $.get('http://localhost:8080/producto/update-form?id=' + id, function(data) {
            $('#modal-contenido').html(data);
            modalProducto.show();
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
            url: 'http://localhost:8080/producto/' + id,
            type: 'PUT',
            contentType: 'application/json',
            data: JSON.stringify(datos),
            success: function(response) {
                location.reload();
            },
            error: function(xhr) {
                alert('Error al actualizar producto: ' + xhr.responseText);
            }
        });
    });

    $('#tabla-productos').on('click', '.btn-eliminar', function() {
        var id = $(this).data('id');
        if (confirm('¿Estás seguro de eliminar este producto?')) {
            $.ajax({
                url: 'http://localhost:8080/producto/' + id,
                type: 'DELETE',
                success: function(response) {
                    alert(response.mensaje || 'Producto eliminado');
                    $('#tabla-productos').DataTable().ajax.reload();
                },
                error: function() {
                    alert('Error al eliminar producto');
                }
            });
        }
    });
});
JS;

$this->registerJs($script);
?>
