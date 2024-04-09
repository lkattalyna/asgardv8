<?php

namespace App\Http\Controllers;

use App\cpu_marcas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CpuMarcasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tipos = cpu_marcas::orderBy('nombre')->get();
        return view('infrastructure.server.components.cpuMarcas.index', compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('infrastructure.server.components.cpuMarcas.create');
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
            'name' => 'required|unique:cpu_marcas,nombre|max:50|min:1',
        ]);
        cpu_marcas::create([
            'nombre' => $request->input('name'),
        ]);
        return redirect()->route('cpuMarcas.index')
            ->with('success','La marca de cpu ha sido creada con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\cpu_marcas  $cpu_marcas
     * @return \Illuminate\Http\Response
     */
    public function show(cpu_marcas $cpu_marcas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\cpu_marcas  $cpu_marcas
     * @return \Illuminate\Http\Response
     */
    public function edit(cpu_marcas $cpuMarca)
    {
        //
        return view('infrastructure.server.components.cpuMarcas.edit',compact('cpuMarca'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\cpu_marcas  $cpu_marcas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cpu_marcas $cpuMarca)
    {
        //
        $this->validate($request, [
            'name' => 'required|unique:cpu_marcas,nombre|max:50|min:1',
        ]);
        $cpuMarca->update([
            'nombre' => $request->input('name'),
        ]);
        return redirect()->route('cpuMarcas.index')
            ->with('success','La marca de cpu ha sido actualizada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\cpu_marcas  $cpu_marcas
     * @return \Illuminate\Http\Response
     */
    public function destroy(cpu_marcas $cpuMarca)
    {
        //
        $cpuMarca->delete();
        return redirect()->route('cpuMarcas.index')
            ->with('error','La marca de cpu ha sido eliminada con éxito');
    }
}
