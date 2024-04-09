<?php

namespace App\Http\Controllers;

use App\DevTask;
use Illuminate\Http\Request;

class DevTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $tasks = DevTask::all();
        return view('dev.tasks.index',compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('dev.tasks.create');
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
            'max' => 'required|integer',
            'min' => 'required|integer',
        ]);
        if($request->description == ''){
            $desc = 'N/A';
        } else {
            $desc = $request->description;
        }
        DevTask::create([
            'name' => $request->name,
            'max_time' => $request->max,
            'min_time' => $request->min,
            'description' => $desc,
        ]);
        return redirect()->route('devTasks.index')->with('success', 'La tarea ha sido creada con éxito');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DevTask  $devTask
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(DevTask $devTask)
    {
        return view('dev.tasks.edit',compact('devTask'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DevTask  $devTask
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, DevTask $devTask)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100|min:1',
            'max' => 'required|integer',
            'min' => 'required|integer',
        ]);
        if($request->description == ''){
            $desc = 'N/A';
        } else {
            $desc = $request->description;
        }
        $devTask->update([
            'name' => $request->name,
            'max_time' => $request->max,
            'min_time' => $request->min,
            'description' => $desc,
        ]);
        return redirect()->route('devTasks.index')->with('success', 'La tarea ha sido actualizada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DevTask  $devTask
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DevTask $devTask)
    {
        $devTask->delete();
        return redirect()->route('devTasks.index')->with('error', 'La tarea ha sido eliminada con éxito');
    }
}
