<?php

namespace App\Http\Controllers;

use App\tipos_servicios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TiposServiciosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tipos = tipos_servicios::orderBy('nombre')->get();
        return view('infrastructure.server.components.tiposServicio.index', compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('infrastructure.server.components.tiposServicio.create');
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
            'name' => 'required|unique:tipos_servicios,nombre',
        ]);
        tipos_servicios::create([
            'nombre' => $request->input('name'),
        ]);
        return redirect()->route('tiposServicio.index')
            ->with('success','El tipo de servicio ha sido creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\tipos_servicios  $tipos_servicios
     * @return \Illuminate\Http\Response
     */
    public function show(tipos_servicios $tipos_servicios)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tipos_servicios  $tipos_servicios
     * @return \Illuminate\Http\Response
     */
    public function edit(tipos_servicios $tiposServicio)
    {
        //
        return view('infrastructure.server.components.tiposServicio.edit',compact('tiposServicio'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tipos_servicios  $tipos_servicios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tipos_servicios $tiposServicio)
    {
        //
        $this->validate($request, [
            'name' => 'required|unique:tipos_servicios,nombre',
        ]);
        $tiposServicio->update([
            'nombre' => $request->input('name'),
        ]);
        return redirect()->route('tiposServicio.index')
            ->with('success','El tipo de servicio ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tipos_servicios  $tipos_servicios
     * @return \Illuminate\Http\Response
     */
    public function destroy(tipos_servicios $tiposServicio)
    {
        //
        $tiposServicio->delete();
        return redirect()->route('tiposServicio.index')
            ->with('error','El tipo de servicio ha sido eliminado con éxito');
    }
}
