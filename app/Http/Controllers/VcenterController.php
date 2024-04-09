<?php

namespace App\Http\Controllers;

use App\Vcenter;
use Illuminate\Http\Request;

class VcenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $vcenters = Vcenter::all();
        return view('vcenters.index',compact('vcenters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $segmentos = Vcenter::distinct('fk_segmentID')->get('fk_segmentID');
        $logins = Vcenter::distinct('fk_loginAccountID')->get('fk_loginAccountID');

        //dd($segmento);
        return view('vcenters.create',compact('segmentos','logins'));
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
            'segment' => 'required',
            'login' => 'required',
            'ip' => 'required',
            'alias' => 'required',
            'status' => 'required',
        ]);
        //dd($request->login);
        Vcenter::create([
            'fk_segmentID' => $request->segment,
            'fk_loginAccountID' => $request->login,
            'vcenterIp' => $request->ip,
            'vcenterAlias' => $request->alias,
            'vcenterStatus' => $request->status,
        ]);
        return redirect()->route('vcenters.index')->with('success', 'El vcenter ha sido creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vcenter  $vcenter
     * @return \Illuminate\Http\Response
     */
    public function show(Vcenter $vcenter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vcenter  $vcenter
     * @return \Illuminate\Http\Response
     */
    public function edit(Vcenter $vcenter)
    {
        //
        //dd($vcenter);
        
        return view('vcenters.edit',compact('vcenter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vcenter  $vcenter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vcenter $vcenter)
    {
        //
        $this->validate($request, [
            'segment' => 'required',
            'login' => 'required',
            'ip' => 'required',
            'alias' => 'required',
            'status' => 'required',
        ]);
        $vcenter->update([
            'fk_segmentID' => $request->segment,
            'fk_loginAccountID' => $request->login,
            'vcenterIp' => $request->ip,
            'vcenterAlias' => $request->alias,
            'vcenterStatus' => $request->status,
        ]);
        return redirect()->route('vcenters.index')->with('success', 'El vcenter ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vcenter  $vcenter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vcenter $vcenter)
    {
        //
        $vcenter->delete();
        return redirect()->route('vcenters.index')
            ->with('error','El vcenter ha sido eliminado con éxito');
    }
}
