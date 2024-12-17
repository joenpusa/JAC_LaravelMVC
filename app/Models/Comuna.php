<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comuna extends Model
{
    protected $fillable = [
        'nombre',
        'municipio_id'
    ];

    public function juntas()
    {
        return $this->hasMany(Junta::class);
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class);
    }

    public function asociaciones()
    {
        return $this->hasMany(Asociacion::class);
    }
}
