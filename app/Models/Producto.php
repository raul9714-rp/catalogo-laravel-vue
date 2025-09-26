<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Producto extends Model
{
    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'fotografia',
        'fecha_ingreso',
        'fecha_vencimiento'
    ];

    
}
