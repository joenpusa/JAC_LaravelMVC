<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $fillable = [
        'nomanexo',
        'keyanexo',
        'junta_id',
        'user_id'
    ];

    public function junta()
    {
        return $this->belongsTo(Junta::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
