<?php

namespace App\Http\Controllers;

use App\controladoras;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ControladorasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $controladoras = controladoras::orderBy('nombre')->get();
        return view('infrastructure.server.components.controladoras.index', compact('controladoras'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('infrastructure.server.components.controladoras.create');
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
            'name' => 'required|unique:controladoras,nombre',
        ]);
        controladoras::create([
            'nombre' => $request->input('name'),
        ]);
        return redirect()->route('controladoras.index')
            ->with('success','La controladora ha sido creada con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\controladoras  $controladoras
     * @return \Illuminate\Http\Response
     */
    public function show(controladoras $controladoras)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\controladoras  $controladoras
     * @return \Illuminate\Http\Response
     */
    public function edit(controladoras $controladora)
    {
        //
        return view('infrastructure.server.components.controladoras.edit',compact('controladora'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\controladoras  $controladoras
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, controladoras $controladora)
    {
        //
        $this->validate($request, [
            'name' => 'required|unique:controladoras,nombre',
        ]);
        $controladora->update([
            'nombre' => $request->input('name'),
        ]);
        return redirect()->route('controladoras.index')
            ->with('success','La controladora ha sido actualizada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\controladoras  $controladoras
     * @return \Illuminate\Http\Response
     */
    public function destroy(controladoras $controladora)
    {
        //
        $controladora->delete();
        return redirect()->route('controladoras.index')
            ->with('error','La controladora ha sido eliminada con éxito');
    }
}
