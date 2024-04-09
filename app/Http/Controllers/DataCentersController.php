<?php

namespace App\Http\Controllers;

use App\data_centers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DataCentersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $dataCenters = data_centers::orderBy('nombre')->get();
        return view('infrastructure.server.components.dataCenter.index', compact('dataCenters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('infrastructure.server.components.dataCenter.create');
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
            'name' => 'required|unique:data_centers,nombre',
            'location' => 'required|string',
        ]);
        data_centers::create([
            'nombre' => $request->input('name'),
            'ubicacion' => $request->input('location'),
        ]);
        return redirect()->route('dataCenter.index')
            ->with('success','El data center ha sido creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\data_centers  $data_centers
     * @return \Illuminate\Http\Response
     */
    public function show(data_centers $data_centers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\data_centers  $data_centers
     * @return \Illuminate\Http\Response
     */
    public function edit(data_centers $dataCenter)
    {
        //
        return view('infrastructure.server.components.dataCenter.edit',compact('dataCenter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\data_centers  $data_centers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, data_centers $dataCenter)
    {
        //
        $this->validate($request, [
            'name' => 'required|unique:data_centers,nombre',
            'location' => 'required|string',
        ]);
        $dataCenter->update([
            'nombre' => $request->input('name'),
            'ubicacion' => $request->input('location'),
        ]);
        return redirect()->route('dataCenter.index')
            ->with('success','El data center ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\data_centers  $data_centers
     * @return \Illuminate\Http\Response
     */
    public function destroy(data_centers $dataCenter)
    {
        //
        $dataCenter->delete();
        return redirect()->route('dataCenter.index')
            ->with('error','El data center ha sido eliminado con éxito');
    }
}
