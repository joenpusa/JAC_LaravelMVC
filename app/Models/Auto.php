<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auto extends Model
{
    protected $table = 'autos';
    protected $fillable = [
        'fecha',
        'numero',
        'tipo',
        'keyarchivo',
        'usuario_id',
        'owner_id',
        'owner_type',
    ];

    // Relación polimórfica inversa
    public function owner()
    {
        return $this->morphTo();
    }

    // Relación con el usuario que registró el auto
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

}
