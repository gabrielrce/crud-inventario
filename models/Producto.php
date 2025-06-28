<?php

namespace app\models;

use yii\db\ActiveRecord;

class Producto extends ActiveRecord
{
    public static function tableName()
    {
        return 'producto';
    }
    public function fields()
{
    return [
        'id',
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'categoria_id',
    ];
}


    public function rules()
    {
        return [
            [['nombre', 'precio', 'stock', 'categoria_id'], 'required'],
            [['descripcion'], 'string'],
            [['precio'], 'number'],
            [['stock', 'categoria_id'], 'integer'],
            [['nombre'], 'string', 'max' => 255],
        ];
    }

    public function getCategoria()
    {
        return $this->hasOne(Categoria::class, ['id' => 'categoria_id']);
    }
}
