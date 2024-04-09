<?php

namespace App\Http\Controllers;

use App\Models\ClientesNovedadesBu;
use Illuminate\Http\Request;
use DB;
class ClientesNovedadesBuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sql  = 'select id,nombre,estado,created_at from asgard.clientes_novedades_bus;';
        $clientesNovedades = DB::select($sql);
        return view('novedadesBackup.index',compact('clientesNovedades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('novedadesBackup.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datosCliente = $request->except('_token');
        ClientesNovedadesBu::create([
            'nombre' => $datosCliente['nombre'],
            'estado' => $datosCliente['estado']
        ]);
        return redirect()->route('novedadesBackup.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClientesNovedadesBu  $clientesNovedadesBu
     * @return \Illuminate\Http\Response
     */
    public function show(ClientesNovedadesBu $clientesNovedadesBu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClientesNovedadesBu  $clientesNovedadesBu
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cliente = ClientesNovedadesBu::findOrFail($id);

        return view('novedadesBackup.edit',compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClientesNovedadesBu  $clientesNovedadesBu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $datosCliente = request()->except('_token','_method');
        ClientesNovedadesBu::where('id','=',$id)->update([
            'nombre' => $datosCliente['nombre'],
            'estado' => $datosCliente['estado']
        ]);
        return redirect()->route('novedadesBackup.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClientesNovedadesBu  $clientesNovedadesBu
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ClientesNovedadesBu::destroy($id);
        return redirect()->route('novedadesBackup.index');
    }
}
