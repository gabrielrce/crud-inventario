<?php

use yii\db\Migration;

class m250627_201541_create_categoria_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('categoria', [
            'id' => $this->primaryKey(),
            'nombre' => $this->string()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('categoria');
    }
}
