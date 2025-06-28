# CRUD Inventario

Sistema de gestión de inventario desarrollado con **Yii2**. Permite administrar productos y categorías mediante un CRUD completo, con filtros y buscadores integrados utilizando **DataTables** y **Bootstrap 5**.

---

## Tecnologías utilizadas

* PHP 8.x
* Yii2 Framework (App Basic)
* MySQL/MariaDB
* jQuery
* DataTables
* Bootstrap 5

---

## Requisitos previos

* PHP 8.0 o superior
* Composer
* MySQL o MariaDB
* Servidor local (XAMPP, WAMP o similar)

---

## Instalación

1. Clona el repositorio:

```bash
git clone https://github.com/gabrielrce/crud-inventario.git
cd crud-inventario
```

2. Instala dependencias de Composer:

```bash
composer install
```

3. Configura la base de datos:

Edita el archivo `config/db.php` y coloca tus credenciales de conexión.

```php
return [
    'class' => 'yii\\db\\Connection',
    'dsn' => 'mysql:host=localhost;dbname=crud_inventario',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];
```

4. Ejecuta las migraciones (si tienes migraciones definidas):

```bash
php yii migrate
```

5. Inicia el servidor:

```bash
php yii serve
```

Accede a: [http://localhost:8080](http://localhost:8080)

---

## Funcionalidades principales

* CRUD de Productos
* CRUD de Categorías
* Filtros y búsqueda con DataTables
* Validaciones en Backend con Yii2
* Interfaz simple con Bootstrap
* Modales para creación y edición
* Pruebas unitarias básicas (PHPUnit integrado)

---

## Estructura básica

* `controllers/` → Lógica de control para Productos y Categorías
* `models/` → Modelos de datos y validaciones
* `views/` → Vistas en Yii2 + Formularios parciales
* `web/` → Archivos accesibles públicamente (CSS, JS)


---

## Autor

Desarrollado por [Gabriel Ramírez](https://github.com/gabrielrce) \:rocket:

---
