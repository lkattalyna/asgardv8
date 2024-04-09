<?php

namespace App\Http\Controllers;

use App\OsGroup;
use Illuminate\Http\Request;

class OsGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grupos = OsGroup::all();
        return view('osGroups.index', compact('grupos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('osGroups.create');
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
            'name' => 'required|min:1|max:120',
            'flag' => 'required|integer',
            'show' => 'required|string|min:1|max:20',
        ]);
        OsGroup::create([
            'name' => $request->name,
            'flag' => $request->flag,
            'show_to' => $request->input('show'),
        ]);
        return redirect()->route('osGroups.index')->with('success', 'El grupo ha sido creado con éxito');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OsGroup  $osGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(OsGroup $osGroup)
    {
        return view('osGroups.edit', compact('osGroup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OsGroup  $osGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OsGroup $osGroup)
    {
        $this->validate($request, [
            'name' => 'required|min:1|max:120',
            'flag' => 'required|integer',
            'show' => 'required|string|min:1|max:20',
        ]);
        $osGroup->update([
            'name' => $request->name,
            'flag' => $request->flag,
            'show_to' => $request->input('show'),
        ]);
        return redirect()->route('osGroups.index')->with('success', 'El grupo a sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OsGroup  $osGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(OsGroup $osGroup)
    {
        $osGroup->delete();
        return redirect()->route('osGroups.index')->with('error', 'El grupo ha sido eliminado con éxito');
    }
}
