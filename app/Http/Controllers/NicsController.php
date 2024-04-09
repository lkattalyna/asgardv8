<?php

namespace App\Http\Controllers;

use App\nics;
use App\nic_referencias;
use App\servers;
use illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NicsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(servers $server)
    {
        //
        $tipos = nics::where('id_servidor', $server->id)->get();
        return view('infrastructure.server.server.servers.hardware.nics.index', compact('tipos','server'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(servers $server)
    {
        //
        $referencias = nic_referencias::orderBy('nombre')->get();
        return view('infrastructure.server.server.servers.hardware.nics.create', compact('referencias', 'server'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,servers $server)
    {
        //
        $this->validate($request, [
            'referencia' => 'required|integer',
            'cantidad' => 'required|integer',
            'puertos' => 'required|integer',
        ]);
        nics::create([
            'id_nic_ref' => $request->input('referencia'),
            'id_servidor' => $server->id,
            'cantidad' => $request->input('cantidad'),
            'puertos' => $request->input('puertos'),
        ]);
        return redirect()->route('nics.index', $server->id)
            ->with('success','Los datos de la NIC han sido creados con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\nics  $nics
     * @return \Illuminate\Http\Response
     */
    public function show(nics $nics)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\nics  $nics
     * @return \Illuminate\Http\Response
     */
    public function edit(servers $server, nics $nic)
    {
        //
        $referencias = nic_referencias::orderBy('nombre')->get();
        return view('infrastructure.server.server.servers.hardware.nics.edit',compact('referencias','server','nic'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\nics  $nics
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, nics $nic, servers $server)
    {
        //
        $this->validate($request, [
            'referencia' => 'required|integer',
            'cantidad' => 'required|integer',
            'puertos' => 'required|integer',
        ]);
        $nic->update([
            'id_nic_ref' => $request->input('referencia'),
            'id_servidor' => $server->id,
            'cantidad' => $request->input('cantidad'),
            'puertos' => $request->input('puertos'),
        ]);
        return redirect()->route('nics.index', $server->id)
            ->with('success','Los datos de la NIC han sido actualizados');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\nics  $nics
     * @return \Illuminate\Http\Response
     */
    public function destroy(servers $server, nics $nic)
    {
        //
        $nic->delete();
        return redirect()->route('nics.index', $server->id)
            ->with('error','Los datos de la NIC han sido eliminados con éxito');
    }
}
