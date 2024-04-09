<?php

namespace App\Http\Controllers;

use App\sistema_operativos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SistemaOperativosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $sos= sistema_operativos::orderBy('nombre')->get();
        return view('infrastructure.server.components.sistemaOperativo.index', compact('sos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('infrastructure.server.components.sistemaOperativo.create');
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
            'name' => 'required|unique:sistema_operativos,nombre',
        ]);
        sistema_operativos::create([
            'nombre' => $request->input('name'),
        ]);
        return redirect()->route('sistemaOperativo.index')
            ->with('success','El sistema operativo ha sido creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\sistema_operativos  $sistema_operativos
     * @return \Illuminate\Http\Response
     */
    public function show(sistema_operativos $sistema_operativos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\sistema_operativos  $sistema_operativos
     * @return \Illuminate\Http\Response
     */
    public function edit(sistema_operativos $sistemaOperativo)
    {
        //
        return view('infrastructure.server.components.sistemaOperativo.edit',compact('sistemaOperativo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\sistema_operativos  $sistema_operativos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, sistema_operativos $sistemaOperativo)
    {
        //
        $this->validate($request, [
            'name' => 'required|unique:sistema_operativos,nombre',
        ]);
        $sistemaOperativo->update([
            'nombre' => $request->input('name'),
        ]);
        return redirect()->route('sistemaOperativo.index')
            ->with('success','El sistema operativo ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\sistema_operativos  $sistema_operativos
     * @return \Illuminate\Http\Response
     */
    public function destroy(sistema_operativos $sistemaOperativo)
    {
        //
        $sistemaOperativo->delete();
        return redirect()->route('sistemaOperativo.index')
            ->with('error','El sistema operativo ha sido eliminado con éxito');
    }
}
