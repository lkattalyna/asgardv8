<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $permissions = Permission::orderBy('name')->get();
        return view('permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:permissions,name',
        ]);
        $data = false;
        if($request->input('permission')){
            $data = true;
            foreach($request->input('permission') as $permiso){
                Permission::create(['name' => $request->input('name').$permiso]);
            }
        }
        if($request->input('new') !== null){
            $data = true;
            $this->validate($request, [
                'new' => 'required|min:1|max:10',
            ]);
            Permission::create(['name' => $request->input('name').$request->input('new')]);
        }
        if($data){
            return redirect()->route('permissions.index')
                ->with('success', 'Los permisos han sido creados con éxito');
        }else{
            return redirect()->back()
                ->withErrors(['Debe seleccionar o ingresar un permiso']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Permission $permission)
    {
        $rolesHasPermission = array();
        $roles = Role::all();
        foreach ($roles as $role){
            if($role->hasPermissionTo($permission->name)){
                array_push($rolesHasPermission, $role->name);
            }
        }
        return view('permissions.show',compact('permission','rolesHasPermission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Permission $permission)
    {
        return view('permissions.edit',compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Permission $permission)
    {
        $this->validate($request, [
            'name' => 'required|unique:permissions,name',
        ]);
        $permission->update([
            'name' => $request->input('name'),
        ]);
        return redirect()->route('permissions.index')->with('success', 'El permiso ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Permission $permission)
    {
        $roles = Role::all();
        $count = 0;
        foreach ($roles as $role) {
            if ($role->hasPermissionTo($permission->name)) {
                $count += 1;
            }
        }
        if($count != 0){
            return redirect()->route('permissions.index')->with('error', 'El permiso esta asignado a '.$count.' roles por lo cual no se puede eliminar');
        }else{
            $permission->delete();
            return redirect()->route('permissions.index')->with('error', 'El permiso ha sido eliminado con éxito');
        }

    }
    public function assign()
    {
        $permissions = Permission::orderBy('name','ASC')->get();
        $roles = Role::orderBy('name','ASC')->get();
        return view('permissions.assign',compact('permissions','roles'));
    }
    public function assignStore(Request $request)
    {
        $this->validate($request, [
            'permissions' => 'required',
        ]);
        if($request->input('roles')){
            foreach($request->input('roles') as $rol){
                $role = Role::findByName($rol);
                foreach ($request->input('permissions') as $permission){
                    $role->givePermissionTo($permission);
                }
            }
            return redirect()->route('permissions.index')->with('success', 'Los permisos fueron asignados con éxito');
        }else{
            return redirect()->back()->withErrors(['Debe seleccionar por lo menos un rol']);
        }
    }
    public function revoke(Permission $permission){
        $roles = Role::all();
        foreach ($roles as $role){
            if($role->hasPermissionTo($permission->name)){
                $role->revokePermissionTo($permission->name);
            }
        }
        return redirect()->route('permissions.index')->with('success', 'El permiso fue eliminado de los roles con éxito');
    }



}
