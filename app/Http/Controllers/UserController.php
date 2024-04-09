<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;


class CrudController extends Controller
{
    use RegistersUsers;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::where('id', '!=', Auth::user()->id)->get();
        foreach ($users as $user) {
            foreach ($user->getRoleNames() as $rol){
                $perfil=$rol;
                $user['perfil'] = $perfil;
            }
        }
        $max_user = 0;
        return view('users.index',compact('users','max_user'));
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return redirect()->route('users.create')
                ->withErrors($validator)
                ->withInput();
        }
        //Inicia el registro
        $role_r =  Role::findById($request['roles']);
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        $user->assignRole($role_r); //Assigning role to user
        // evento de nuevo registro
        event(new Registered($user));
        /* Loguea automaticamente el usuario
        $this->guard()->login($user); */
        // redrecciona con el mensaje
        return redirect()->route('users.index')
            ->with('success','El usuario ha sido creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user['perfil'] = $this->getRolName($user);
        $user['role'] = $this->getRolId($user);
        if($user->active == 1){
            $user['estado'] = 'ACTIVO';
        }else{
            $user['estado'] = 'INACTIVO';
        }
        //dd($empresa);
        return view('users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $user['role'] = $this->getRolId($user);
        return view('users.edit', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        /*$role_old =  Role::findById($this->getRolId($user));
        $role_r =  Role::findById($request->input('roles'));*/
        $user->update([
            'name' => $request->input('name'),
            'active' => $request->input('activate'),
            'developer' => $request->input('dev'),
        ]);
        /*$user->removeRole($role_old);
        $user->assignRole($role_r); //Assigning role to user*/
        return redirect()->route('users.index')
            ->with('success', 'El usuario ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $role_old =  Role::findById($this->getRolId($user));
        $user->removeRole($role_old);
        $user->delete();
        return redirect()->route('users.index')
            ->with('error', 'El usuario ha sido eliminado');
    }

    private function getRolName(User $user)
    {
        $roles = $user->getRoleNames();
        // dd($roles);
        foreach($roles as $rol){
            $rolName = $rol;
        }

        return $rolName;
    }

    private function getRolId(User $user)
    {
        $rol = Role::where('name', $this->getRolName($user))->first();
        return $rol->id;
    }
}
