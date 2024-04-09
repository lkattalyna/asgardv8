<?php

namespace App\Http\Controllers;

use App\SanNas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SanNasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = SanNas::orderBy('name')->get();
        return view('san.inventories.nas.index',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('san.inventories.nas.create');
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
            'name' => 'required|string|min:1|max:40',
            'mark' => 'required|string|min:1|max:20',
            'model' => 'required|string|min:1|max:35',
            'ip' => 'required|ipv4',
            'serial' => 'required|string|min:1|max:40',
            'code' => 'required|string|min:1|max:20',
            'location' => 'required|string|min:1|max:20',
            'support' => 'required|date',
        ]);
        SanNas::create([
            'name' => $request->input('name'),
            'trademark' => strtoupper($request->input('mark')),
            'model' => strtoupper($request->input('model')),
            'main_ip' => $request->input('ip'),
            'others_ip' => $request->input('other'),
            'location' => $request->input('location'),
            'serial' => $request->input('serial'),
            'code' => $request->input('code'),
            'support_date' => $request->input('support'),
            'owner_id' => Auth::user()->id,
        ]);
        return redirect()->route('sanNas.index')->with('success', 'La NAS ha sido creada con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SanNas  $sanNas
     * @return \Illuminate\Http\Response
     */
    public function show(SanNas $sanNa)
    {
        $sanNas = $sanNa;
        return view('san.inventories.nas.show',compact('sanNas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SanNas  $sanNas
     * @return \Illuminate\Http\Response
     */
    public function edit(SanNas $sanNa)
    {
        $sanNas = $sanNa;
        return view('san.inventories.nas.edit',compact('sanNas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SanNas  $sanNas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SanNas $sanNa)
    {
        $this->validate($request, [
            'name' => 'required|string|min:1|max:40',
            'mark' => 'required|string|min:1|max:20',
            'model' => 'required|string|min:1|max:35',
            'ip' => 'required|ipv4',
            'serial' => 'required|string|min:1|max:40',
            'code' => 'required|string|min:1|max:20',
            'location' => 'required|string|min:1|max:20',
            'support' => 'required|date',
        ]);
        $sanNa->update([
            'name' => $request->input('name'),
            'trademark' => strtoupper($request->input('mark')),
            'model' => strtoupper($request->input('model')),
            'main_ip' => $request->input('ip'),
            'others_ip' => $request->input('other'),
            'location' => $request->input('location'),
            'serial' => $request->input('serial'),
            'code' => $request->input('code'),
            'support_date' => $request->input('support'),
        ]);
        return redirect()->route('sanNas.index')->with('success', 'La NAS ha sido actualizada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SanNas  $sanNas
     * @return \Illuminate\Http\Response
     */
    public function destroy(SanNas $sanNa)
    {
        $sanNa->delete();
        return redirect()->route('sanNas.index')->with('error', 'La NAS ha sido eliminada con éxito');
    }
}
