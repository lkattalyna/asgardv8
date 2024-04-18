<?php

namespace App\Http\Controllers;

use App\vcostumer;
use Illuminate\Http\Request;
use App\Models\Cliente;
class VcostumerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $vcostumer = vcostumer::all();
        return view('vcostumer.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vcostumer.create');
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'customerName' => 'required|string|max:255',
            'customerNIT' => 'required|string|max:255',
            'customerState' => 'required|string|max:255',
        ]);

        // Crear un nuevo cliente
        $cliente = new Cliente();
        $cliente->nombre = $request->input('customerName');
        $cliente->nit = $request->input('customerNIT');
        $cliente->estado = $request->input('customerState');
        // Puedes agregar más campos según sea necesario

        // Guardar el cliente en la base de datos
        $cliente->save();

        // Redireccionar a alguna página después de guardar el cliente
        return redirect()->route('initiative.index')->with('success', 'Cliente registrado exitosamente');
    }
    public function edit(Request $request)
    {
        // //
        // //dd($vcenter);
        
        // return view('vcostumer.edit',compact('vcostumer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\vcostumer  $vcostumer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // //
        // $this->validate($request, [
        //     'segment' => 'required',
        //     'login' => 'required',
        //     'ip' => 'required',
        //     'alias' => 'required',
        //     'status' => 'required',
        // ]);
        // $vcostumer->update([
        //     'fk_segmentID' => $request->segment,
        //     'fk_loginAccountID' => $request->login,
        //     'vcenterIp' => $request->ip,
        //     'vcenterAlias' => $request->alias,
        //     'vcenterStatus' => $request->status,
        // ]);
        // return redirect()->route('vcostumer.index')->with('success', 'El vcenter ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\vcostumer  $vcostumer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // //
        // $vcostumer->delete();
        // return redirect()->route('vcostumer.index')
        //     ->with('error','El vcenter ha sido eliminado con éxito');
    }
}
