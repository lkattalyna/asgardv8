<?php

namespace App\Http\Controllers;

use App\discos;
use App\disco_marcas;
use App\servers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiscosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(servers $server)
    {
        //
        $tipos = discos::where('id_servidor', $server->id)->get();
        return view('infrastructure.server.server.servers.hardware.discos.index', compact('tipos','server'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(servers $server)
    {
        //
        $marcas = disco_marcas::orderBy('nombre')->get();
        return view('infrastructure.server.server.servers.hardware.discos.create', compact('marcas', 'server'));
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
            'marca' => 'required|integer',
            'cantidad' => 'required|integer',
            'capacidad' => 'required',
        ]);
        discos::create([
            'id_disco_marca' => $request->input('marca'),
            'id_servidor' => $server->id,
            'cantidad' => $request->input('cantidad'),
            'capacidad' => $request->input('capacidad'),
        ]);
        return redirect()->route('discos.index', $server->id)
            ->with('success','Los datos del disco han sido creados con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\discos  $discos
     * @return \Illuminate\Http\Response
     */
    public function show(discos $discos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\discos  $discos
     * @return \Illuminate\Http\Response
     */
    public function edit(servers $server, discos $disco)
    {
        //
        $marcas = disco_marcas::orderBy('nombre')->get();
        return view('infrastructure.server.server.servers.hardware.discos.edit',compact('marcas','server','disco'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\discos  $discos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,servers $server, discos $disco)
    {
        //
        $this->validate($request, [
            'marca' => 'required|integer',
            'cantidad' => 'required|integer',
            'capacidad' => 'required',
        ]);
        $disco->update([
            'id_disco_marca' => $request->input('marca'),
            'id_servidor' => $server->id,
            'cantidad' => $request->input('cantidad'),
            'capacidad' => $request->input('capacidad'),
        ]);
        return redirect()->route('discos.index', $server->id)
            ->with('success','Los datos del disco han sido actualizados');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\discos  $discos
     * @return \Illuminate\Http\Response
     */
    public function destroy(servers $server, discos $disco)
    {
        //
        $disco->delete();
        return redirect()->route('discos.index', $server->id)
            ->with('error','Los datos del disco han sido eliminados con éxito');
    }
}
