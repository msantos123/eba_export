<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;
    protected $table = 'export.roles';
    protected $fillable = [
        'id',
        'name',
        'guard_name',
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permiso::class, 'role_has_permissions', 'role_id', 'permission_id');
    }
}
