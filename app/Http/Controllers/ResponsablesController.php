<?php

namespace App\Http\Controllers;

use App\responsables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResponsablesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $responsables = Responsables::orderBy('nombre')->get();
        return view('infrastructure.server.components.responsables.index', compact('responsables'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('infrastructure.server.components.responsables.create');
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
            'name' => 'required|unique:responsables,nombre',
        ]);
        Responsables::create([
            'nombre' => $request->input('name'),
        ]);
        return redirect()->route('responsables.index')
            ->with('success','El responsable ha sido creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\responsables  $responsables
     * @return \Illuminate\Http\Response
     */
    public function show(responsables $responsables)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\responsables  $responsables
     * @return \Illuminate\Http\Response
     */
    public function edit(responsables $responsable)
    {
        //
        return view('infrastructure.server.components.responsables.edit',compact('responsable'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\responsables  $responsables
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, responsables $responsable)
    {
        //
        $this->validate($request, [
            'name' => 'required|unique:responsables,nombre',
        ]);
        $responsable->update([
            'nombre' => $request->input('name'),
        ]);
        return redirect()->route('responsables.index')
            ->with('success','El responsable ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\responsables  $responsables
     * @return \Illuminate\Http\Response
     */
    public function destroy(responsables $responsable)
    {
        //
        $responsable->delete();
        //dd($responsable);
        return redirect()->route('responsables.index')
            ->with('error','El responsable ha sido eliminado con éxito');
    }
}
