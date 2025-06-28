<?php

namespace tests\unit\models;

use app\models\Producto;

class ProductoTest extends \Codeception\Test\Unit
{
    public function testValidacionExitosa()
    {
        $producto = new Producto([
            'nombre' => 'Producto Prueba',
            'descripcion' => 'Descripción de prueba',
            'precio' => 100,
            'stock' => 10,
            'categoria_id' => 1
        ]);

        $this->assertTrue($producto->validate());
    }

    public function testValidacionFallida()
    {
        $producto = new Producto([
            'nombre' => '',
            'precio' => -50,
            'stock' => -1,
        ]);

        $this->assertFalse($producto->validate());
        $this->assertArrayHasKey('nombre', $producto->getErrors());
        $this->assertArrayHasKey('precio', $producto->getErrors());
    }
}
