<?php

namespace App\Http\Controllers;

use App\propietarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PropietariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $propietarios = propietarios::orderBy('nombre')->get();
        //return view('datos.propietarios.index', compact('propietarios'));
        return view('infrastructure.server.components.propietarios.index', compact('propietarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('infrastructure.server.components.propietarios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'name' => 'required|unique:propietarios,nombre',
        ]);
        propietarios::create([
            'nombre' => $request->input('name'),
        ]);
        return redirect()->route('propietarios.index')
            ->with('success','El propietario ha sido creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\propietarios  $propietarios
     * @return \Illuminate\Http\Response
     */
    public function show(propietarios $propietarios)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\propietarios  $propietarios
     * @return \Illuminate\Http\Response
     */
    public function edit(propietarios $propietario)
    {
        //
        //dd($propietarios);
        return view('infrastructure.server.components.propietarios.edit',compact('propietario'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\propietarios  $propietarios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, propietarios $propietario)
    {
        //
        $this->validate($request, [
            'name' => 'required|unique:propietarios,nombre',
        ]);
        $propietario->update([
            'nombre' => $request->input('name'),
        ]);
        return redirect()->route('propietarios.index')
            ->with('success','El propietario ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\propietarios  $propietarios
     * @return \Illuminate\Http\Response
     */
    public function destroy(propietarios $propietario)
    {
        //
        $propietario->delete();
        return redirect()->route('propietarios.index')
            ->with('error','El propietario ha sido eliminado con éxito');
    }
}
