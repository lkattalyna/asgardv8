<?php

namespace App\Http\Controllers;

use App\SanStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SanStorageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = SanStorage::orderBy('name')->get();
        return view('san.inventories.storage.index',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('san.inventories.storage.create');
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
            'processor' => 'required|integer|min:1',
            'support' => 'required|date',
        ]);
        SanStorage::create([
            'name' => $request->input('name'),
            'trademark' => strtoupper($request->input('mark')),
            'model' => strtoupper($request->input('model')),
            'type' => $request->input('type'),
            'main_ip' => $request->input('ip'),
            'others_ip' => $request->input('other'),
            'location' => $request->input('location'),
            'serial' => $request->input('serial'),
            'code' => $request->input('code'),
            'cache' => $request->input('cache'),
            'processor' => $request->input('processor'),
            'support_date' => $request->input('support'),
            'id_naa' => $request->input('naa'),
            'owner_id' => Auth::user()->id,
        ]);
        return redirect()->route('sanStorage.index')->with('success', 'El storage ha sido creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SanStorage  $sanStorage
     * @return \Illuminate\Http\Response
     */
    public function show(SanStorage $sanStorage)
    {
        return view('san.inventories.storage.show',compact('sanStorage'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SanStorage  $sanStorage
     * @return \Illuminate\Http\Response
     */
    public function edit(SanStorage $sanStorage)
    {
        return view('san.inventories.storage.edit',compact('sanStorage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SanStorage  $sanStorage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SanStorage $sanStorage)
    {
        $this->validate($request, [
            'name' => 'required|string|min:1|max:40',
            'mark' => 'required|string|min:1|max:20',
            'model' => 'required|string|min:1|max:35',
            'ip' => 'required|ipv4',
            'serial' => 'required|string|min:1|max:40',
            'code' => 'required|string|min:1|max:20',
            'location' => 'required|string|min:1|max:20',
            'processor' => 'required|integer|min:1',
            'support' => 'required|date',
        ]);
        $sanStorage->update([
            'name' => $request->input('name'),
            'trademark' => strtoupper($request->input('mark')),
            'model' => strtoupper($request->input('model')),
            'type' => $request->input('type'),
            'main_ip' => $request->input('ip'),
            'others_ip' => $request->input('other'),
            'location' => $request->input('location'),
            'serial' => $request->input('serial'),
            'code' => $request->input('code'),
            'cache' => $request->input('cache'),
            'processor' => $request->input('processor'),
            'support_date' => $request->input('support'),
            'id_naa' => $request->input('naa'),
        ]);
        return redirect()->route('sanStorage.index')->with('success', 'El storage ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SanStorage  $sanStorage
     * @return \Illuminate\Http\Response
     */
    public function destroy(SanStorage $sanStorage)
    {
        $sanStorage->delete();
        return redirect()->route('sanStorage.index')->with('error', 'El storage ha sido eliminado con éxito');
    }
}
