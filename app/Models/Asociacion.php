<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asociacion extends Model
{
    protected $fillable = [
        'nombre',
        'resolucion',
        'fecha_resolucion',
        'fecha_eleccion',
        'presidente_id',
        'vicepresidente_id',
        'secretario_id',
        'tesorero_id',
        'fiscal_id',
        'comuna_id',
        'municipio_id',
        'personeria',
        'nomanexo',
        'keyanexo',
    ];

    protected $table = 'asociaciones';

    public function presidente()
    {
        return $this->belongsTo(Funcionario::class, 'presidente_id');
    }

    public function vicepresidente()
    {
        return $this->belongsTo(Funcionario::class, 'vicepresidente_id');
    }

    public function secretario()
    {
        return $this->belongsTo(Funcionario::class, 'secretario_id');
    }

    public function tesorero()
    {
        return $this->belongsTo(Funcionario::class, 'tesorero_id');
    }

    public function fiscal()
    {
        return $this->belongsTo(Funcionario::class, 'fiscal_id');
    }

    public function comuna()
    {
        return $this->belongsTo(Comuna::class, 'comuna_id');
    }

    public function documentos()
    {
        return $this->morphMany(Documento::class, 'documentable');
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'municipio_id');
    }

    public function comisiones()
    {
        return $this->morphMany(Comision::class, 'owner')->orderBy('nomcomision');
    }

    public function autos()
    {
        return $this->morphMany(Auto::class, 'owner');
    }

    public function carpetas()
    {
        return $this->morphMany(Carpeta::class, 'owner');
    }

}
