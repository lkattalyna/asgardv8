<?php

namespace App\Http\Controllers;

use App\memorias;
use App\tipo_memorias;
use App\servers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MemoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(servers $server)
    {
        //
        $tipos = memorias::where('id_servidor', $server->id)->get();
        return view('infrastructure.server.server.servers.hardware.memorias.index', compact('tipos','server'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(servers $server)
    {
        //
        $tipos = tipo_memorias::orderBy('nombre')->get();
        return view('infrastructure.server.server.servers.hardware.memorias.create', compact('tipos', 'server'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, servers $server)
    {
        //
        $this->validate($request, [
            'tipo' => 'required|integer',
            'cantidad' => 'required|integer',
            'capacidad' => 'required',
        ]);
        memorias::create([
            'id_tipo_memoria' => $request->input('tipo'),
            'id_servidor' => $server->id,
            'cantidad' => $request->input('cantidad'),
            'capacidad' => $request->input('capacidad'),
        ]);
        return redirect()->route('memorias.index', $server->id)
            ->with('success','Los datos de la memoria han sido creados con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\memorias  $memorias
     * @return \Illuminate\Http\Response
     */
    public function show(memorias $memorias)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\memorias  $memorias
     * @return \Illuminate\Http\Response
     */
    public function edit(servers $server,memorias $memoria)
    {
        //
        $tipos = tipo_memorias::orderBy('nombre')->get();
        return view('infrastructure.server.server.servers.hardware.memorias.edit',compact('tipos','server','memoria'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\memorias  $memorias
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,servers $server, memorias $memoria)
    {
        //
        $this->validate($request, [
            'tipo' => 'required|integer',
            'cantidad' => 'required|integer',
            'capacidad' => 'required',
        ]);
        $memoria->update([
            'id_tipo_memoria' => $request->input('tipo'),
            'id_servidor' => $server->id,
            'cantidad' => $request->input('cantidad'),
            'capacidad' => $request->input('capacidad'),
        ]);
        return redirect()->route('memorias.index', $server->id)
            ->with('success','Los datos de la memoria han sido actualizados');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\memorias  $memorias
     * @return \Illuminate\Http\Response
     */
    public function destroy(servers $server,memorias $memoria)
    {
        //
        $memoria->delete();
        return redirect()->route('memorias.index', $server->id)
            ->with('error','Los datos de la memoria han sido eliminados con éxito');
    }
}
