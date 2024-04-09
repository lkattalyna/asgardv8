<?php

namespace App\Http\Controllers;

use App\RegServiceSegment;
use App\User;
use Illuminate\Http\Request;

class RegServiceSegmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $segments = RegServiceSegment::all();
        return view('improvements.RegServiceSegments.index', compact('segments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('improvements.RegServiceSegments.create',compact('users'));
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
            'name' => 'required|min:1|max:50',
            'coordinator' => 'required|integer',
        ]);
        RegServiceSegment::create([
            'name' => $request->name,
            'coordinator_id' => $request->coordinator,
        ]);
        return redirect()->route('RegServiceSegments.index')->with('success', 'El segmento de servicio ha sido creado con éxito');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RegServiceSegment  $RegServiceSegment
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(RegServiceSegment $RegServiceSegment)
    {
        $users = User::orderBy('name')->get();
        return view('improvements.RegServiceSegments.edit', compact('RegServiceSegment','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RegServiceSegment  $RegServiceSegment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, RegServiceSegment $RegServiceSegment)
    {
        $this->validate($request, [
            'name' => 'required|min:1|max:50',
            'coordinator' => 'required|integer',
        ]);
        $RegServiceSegment->update([
            'name' => $request->name,
            'coordinator_id' => $request->coordinator,
        ]);
        return redirect()->route('RegServiceSegments.index')->with('success', 'El segmento de servicio ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RegServiceSegment  $RegServiceSegment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(RegServiceSegment $RegServiceSegment)
    {
        $RegServiceSegment->delete();
        return redirect()->route('RegServiceSegments.index')->with('error', 'El segmento de servicio ha sido eliminado con éxito');
    }
}
