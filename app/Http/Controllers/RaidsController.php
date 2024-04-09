<?php

namespace App\Http\Controllers;

use App\raids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RaidsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $raids = raids::orderBy('tipo')->get();
        return view('infrastructure.server.components.raids.index', compact('raids'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('infrastructure.server.components.raids.create');
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
            'name' => 'required|unique:raids,tipo',
        ]);
        raids::create([
            'tipo' => $request->input('name'),
        ]);
        return redirect()->route('raids.index')
            ->with('success','El tipo de raid ha sido creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\raids  $raids
     * @return \Illuminate\Http\Response
     */
    public function show(raids $raids)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\raids  $raids
     * @return \Illuminate\Http\Response
     */
    public function edit(raids $raid)
    {
        //
        return view('infrastructure.server.components.raids.edit',compact('raid'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\raids  $raids
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, raids $raid)
    {
        //
        $this->validate($request, [
            'name' => 'required|unique:raids,tipo',
        ]);
        $raid->update([
            'tipo' => $request->input('name'),
        ]);
        return redirect()->route('raids.index')
            ->with('success','El tipo de raid ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\raids  $raids
     * @return \Illuminate\Http\Response
     */
    public function destroy(raids $raid)
    {
        //
        $raid->delete();
        return redirect()->route('raids.index')
            ->with('error','El tipo de raid ha sido eliminado con éxito');
    }
}
