<?php

namespace App\Http\Controllers;

use App\DevRequest;
use App\DevRequestField;
use Illuminate\Http\Request;

class DevRequestFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(DevRequest $devRequest)
    {
        return view('dev.requests.fields.index',compact('devRequest'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DevRequest $devRequest, Request $request)
    {
        $this->validate($request, [
            'type' => 'required|string',
            'title' => 'required|string|max:50|min:1',
            'name' => 'required|string|max:20|min:1',
            'required' => 'required|boolean',
            'variable' => 'required|boolean',
        ]);
        $field_id = DevRequestField::where('request_id',$devRequest->id)->count();
        $field_id = $field_id+1;
        DevRequestField::create([
            'request_id' => $devRequest->id,
            'field_id' => $field_id,
            'field_type' => $request->type,
            'title' => $request->title,
            'name' => $request->name,
            'comment' => $request->comment,
            'required' => $request->required,
            'variable' => $request->variable,
        ]);
        return redirect()->route('devRequestFields.index', $devRequest->id)->with('success','Campo agregado al requerimiento');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DevRequestField  $devRequestField
     * @return \Illuminate\Http\Response
     */
    public function show(DevRequestField $devRequestField)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DevRequestField  $devRequestField
     * @return \Illuminate\Http\Response
     */
    public function edit(DevRequestField $devRequestField)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DevRequestField  $devRequestField
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DevRequestField $devRequestField)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DevRequestField  $devRequestField
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($devRequest, $devRequestField)
    {
        $item = DevRequestField::where('request_id',$devRequest)->where('field_id',$devRequestField)->first();
        $item->delete();
        return redirect()->route('devRequestFields.index', $devRequest)->with('error','Campo eliminado del requerimiento');

    }
}
