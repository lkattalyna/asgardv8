<?php

namespace App\Http\Controllers;

use App\cpu_marcas;
use App\cpu_modelos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CpuModelosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tipos = cpu_modelos::orderBy('nombre')->get();
        return view('infrastructure.server.components.cpuModelos.index', compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $marcas = cpu_marcas::orderBy('nombre')->get();
        return view('infrastructure.server.components.cpuModelos.create', compact('marcas'));
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
            'name' => 'required|string|max:50|min:1',
            'marca' => 'required|integer',
        ]);
        cpu_modelos::create([
            'nombre' => $request->input('name'),
            'id_cpu_marca' => $request->input('marca'),
        ]);
        return redirect()->route('cpuModelos.index')
            ->with('success','El modelo de cpu ha sido creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\cpu_modelos  $cpu_modelos
     * @return \Illuminate\Http\Response
     */
    public function show(cpu_modelos $cpu_modelos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\cpu_modelos  $cpu_modelos
     * @return \Illuminate\Http\Response
     */
    public function edit(cpu_modelos $cpuModelo)
    {
        //
        $marcas = cpu_marcas::orderBy('nombre')->get();
        return view('infrastructure.server.components.cpuModelos.edit',compact('cpuModelo', 'marcas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\cpu_modelos  $cpu_modelos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cpu_modelos $cpuModelo)
    {
        //
        $this->validate($request, [
            'name' => 'required|string|max:50|min:1',
            'marca' => 'required|integer',
        ]);
        $cpuModelo->update([
            'nombre' => $request->input('name'),
            'id_cpu_marca' => $request->input('marca'),
        ]);
        return redirect()->route('cpuModelos.index')
            ->with('success','El modelo de cpu ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\cpu_modelos  $cpu_modelos
     * @return \Illuminate\Http\Response
     */
    public function destroy(cpu_modelos $cpuModelo)
    {
        //
        $cpuModelo->delete();
        return redirect()->route('cpuModelos.index')
            ->with('error','El modelo de cpu ha sido eliminado con éxito');
    }

}
