<?php

namespace App\Http\Controllers;

use App\tipos_clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TiposClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tipos = tipos_clientes::orderBy('nombre')->get();
        return view('infrastructure.server.components.tiposCliente.index', compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('infrastructure.server.components.tiposCliente.create');
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
            'name' => 'required|unique:tipos_clientes,nombre',
        ]);
        tipos_clientes::create([
            'nombre' => $request->input('name'),
        ]);
        return redirect()->route('tiposCliente.index')
            ->with('success','El tipo de cliente ha sido creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\tipos_clientes  $tipos_clientes
     * @return \Illuminate\Http\Response
     */
    public function show(tipos_clientes $tipos_clientes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tipos_clientes  $tipos_clientes
     * @return \Illuminate\Http\Response
     */
    public function edit(tipos_clientes $tiposCliente)
    {
        //
        return view('infrastructure.server.components.tiposCliente.edit',compact('tiposCliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tipos_clientes  $tipos_clientes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tipos_clientes $tiposCliente)
    {
        //
        $this->validate($request, [
            'name' => 'required|unique:tipos_clientes,nombre',
        ]);
        $tiposCliente->update([
            'nombre' => $request->input('name'),
        ]);
        return redirect()->route('tiposCliente.index')
            ->with('success','El tipo de cliente ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tipos_clientes  $tipos_clientes
     * @return \Illuminate\Http\Response
     */
    public function destroy(tipos_clientes $tiposCliente)
    {
        //
        $tiposCliente->delete();
        return redirect()->route('tiposCliente.index')
            ->with('error','El tipo de cliente ha sido eliminado con éxito');
    }
}
