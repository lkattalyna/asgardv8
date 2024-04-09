<?php

namespace App\Http\Controllers;

use App\tipo_memorias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TipoMemoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tipos = tipo_memorias::orderBy('nombre')->get();
        return view('infrastructure.server.components.tipoMemorias.index', compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('infrastructure.server.components.tipoMemorias.create');
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
            'name' => 'required|unique:tipo_memorias,nombre|max:30|min:1',
        ]);
        tipo_memorias::create([
            'nombre' => $request->input('name'),
        ]);
        return redirect()->route('tipoMemorias.index')
            ->with('success','El tipo de memoria ha sido creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\tipo_memorias  $tipo_memorias
     * @return \Illuminate\Http\Response
     */
    public function show(tipo_memorias $tipo_memorias)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tipo_memorias  $tipo_memorias
     * @return \Illuminate\Http\Response
     */
    public function edit(tipo_memorias $tipoMemoria)
    {
        //
        return view('infrastructure.server.components.tipoMemorias.edit',compact('tipoMemoria'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tipo_memorias  $tipo_memorias
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tipo_memorias $tipoMemoria)
    {
        //
        $this->validate($request, [
            'name' => 'required|unique:tipo_memorias,nombre|max:30|min:1',
        ]);
        $tipoMemoria->update([
            'nombre' => $request->input('name'),
        ]);
        return redirect()->route('tipoMemorias.index')
            ->with('success','El tipo de memoria ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tipo_memorias  $tipo_memorias
     * @return \Illuminate\Http\Response
     */
    public function destroy(tipo_memorias $tipoMemoria)
    {
        //
        $tipoMemoria->delete();
        return redirect()->route('tipoMemorias.index')
            ->with('error','El tipo de memoria ha sido eliminado con éxito');
    }
}
