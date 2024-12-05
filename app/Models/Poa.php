<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poa extends Model
{
    use HasFactory;
    protected $fillable = [
        'meta_gestion',
        'meta_volumen',
        'meta_monetaria',
        'meta_estado',
    ];
}
