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
        $usuarios = User::select('users.id','ci','paterno','materno',
        'name','email','celular','planta_id','rol','users.estado',
        'plantas.nombre as planta','rols.nombre as role')
        ->join('plantas','plantas.id','=','users.planta_id')
        ->join('rols','rols.id','=','users.rol')
        ->paginate(5);
        return Inertia::render('Users/Index', [
            'users' => $usuarios,
            'plantas' => Planta::all(),
            'roles' => Rol::all(),
        ]);
    }

    public function store(Request $request)
    {
        //dd($request);
        $request->validate([
            'ci'=>'required',
            'paterno'=>'required|max:20',
            'materno'=>'required|max:20',
            'name'=>'required|max:30',
            'email'=>'required|max:80',
            'celular'=>'required',
            'planta_id'=>'required',
            'rol'=>'required',
        ]);
        $usuario = new User($request->input());
        $usuario->save();
        return redirect('users');
    }

    public function update(Request $request, User $user)
    {
        //dd($request);
        $request->validate([
            'ci'=>'required',
            'paterno'=>'required|max:20',
            'materno'=>'required|max:20',
            'name'=>'required|max:30',
            'email'=>'required|max:80',
            'celular'=>'required',
            'planta_id'=>'required',
            'rol'=>'required',
        ]);
        $user->update($request->input());
        return redirect('users');
    }
    public function active($id)
    {
        $user = User::findOrFail($id);

        // Cambia el estado alternadamente
        if ($user->estado == 0) {
            $user->estado = 1;
        } else {
            $user->estado = 0;
        }
        $user->save();
        return redirect('users');
    }

}
