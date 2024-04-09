<?php

namespace App\Http\Controllers;

use App\server_marcas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServerMarcasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $marcas = server_marcas::orderBy('nombre')->get();
        return view('infrastructure.server.server.marcas.index', compact('marcas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('infrastructure.server.server.marcas.create');
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
            'name' => 'required|unique:server_marcas,nombre',
        ]);
        server_marcas::create([
            'nombre' => $request->input('name'),
        ]);
        return redirect()->route('marcas.index')
            ->with('success','La marca ha sido creada con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\server_marcas  $server_marcas
     * @return \Illuminate\Http\Response
     */
    public function show(server_marcas $server_marcas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\server_marcas  $server_marcas
     * @return \Illuminate\Http\Response
     */
    public function edit(server_marcas $serverMarca)
    {
        //
        return view('infrastructure.server.server.marcas.edit',compact('serverMarca'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\server_marcas  $server_marcas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, server_marcas $serverMarca)
    {
        //
        $this->validate($request, [
            'name' => 'required|unique:server_marcas,nombre',
        ]);
        $serverMarca->update([
            'nombre' => $request->input('name'),
        ]);
        return redirect()->route('marcas.index')
            ->with('success','La marca ha sido actualizada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\server_marcas  $server_marcas
     * @return \Illuminate\Http\Response
     */
    public function destroy(server_marcas $serverMarca)
    {
        //
        $serverMarca->delete();
        return redirect()->route('marcas.index')
            ->with('error','La marca ha sido eliminada con éxito');
    }
}
