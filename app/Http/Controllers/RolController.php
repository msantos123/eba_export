<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Rol;
use App\Models\Permiso;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RolController extends Controller
{
    function index()
    {
        $roles = Rol::all();
        return Inertia::render('Roles/Index',[
            'roles' => $roles,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $role = Rol::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);
        return response()->json($role, 201);
    }

    public function show($id)
    {
        $permisos = Permiso::all();
        $rol_permisos = Rol::with('permissions')
            ->where('id', $id)
            ->first();

        return Inertia::render('Roles/Show', [
            'rol_permisos' => $rol_permisos,
            'permisos' => $permisos,
        ]);
    }

    function asignacion(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'roles' => 'required',
            'roles.*' => 'exists:roles,name',
        ]);

        $user = User::find($request->user_id);
        $user->syncRoles($request->roles);

        return response()->json(['message' => 'Rol asignado correctamente']);
    }

    public function updatePermissions(Request $request, $id)
    {
        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $rol = Rol::findOrFail($id);
        $rol->permissions()->sync($request->permissions);

        return response()->json(['message' => 'Permisos actualizados correctamente.']);
    }
}
