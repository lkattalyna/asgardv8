<?php

namespace App\Http\Controllers;

use App\SanLink;
use Illuminate\Http\Request;

class SanLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = SanLink::orderBy('name')->get();
        return view('san.inventories.links.index',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('san.inventories.links.create');
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
            'name' => 'required|string|min:1|max:70',
            'link' => 'required|string|min:1|max:150',
        ]);
        SanLink::create([
            'name' => $request->input('name'),
            'link' => $request->input('link'),
        ]);
        return redirect()->route('sanLink.index')->with('success', 'El link ha sido creado con éxito');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SanLink  $sanLink
     * @return \Illuminate\Http\Response
     */
    public function edit(SanLink $sanLink)
    {
        return view('san.inventories.links.edit',compact('sanLink'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SanLink  $sanLink
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SanLink $sanLink)
    {
        $this->validate($request, [
            'name' => 'required|string|min:1|max:70',
            'link' => 'required|string|min:1|max:150',
        ]);
        $sanLink->update([
            'name' => $request->input('name'),
            'link' => $request->input('link'),
        ]);
        return redirect()->route('sanLink.index')->with('success', 'El link ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SanLink  $sanLink
     * @return \Illuminate\Http\Response
     */
    public function destroy(SanLink $sanLink)
    {
        $sanLink->delete();
        return redirect()->route('sanLink.index')->with('error', 'El link ha sido eliminado con éxito');
    }
}
