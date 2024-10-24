<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Junta extends Model
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
        'concil1_id',
        'concil2_id',
        'concil3_id',
        'delegado1_id',
        'delegado2_id',
        'delegado3_id',
        'comuna_id',
        'nomanexo',
        'keyanexo'
    ];

    public function presidente()
    {
        return $this->belongsTo(Funcionario::class, 'presidente_id');
    }

    // Relación para el vicepresidente
    public function vicepresidente()
    {
        return $this->belongsTo(Funcionario::class, 'vicepresidente_id');
    }

    // Si también tienes un secretario, sería algo así:
    public function secretario()
    {
        return $this->belongsTo(Funcionario::class, 'secretario_id');
    }

    public function comuna()
    {
        return $this->belongsTo(Comuna::class, 'comuna_id');
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class);
    }
}
