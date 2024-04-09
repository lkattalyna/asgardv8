<?php

namespace App\Http\Controllers;

use App\RegCustomerLevel;
use Illuminate\Http\Request;

class RegCustomerLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $customerLevels = RegCustomerLevel::all();
        return view('improvements.RegCustomerLevels.index', compact('customerLevels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('improvements.RegCustomerLevels.create');
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
            'name' => 'required|min:1|max:100',
        ]);
        RegCustomerLevel::create([
            'name' => $request->input('name'),
        ]);
        return redirect()->route('RegCustomerLevels.index')->with('success', 'El nivel de cliente ha sido creado con éxito');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RegCustomerLevel  $RegCustomerLevel
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(RegCustomerLevel $RegCustomerLevel)
    {
        return view('improvements.RegCustomerLevels.edit', compact('RegCustomerLevel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RegCustomerLevel  $RegCustomerLevel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, RegCustomerLevel $RegCustomerLevel)
    {
        $this->validate($request, [
            'name' => 'required|min:1|max:100',
        ]);
        $RegCustomerLevel->update([
            'name' => $request->input('name'),
        ]);
        return redirect()->route('RegCustomerLevels.index')->with('success', 'El nivel de cliente ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RegCustomerLevel  $RegCustomerLevel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(RegCustomerLevel $RegCustomerLevel)
    {
        $RegCustomerLevel->delete();
        return redirect()->route('RegCustomerLevels.index')->with('error', 'El nivel de cliente ha sido eliminado con éxito');
    }
}
