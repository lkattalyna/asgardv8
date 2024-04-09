<?php

namespace App\Http\Controllers;

use App\SyncLog;
use App\SanSwitch;
use Illuminate\Http\Request;

class SanSwitchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = SanSwitch::orderBy('fabric')->get(['id','fabric','sw','ip','domain','serial']);
        $log = SyncLog::where('process','sync_san_switches')->latest()->first('created_at');
        if(!$log){
            $log = 'Nunca';
        }else{
            $log = $log->created_at;
        }
        return view('san.inventories.switch.index',compact('items','log'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('san.inventories.switch.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'fabric' => 'required|integer|min:1|max:3',
            'name' => 'required|string|min:1|max:50',
            'ip' => 'required|ipv4',
            'domain' => 'required|integer',
            'serial' => 'required|string|min:1|max:25',
            'code' => 'required|string|min:1|max:20',
            'maker' => 'required|string|min:1|max:20',
            'support' => 'required|date',
        ]);
        SanSwitch::create([
            'fabric' => $request->input('fabric'),
            'sw' => $request->input('name'),
            'ip' => $request->input('ip'),
            'domain' => $request->input('domain'),
            'serial' => $request->input('serial'),
            'code' => $request->input('code'),
            'maker' => $request->input('maker'),
            'support_date' => $request->input('support'),
            'owner_id' => Auth::user()->id,
        ]);
        return redirect()->route('sanSwitch.index')->with('success', 'El switch ha sido creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SanSwitch  $sanSwitch
     * @return \Illuminate\Http\Response
     */
    public function show(SanSwitch $sanSwitch)
    {
        return view('san.inventories.switch.show',compact('sanSwitch'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SanSwitch  $sanSwitch
     * @return \Illuminate\Http\Response
     */
    public function edit(SanSwitch $sanSwitch)
    {
        return view('san.inventories.switch.edit',compact('sanSwitch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SanSwitch  $sanSwitch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SanSwitch $sanSwitch)
    {
        $this->validate($request, [
            'code' => 'required|string|min:1|max:20',
            'maker' => 'required|string|min:1|max:20',
            'model' => 'required|string|min:1|max:20',
            'support' => 'required|date',
        ]);
        $sanSwitch->update([
            'code' => $request->input('code'),
            'maker' => $request->input('maker'),
            'model' => $request->input('model'),
            'support_date' => $request->input('support'),
        ]);
        return redirect()->route('sanSwitch.index')->with('success', 'El switch ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SanSwitch  $sanSwitch
     * @return \Illuminate\Http\Response
     */
    public function destroy(SanSwitch $sanSwitch)
    {
        $sanSwitch->delete();
        return redirect()->route('sanSwitch.index')->with('error', 'El switch ha sido eliminado con éxito');
    }
}
