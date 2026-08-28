<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificado extends Model
{
    protected $fillable = [
        'nombre_dignatario',
        'cargo',
        'auto_numero',
        'comuna',
        'nombre_junta',
        'codigo_hash',
        'resolucion',
        'fecha_resolucion',
        'fecha_eleccion',
        'documento_dignario',
        'tipo',
        'verificado',
    ];
}
