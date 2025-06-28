<?php

namespace app\models;

use yii\db\ActiveRecord;

class Categoria extends ActiveRecord
{
    public static function tableName()
    {
        return 'categoria';
    }

    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 255],
        ];
    }

    public function getProductos()
    {
        return $this->hasMany(Producto::class, ['categoria_id' => 'id']);
    }
}
