<?php

namespace App\Http\Controllers;

use App\WinShareFolder;
use Illuminate\Http\Request;

class WinShareFolderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = WinShareFolder::orderBy('folder_name')->get(['id','folder_name', 'permission','ad', 'domain']);
        foreach($items as $item){
            $item->folder_name = str_replace("*","\\", $item->folder_name);
        }
        return view('windowsPH.winShareFolder.index',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('windowsPH.winShareFolder.create');
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
            'name' => 'required|string|min:1|max:280',
            'permission' => 'required|string|min:7|max:11',
            'group' => 'required|string|min:3|max:100',
            'domain' => 'required|string|min:3|max:50',
            'dc' => 'required|string|min:1|max:100',
            'user' => 'required|string|min:1|max:120',
        ]);
        $folder = str_replace("\\", "*", $request->input('name'));
        WinShareFolder::create([
            'folder_name' => $folder,
            'permission' => $request->input('permission'),
            'ad' => $request->input('group'),
            'domain' => $request->input('domain'),
            'dc' => $request->input('dc'),
            'user' => $request->input('user'),
        ]);
        return redirect()->route('winShareFolder.index')->with('success', 'La carpeta compartida ha sido creada con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(WinShareFolder $winShareFolder)
    {
        $winShareFolder->folder_name = str_replace("*","\\", $winShareFolder->folder_name);
        return view('windowsPH.winShareFolder.show',compact('winShareFolder'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(WinShareFolder $winShareFolder)
    {
        $winShareFolder->folder_name = str_replace("*","\\", $winShareFolder->folder_name);
        return view('windowsPH.winShareFolder.edit',compact('winShareFolder'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WinShareFolder $winShareFolder)
    {
        $this->validate($request, [
            'name' => 'required|string|min:1|max:280',
            'permission' => 'required|string|min:7|max:11',
            'group' => 'required|string|min:3|max:100',
            'domain' => 'required|string|min:3|max:50',
            'dc' => 'required|string|min:1|max:100',
            'user' => 'required|string|min:1|max:120',
        ]);
        $folder = str_replace("\\", "*", $request->input('name'));
        $winShareFolder->update([
            'folder_name' => $folder,
            'permission' => $request->input('permission'),
            'ad' => $request->input('group'),
            'domain' => $request->input('domain'),
            'dc' => $request->input('dc'),
            'user' => $request->input('user'),
        ]);
        return redirect()->route('winShareFolder.index')->with('success', 'La carpeta compartida ha sido actualizada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(WinShareFolder $winShareFolder)
    {
        $winShareFolder->delete();
        return redirect()->route('winShareFolder.index')->with('error', 'La carpeta compartida ha sido eliminada con éxito');
    }
}
