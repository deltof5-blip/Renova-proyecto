<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Movil extends Model
{
    use HasFactory;

    protected $fillable = ['modelo_id', 'color', 'grado', 'almacenamiento', 'stock'];

    public function modelo()
    {
        return $this->belongsTo(Modelo::class);
    }
}
