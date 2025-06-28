<?php

namespace tests\unit\controllers;

use Yii;
use app\controllers\ProductoController;

class ProductoControllerTest extends \Codeception\Test\Unit
{
    public function testCrearProducto()
    {
        $controller = new ProductoController('producto', Yii::$app);

        Yii::$app->request->setBodyParams([
            'nombre' => 'Test Producto',
            'descripcion' => 'Descripción test',
            'precio' => 99.99,
            'stock' => 5,
            'categoria_id' => 1
        ]);

        $response = $controller->actionCreate();

        $this->assertIsArray($response);
        $this->assertEquals('Producto creado', $response['mensaje']);
    }
}
