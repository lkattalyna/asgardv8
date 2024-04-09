<?php

namespace App\Http\Controllers;

use App\tipos_hardware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TiposHardwareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tipos = tipos_hardware::orderBy('nombre')->get();
        return view('infrastructure.server.components.tiposHardware.index', compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('infrastructure.server.components.tiposHardware.create');
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
        $admin = new tipos_hardware();
        //dd($admin);
        $this->validate($request, [
            'name' => 'required|unique:tipos_hardware,nombre',
        ]);
        tipos_hardware::create([
            'nombre' => $request->input('name'),
        ]);
        return redirect()->route('tiposHardware.index')
            ->with('success','El tipo de hardware ha sido creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\tipos_hardware  $tipos_hardware
     * @return \Illuminate\Http\Response
     */
    public function show(tipos_hardware $tipos_hardware)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tipos_hardware  $tipos_hardware
     * @return \Illuminate\Http\Response
     */
    public function edit(tipos_hardware $tiposHardware)
    {
        //
        return view('infrastructure.server.components.tiposHardware.edit',compact('tiposHardware'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tipos_hardware  $tipos_hardware
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tipos_hardware $tiposHardware)
    {
        //
        $this->validate($request, [
            'name' => 'required|unique:tipos_hardware,nombre',
        ]);
        $tiposHardware->update([
            'nombre' => $request->input('name'),
        ]);
        return redirect()->route('tiposHardware.index')
            ->with('success','El tipo de hardware ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tipos_hardware  $tipos_hardware
     * @return \Illuminate\Http\Response
     */
    public function destroy(tipos_hardware $tiposHardware)
    {
        //
        $tiposHardware->delete();
        return redirect()->route('tiposHardware.index')
            ->with('error','El tipo de hardware ha sido eliminado con éxito');
    }
}
