<?php

namespace App\Http\Controllers;

use App\nic_referencias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NicReferenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tipos = nic_referencias::orderBy('nombre')->get();
        return view('infrastructure.server.components.nicReferencias.index', compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('infrastructure.server.components.nicReferencias.create');
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
            'name' => 'required|unique:nic_referencias,nombre|string|max:60|min:1',
        ]);
        nic_referencias::create([
            'nombre' => $request->input('name'),
        ]);
        return redirect()->route('nicReferencias.index')
            ->with('success','La referencia de NIC ha sido creada con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\nic_referencias  $nic_referencias
     * @return \Illuminate\Http\Response
     */
    public function show(nic_referencias $nic_referencias)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\nic_referencias  $nic_referencias
     * @return \Illuminate\Http\Response
     */
    public function edit(nic_referencias $nicReferencia)
    {
        //
        return view('infrastructure.server.components.nicReferencias.edit',compact('nicReferencia'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\nic_referencias  $nic_referencias
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, nic_referencias $nicReferencia)
    {
        //
        $this->validate($request, [
            'name' => 'required|unique:nic_referencias,nombre|string|max:60|min:1',
        ]);
        $nicReferencia->update([
            'nombre' => $request->input('name'),
        ]);
        return redirect()->route('nicReferencias.index')
            ->with('success','La referencia de NIC ha sido actualizada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\nic_referencias  $nic_referencias
     * @return \Illuminate\Http\Response
     */
    public function destroy(nic_referencias $nicReferencia)
    {
        //
        $nicReferencia->delete();
        return redirect()->route('nicReferencias.index')
            ->with('error','La referencia de NIC ha sido eliminada con éxito');
    }
}
