<?php

namespace App\Http\Controllers;

use App\disco_marcas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiscoMarcasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tipos = disco_marcas::orderBy('nombre')->get();
        return view('infrastructure.server.components.discoMarcas.index', compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('infrastructure.server.components.discoMarcas.create');
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
            'name' => 'required|unique:disco_marcas,nombre|string|max:30|min:1',
        ]);
        disco_marcas::create([
            'nombre' => $request->input('name'),
        ]);
        return redirect()->route('discoMarcas.index')
            ->with('success','La marca de disco ha sido creada con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\disco_marcas  $disco_marcas
     * @return \Illuminate\Http\Response
     */
    public function show(disco_marcas $disco_marcas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\disco_marcas  $disco_marcas
     * @return \Illuminate\Http\Response
     */
    public function edit(disco_marcas $discoMarca)
    {
        //
        return view('infrastructure.server.components.discoMarcas.edit',compact('discoMarca'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\disco_marcas  $disco_marcas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, disco_marcas $discoMarca)
    {
        //
        $this->validate($request, [
            'name' => 'required|unique:disco_marcas,nombre|string|max:30|min:1',
        ]);
        $discoMarca->update([
            'nombre' => $request->input('name'),
        ]);
        return redirect()->route('discoMarcas.index')
            ->with('success','La marca de disco ha sido actualizada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\disco_marcas  $disco_marcas
     * @return \Illuminate\Http\Response
     */
    public function destroy(disco_marcas $discoMarca)
    {
        //
        $discoMarca->delete();
        return redirect()->route('discoMarcas.index')
            ->with('error','La marca de disco ha sido eliminada con éxito');
    }
}
