<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Planta;
use App\Models\Rol;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::select('_bp_usuarios.*', 'model_has_roles.*', 'roles.*')
        ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', '_bp_usuarios.usr_id')
        ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
        ->where('_bp_usuarios.usr_estado', 'A')
        ->get();
        $roles =  Rol::all();
        return Inertia::render('Users/Index', [
            'usuarios' => $usuarios,
            'roles' => $roles,
        ]);
    }
}
