<?php

namespace App\Http\Controllers;

use App\SanServer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SanServerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = SanServer::orderBy('name')->get();
        return view('san.inventories.server.index',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('san.inventories.server.create');
    }

    /**
     * Store a newly created resource in server.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:1|max:40',
            'ip' => 'required|ipv4',
            'serial' => 'required|string|min:1|max:40',
            'code' => 'required|string|min:1|max:20',
            'location' => 'required|string|min:1|max:20',
            'so' => 'required|string|min:1|max:40',
        ]);
        SanServer::create([
            'name' => $request->input('name'),
            'serial' => $request->input('serial'),
            'code' => $request->input('code'),
            'os' => strtoupper($request->input('so')),
            'main_ip' => $request->input('ip'),
            'others_ip' => $request->input('other'),
            'memory' => strtoupper($request->input('memory')),
            'location' => $request->input('location'),
            'storage' => $request->input('storage'),
            'info' => $request->input('info'),
            'owner_id' => Auth::user()->id,
        ]);
        return redirect()->route('sanServer.index')->with('success', 'El servidor ha sido creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SanServer  $sanServer
     * @return \Illuminate\Http\Response
     */
    public function show(SanServer $sanServer)
    {
        return view('san.inventories.server.show',compact('sanServer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SanServer  $sanServer
     * @return \Illuminate\Http\Response
     */
    public function edit(SanServer $sanServer)
    {
        return view('san.inventories.server.edit',compact('sanServer'));
    }

    /**
     * Update the specified resource in server.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SanServer  $sanServer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SanServer $sanServer)
    {
        $this->validate($request, [
            'name' => 'required|string|min:1|max:40',
            'ip' => 'required|ipv4',
            'serial' => 'required|string|min:1|max:40',
            'code' => 'required|string|min:1|max:20',
            'location' => 'required|string|min:1|max:20',
            'so' => 'required|string|min:1|max:40',
        ]);
        $sanServer->update([
            'name' => $request->input('name'),
            'serial' => $request->input('serial'),
            'code' => $request->input('code'),
            'os' => strtoupper($request->input('so')),
            'main_ip' => $request->input('ip'),
            'others_ip' => $request->input('other'),
            'memory' => strtoupper($request->input('memory')),
            'location' => $request->input('location'),
            'storage' => $request->input('storage'),
            'info' => $request->input('info'),
        ]);
        return redirect()->route('sanServer.index')->with('success', 'El servidor ha sido actualizado');
    }

    /**
     * Remove the specified resource from server.
     *
     * @param  \App\SanServer  $sanServer
     * @return \Illuminate\Http\Response
     */
    public function destroy(SanServer $sanServer)
    {
        $sanServer->delete();
        return redirect()->route('sanServer.index')->with('error', 'El servidor ha sido eliminado con éxito');
    }
}
