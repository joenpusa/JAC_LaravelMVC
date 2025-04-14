<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carpeta extends Model
{
    protected $table = 'carpetas';
    protected $fillable = [
        'libro',
        'causal',
        'fecha',
        'folios',
        'owner_type',
        'owner_id',
        'usuario_id',
    ];

    // Relación polimórfica con Junta o Asociación
    public function owner()
    {
        return $this->morphTo();
    }

    // Relación con usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
