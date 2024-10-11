<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nombre_app',
        'nom_entidad',
        'direccion',
        'horario',
        'telefono',
        'email',
        'logo',
    ];
}
