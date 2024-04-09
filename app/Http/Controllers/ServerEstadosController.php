<?php

namespace App\Http\Controllers;

use App\server_estados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServerEstadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tipos = server_estados::orderBy('nombre')->get();
        return view('infrastructure.server.components.serverEstados.index', compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('infrastructure.server.components.serverEstados.create');
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
            'name' => 'required|unique:server_estados,nombre|string|min:1|max:30',
        ]);
        server_estados::create([
            'nombre' => $request->input('name'),
        ]);
        return redirect()->route('serverEstados.index')
            ->with('success','El estado de servidor ha sido creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\server_estados  $server_estados
     * @return \Illuminate\Http\Response
     */
    public function show(server_estados $server_estados)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\server_estados  $server_estados
     * @return \Illuminate\Http\Response
     */
    public function edit(server_estados $serverEstado)
    {
        //
        return view('infrastructure.server.components.serverEstados.edit',compact('serverEstado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\server_estados  $server_estados
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, server_estados $serverEstado)
    {
        //
        $this->validate($request, [
            'name' => 'required|string|min:1|max:30',
        ]);
        $serverEstado->update([
            'nombre' => $request->input('name'),
        ]);
        return redirect()->route('serverEstados.index')
            ->with('success','El estado de servidor ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\server_estados  $server_estados
     * @return \Illuminate\Http\Response
     */
    public function destroy(server_estados $serverEstado)
    {
        //
        $serverEstado->delete();
        return redirect()->route('serverEstados.index')
            ->with('error','El estado de servidor ha sido eliminado con éxito');
    }
}
