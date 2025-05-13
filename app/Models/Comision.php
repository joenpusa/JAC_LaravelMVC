<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comision extends Model
{
    protected $table = 'comisiones';

    protected $fillable = [
        'nomcomision',
        'nomcomisionado',
        'doccomisionado',
        'owner_type',
        'owner_id',
    ];

    /**
     * Relación polimórfica con Junta o Asociacion.
     */
    public function owner()
    {
        return $this->morphTo();
    }
}
