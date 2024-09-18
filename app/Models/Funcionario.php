<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $fillable = [
        'nombre',
        'tipo_documento',
        'num_documento',
        'num_afiliacion',
        'genero',
        'email',
        'direccion',
        'profesion',
        'grupo_etnico',
        'discapacidad',
        'name_anexo',
        'key_anexo'
    ];

    public function juntas()
    {
        return $this->hasMany(Junta::class);
    }
}
