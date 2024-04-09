<?php

namespace App\Http\Controllers;

use App\DevState;
use Illuminate\Http\Request;

class DevStateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $states = DevState::all();
        return view('dev.states.index',compact('states'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('dev.states.create');
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
            'name' => 'required|string|max:100|min:1',
        ]);
        if($request->description == ''){
            $desc = 'N/A';
        } else {
            $desc = $request->description;
        }
        DevState::create([
            'name' => $request->name,
            'description' => $desc,
        ]);
        return redirect()->route('devStates.index')->with('success', 'El estado ha sido creado con éxito');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DevState  $devState
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(DevState $devState)
    {
        return view('dev.states.edit',compact('devState'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DevState  $devState
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, DevState $devState)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100|min:1',
        ]);
        if($request->description == ''){
            $desc = 'N/A';
        } else {
            $desc = $request->description;
        }
        $devState->update([
            'name' => $request->name,
            'description' => $desc,
        ]);
        return redirect()->route('devStates.index')->with('success', 'El estado ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DevState  $devState
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DevState $devState)
    {
        $devState->delete();
        return redirect()->route('devStates.index')->with('error', 'El estado ha sido eliminado con éxito');
    }
}
