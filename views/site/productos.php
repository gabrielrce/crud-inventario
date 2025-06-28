<?php
$this->title = 'Lista de Productos';
?>
<h1>Lista de Productos2</h1>

<p>
    <button id="btn-recargar">Recargar</button>
</p>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Categoría ID</th>
        </tr>
    </thead>
    <tbody id="tabla-productos">
    </tbody>
</table>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const BASE_URL = "http://localhost:8080"; // Ajusta si es necesario

function cargarProductos() {
    $.get(`${BASE_URL}/producto`, function(productos) {
        const tabla = $('#tabla-productos').empty();
        productos.forEach(prod => {
            tabla.append(`
                <tr>
                    <td>${prod.id}</td>
                    <td>${prod.nombre}</td>
                    <td>${prod.descripcion || ''}</td>
                    <td>${prod.precio}</td>
                    <td>${prod.stock}</td>
                    <td>${prod.categoria_id}</td>
                </tr>
            `);
        });
    });
}

$(document).ready(function() {
    cargarProductos();

    $('#btn-recargar').click(function() {
        cargarProductos();
    });
});
</script>
