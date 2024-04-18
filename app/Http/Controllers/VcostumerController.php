<?php

namespace App\Http\Controllers;

use App\vcostumer;
use Illuminate\Http\Request;

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
        // //
        // $segmentos = vcostumer::distinct('fk_segmentID')->get('fk_segmentID');
        // $logins = vcostumer::distinct('fk_loginAccountID')->get('fk_loginAccountID');

        //dd($segmento);
        // return view('vcostumer.create',compact('segmentos','logins'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // //
        // $this->validate($request, [
        //     'segment' => 'required',
        //     'login' => 'required',
        //     'ip' => 'required',
        //     'alias' => 'required',
        //     'status' => 'required',
        // ]);
        // //dd($request->login);
        // vcostumer::create([
        //     'fk_segmentID' => $request->segment,
        //     'fk_loginAccountID' => $request->login,
        //     'vcenterIp' => $request->ip,
        //     'vcenterAlias' => $request->alias,
        //     'vcenterStatus' => $request->status,
        // ]);
        // return redirect()->route('vcostumer.index')->with('success', 'El vcenter ha sido creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\vcostumer  $vcostumer
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\vcostumer  $vcostumer
     * @return \Illuminate\Http\Response
     */
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
