<?php

namespace App\Http\Controllers;

use App\server_marcas;
use App\server_modelos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServerModelosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $modelos = server_modelos::orderBy('modelo')->get();
        //dd($modelos);
        return view('infrastructure.server.server.modelos.index', compact('modelos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $marcas = server_marcas::orderBy('nombre')->get();
        $tipos = server_modelos::distinct('tipo')->get('tipo');
        return view('infrastructure.server.server.modelos.create', compact('marcas','tipos'));
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
            'tipo' => 'required|string',
            'modelo' => 'required|unique:server_modelos,modelo',
            'gen' => 'required|string',
        ]);
        server_modelos::create([
            'tipo' => $request->input('tipo'),
            'modelo' => $request->input('modelo'),
            'generacion' => $request->input('gen'),
            'id_server_marca' => $request->input('marca')
        ]);
        return redirect()->route('modelos.index')
            ->with('success','El modelo ha sido creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\server_modelos  $server_modelos
     * @return \Illuminate\Http\Response
     */
    public function show(server_modelos $serverModelo)
    {
        //
        return view('infrastructure.server.server.modelos.edit',compact('serverModelo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\server_modelos  $server_modelos
     * @return \Illuminate\Http\Response
     */
    public function edit(server_modelos $serverModelo)
    {
        //
        $marcas = server_marcas::orderBy('nombre')->get();
        $tipos = server_modelos::distinct('tipo')->get('tipo');
        return view('infrastructure.server.server.modelos.edit',compact('serverModelo','marcas','tipos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\server_modelos  $server_modelos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, server_modelos $serverModelo)
    {
        //
        $this->validate($request, [
            'tipo' => 'required|string',
            'modelo' => 'required|unique:server_modelos,modelo',
            'gen' => 'required|string',
        ]);
        $serverModelo->update([
            'tipo' => $request->input('tipo'),
            'modelo' => $request->input('modelo'),
            'generacion' => $request->input('gen'),
            'id_server_marca' => $request->input('marca')
        ]);
        return redirect()->route('modelos.index')
            ->with('success','El modelo ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\server_modelos  $server_modelos
     * @return \Illuminate\Http\Response
     */
    public function destroy(server_modelos $serverModelo)
    {
        //
        $serverModelo->delete();
        return redirect()->route('modelos.index')
            ->with('error','El modelo ha sido eliminado con éxito');
    }
    public function getModelos($id){
        return server_modelos::where('id_server_marca','=',$id)->get();
    }
}
