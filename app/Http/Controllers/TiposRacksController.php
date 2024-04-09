<?php

namespace App\Http\Controllers;

use App\tipos_racks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TiposRacksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tipos = tipos_racks::orderBy('nombre')->get();
        //return $tipos;
        return view('infrastructure.server.components.tiposRacK.index', compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('infrastructure.server.components.tiposRacK.create');
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
            'name' => 'required|unique:tipos_racks,nombre',
        ]);
        tipos_racks::create([
            'nombre' => $request->input('name'),
        ]);
        return redirect()->route('tiposRack.index')
            ->with('success','El tipo de rack ha sido creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\tipos_racks  $tipos_racks
     * @return \Illuminate\Http\Response
     */
    public function show(tipos_racks $tipos_racks)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tipos_racks  $tipos_racks
     * @return \Illuminate\Http\Response
     */
    public function edit(tipos_racks $tiposRack)
    {
        //
        return view('infrastructure.server.components.tiposRack.edit',compact('tiposRack'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tipos_racks  $tipos_racks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tipos_racks $tiposRack)
    {
        //
        $this->validate($request, [
            'name' => 'required|unique:tipos_racks,nombre',
        ]);
        $tiposRack->update([
            'nombre' => $request->input('name'),
        ]);
        return redirect()->route('tiposRack.index')
            ->with('success','El tipo de rack ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tipos_racks  $tipos_racks
     * @return \Illuminate\Http\Response
     */
    public function destroy(tipos_racks $tiposRack)
    {
        //
        $tiposRack->delete();
        return redirect()->route('tiposRack.index')
            ->with('error','El tipo de rack ha sido eliminado con éxito');
    }
}
