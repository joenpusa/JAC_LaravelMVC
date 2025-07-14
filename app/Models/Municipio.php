<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Municipio extends Model
{
    use HasFactory;
    protected $table = 'municipios';
    protected $primaryKey = 'id';


    public function juntas()
    {
        return $this->hasMany(Junta::class);
    }

    public function comunas()
    {
        return $this->hasMany(Comuna::class);
    }



    protected static function booted()
    {
        static::addGlobalScope('ordered', function (Builder $builder) {
            $builder->orderBy('nombre_municipio', 'asc');
        });
    }
}
