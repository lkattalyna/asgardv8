<?php

namespace App\Http\Controllers;

use App\clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $clientes = clientes::orderBy('nombre')->get();
        return view('infrastructure.server.components.clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('infrastructure.server.components.clientes.create');
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
            'name' => 'required|unique:clientes,nombre',
        ]);
        clientes::create([
            'nombre' => $request->input('name'),
        ]);
        return redirect()->route('clientes.index')
            ->with('success','El cliente ha sido creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function show(clientes $clientes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function edit(clientes $cliente)
    {
        //
        return view('infrastructure.server.components.clientes.edit',compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, clientes $cliente)
    {
        //
        $this->validate($request, [
            'name' => 'required|unique:clientes,nombre',
        ]);
        $cliente->update([
            'nombre' => $request->input('name'),
        ]);
        return redirect()->route('clientes.index')
            ->with('success','El cliente ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function destroy(clientes $cliente)
    {
        //
        $cliente->delete();
        return redirect()->route('clientes.index')
            ->with('error','El cliente ha sido eliminado con éxito');
    }
}
