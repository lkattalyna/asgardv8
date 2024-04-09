<?php

namespace App\Http\Controllers;

use App\RegQuarter;
use Illuminate\Http\Request;

class RegQuarterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $quarters = RegQuarter::all();
        return view('improvements.RegQuarters.index', compact('quarters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('improvements.RegQuarters.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:1|max:20',
            'start' => 'required|date',
            'end' => 'required|date',
        ]);
        RegQuarter::create([
            'name' => $request->input('name'),
            'start_date' => $request->input('start'),
            'end_date' => $request->input('end'),
        ]);
        return redirect()->route('RegQuarters.index')->with('success', 'El periodo ha sido creado con éxito');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RegQuarter  $regQuarter
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(RegQuarter $RegQuarter)
    {
        return view('improvements.RegQuarters.edit', compact('RegQuarter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RegQuarter  $regQuarter
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, RegQuarter $RegQuarter)
    {
        $this->validate($request, [
            'name' => 'required|min:1|max:20',
            'start' => 'required|date',
            'end' => 'required|date',
        ]);
        $RegQuarter->update([
            'name' => $request->input('name'),
            'start_date' => $request->input('start'),
            'end_date' => $request->input('end'),
        ]);
        return redirect()->route('RegQuarters.index')->with('success', 'El periodo ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RegQuarter  $regQuarter
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(RegQuarter $RegQuarter)
    {
        $RegQuarter->delete();
        return redirect()->route('RegQuarters.index')->with('error', 'El periodo ha sido eliminado con éxito');
    }
}
