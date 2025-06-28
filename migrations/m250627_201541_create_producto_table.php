<?php

use yii\db\Migration;

class m250627_201541_create_producto_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('producto', [
            'id' => $this->primaryKey(),
            'nombre' => $this->string()->notNull(),
            'descripcion' => $this->text(),
            'precio' => $this->decimal(10, 2)->notNull(),
            'stock' => $this->integer()->notNull(),
            'categoria_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-producto-categoria_id',
            'producto',
            'categoria_id',
            'categoria',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-producto-categoria_id', 'producto');
        $this->dropTable('producto');
    }
}
