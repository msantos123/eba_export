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
        'users.name','email','celular','users.estado','roles.name as role')
        ->join('model_has_roles', 'model_has_roles.model_id','=','users.id')
        ->join('roles', 'roles.id','=','model_has_roles.role_id')
        ->paginate(5);
        return Inertia::render('Users/Index', [
            'users' => $usuarios,
        ]);
    }

    public function store(Request $request)
    {
        $user = User::create([
            'ci'=> $request->input('ci'),
            'paterno'=> $request->input('paterno'),
            'materno'=> $request->input('materno'),
            'name'=> $request->input('name'),
            'email'=> $request->input('email'),
            'celular'=> $request->input('celular'),
        ]);

        $user->assignRole($request->input('rol'));
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
