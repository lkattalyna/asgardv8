<?php

namespace App\Http\Controllers;

use App\RegConsumedService;
use Illuminate\Http\Request;

class RegConsumedServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $consumedServices = RegConsumedService::all();
        return view('improvements.RegConsumedServices.index', compact('consumedServices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('improvements.RegConsumedServices.create');
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
        ]);
        RegConsumedService::create([
            'name' => $request->input('name'),
        ]);
        return redirect()->route('RegConsumedServices.index')->with('success', 'El servicio consumido ha sido creado con éxito');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RegConsumedService  $RegConsumedService
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(RegConsumedService $RegConsumedService)
    {
        return view('improvements.RegConsumedServices.edit', compact('RegConsumedService'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RegConsumedService  $RegConsumedService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, RegConsumedService $RegConsumedService)
    {
        $this->validate($request, [
            'name' => 'required|min:1|max:100',
        ]);
        $RegConsumedService->update([
            'name' => $request->input('name'),
        ]);
        return redirect()->route('RegConsumedServices.index')->with('success', 'El servicio consumido ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RegConsumedService  $RegConsumedService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(RegConsumedService $RegConsumedService)
    {
        $RegConsumedService->delete();
        return redirect()->route('RegConsumedServices.index')->with('error', 'El servicio consumido ha sido eliminado con éxito');
    }
}
