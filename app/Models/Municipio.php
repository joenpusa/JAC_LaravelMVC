<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
