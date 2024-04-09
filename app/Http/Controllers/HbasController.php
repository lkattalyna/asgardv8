<?php

namespace App\Http\Controllers;

use App\hbas;
use App\servers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HbasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(servers $server)
    {
        //
        $tipos = hbas::where('id_servidor', $server->id)->get();
        return view('infrastructure.server.server.servers.hardware.hbas.index', compact('tipos','server'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(servers $server)
    {
        //
        return view('infrastructure.server.server.servers.hardware.hbas.create', compact('server'));
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
            'cantidad' => 'required|integer',
            'puertos' => 'required|integer',
        ]);
        hbas::create([
            'id_servidor' => $server->id,
            'cantidad' => $request->input('cantidad'),
            'puertos' => $request->input('puertos'),
        ]);
        return redirect()->route('hbas.index', $server->id)
            ->with('success','Los datos del HBA han sido creados con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\hbas  $hbas
     * @return \Illuminate\Http\Response
     */
    public function show(hbas $hbas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\hbas  $hbas
     * @return \Illuminate\Http\Response
     */
    public function edit(hbas $hba, servers $server)
    {
        //
        return view('infrastructure.server.server.servers.hardware.hbas.edit',compact('server','hba'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\hbas  $hbas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, hbas $hba, servers $server)
    {
        //
        $this->validate($request, [
            'cantidad' => 'required|integer',
            'puertos' => 'required|integer',
        ]);
        $hba->update([
            'id_servidor' => $server->id,
            'cantidad' => $request->input('cantidad'),
            'puertos' => $request->input('puertos'),
        ]);
        return redirect()->route('hbas.index', $server->id)
            ->with('success','Los datos del HBA han sido actualizados');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\hbas  $hbas
     * @return \Illuminate\Http\Response
     */
    public function destroy(servers $server,hbas $hba)
    {
        //
        $hba->delete();
        return redirect()->route('hbas.index', $server->id)
            ->with('error','Los datos del HBA han sido eliminados con éxito');
    }
}
