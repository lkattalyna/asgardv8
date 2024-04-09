<?php

namespace App\Http\Controllers;

use App\cpus;
use App\cpu_modelos;
use App\servers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CpusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(servers $server)
    {
        //
        $tipos = cpus::where('id_servidor', $server->id)->get();
        return view('infrastructure.server.server.servers.hardware.cpus.index', compact('tipos','server'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(servers $server)
    {
        //
        $modelos = cpu_modelos::orderBy('nombre')->get();
        return view('infrastructure.server.server.servers.hardware.cpus.create', compact('modelos', 'server'));
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
            'modelo' => 'required|integer',
            'cantidad' => 'required|integer',
        ]);
        cpus::create([
            'id_cpu_modelo' => $request->input('modelo'),
            'id_servidor' => $server->id,
            'cantidad' => $request->input('cantidad'),
            'observacion' => $request->input('observacion'),
        ]);
        return redirect()->route('cpus.index', $server->id)
            ->with('success','Los datos de la CPU han sido creados con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\cpus  $cpus
     * @return \Illuminate\Http\Response
     */
    public function show(cpus $cpus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\cpus  $cpus
     * @return \Illuminate\Http\Response
     */
    public function edit(cpus $cpu, servers $server)
    {
        //
        $modelos = cpu_modelos::orderBy('nombre')->get();
        return view('infrastructure.server.server.servers.hardware.cpus.edit',compact('modelos','server','cpu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\cpus  $cpus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cpus $cpu, servers $server)
    {
        //
        $this->validate($request, [
            'modelo' => 'required|integer',
            'cantidad' => 'required|integer',
        ]);
        $cpu->update([
            'id_cpu_modelo' => $request->input('modelo'),
            'id_servidor' => $server->id,
            'cantidad' => $request->input('cantidad'),
            'observacion' => $request->input('observacion'),
        ]);
        return redirect()->route('cpus.index', $server->id)
            ->with('success','Los datos de la CPU han sido actualizados');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\cpus  $cpus
     * @return \Illuminate\Http\Response
     */
    public function destroy(servers $server,cpus $cpu)
    {
        //
        $cpu->delete();
        return redirect()->route('cpus.index', $server->id)
            ->with('error','Los datos de la CPU han sido eliminados con éxito');
    }
}
