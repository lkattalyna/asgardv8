<?php

namespace App\Http\Controllers;

use App\RegServiceLayer;
use App\RegServiceSegment;
use App\User;
use Illuminate\Http\Request;

class RegServiceLayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $layers = RegServiceLayer::all();
        return view('improvements.RegServiceLayers.index', compact('layers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        $segments = RegServiceSegment::orderBy('name')->get();
        return view('improvements.RegServiceLayers.create',compact('segments','users'));
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
            'name' => 'required|string|min:1|max:50',
            'segment' => 'required|integer',
            'model' => 'required|string|min:1|max:5',
            'leader' => 'required|integer',
            'coordinator' => 'required|integer',
        ]);
        RegServiceLayer::create([
            'name' => $request->input('name'),
            'segment_id' => $request->input('segment'),
            'model' => $request->input('model'),
            'leader_id' => $request->leader,
            'coordinator_id' => $request->coordinator,
        ]);
        return redirect()->route('RegServiceLayers.index')->with('success', 'La capa de servicio ha sido creada con éxito');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RegServiceLayer  $RegServiceLayer
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(RegServiceLayer $RegServiceLayer)
    {
        $users = User::orderBy('name')->get();
        $segments = RegServiceSegment::orderBy('name')->get();
        return view('improvements.RegServiceLayers.edit', compact('RegServiceLayer','segments','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RegServiceLayer  $RegServiceLayer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, RegServiceLayer $RegServiceLayer)
    {
        $this->validate($request, [
            'name' => 'required|string|min:1|max:50',
            'segment' => 'required|integer',
            'model' => 'required|string|min:1|max:5',
            'leader' => 'required|integer',
            'coordinator' => 'required|integer',
        ]);
        $RegServiceLayer->update([
            'name' => $request->input('name'),
            'segment_id' => $request->input('segment'),
            'model' => $request->input('model'),
            'leader_id' => $request->leader,
            'coordinator_id' => $request->coordinator,
        ]);
        return redirect()->route('RegServiceLayers.index')->with('success', 'La capa de servicio ha sido actualizada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RegServiceLayer  $RegServiceLayer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(RegServiceLayer $RegServiceLayer)
    {
        $RegServiceLayer->delete();
        return redirect()->route('RegServiceLayers.index')->with('error', 'La capa de servicio ha sido eliminada con éxito');
    }
}
