<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Costo extends Model
{
    use HasFactory;
    protected $fillable = [
        'cts_usuario',
        'cts_planta',
        'cts_tipo',
        'cts_producto',
        'cts_precio',
        'cts_estado',
    ];
}
