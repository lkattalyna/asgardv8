<?php

namespace App\Http\Controllers;

use App\ExternalToolLog;
use App\History;
use Illuminate\Http\Request;

class ExternalToolLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logs = ExternalToolLog::latest()->take(500)->get();
        return view('externalToolLogs.index',compact('logs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExternalToolLog  $externalToolLog
     * @return \Illuminate\Http\Response
     */
    public function show(ExternalToolLog $externalToolLog)
    {
         $datosHistory = History::where('id_asgard',$externalToolLog->id)->get(['id','id_asgard','id_caso','valor_anterior','valor_nuevo','usuario','id_automatizacion']);
       
        return view('externalToolLogs.show',compact('externalToolLog','datosHistory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExternalToolLog  $externalToolLog
     * @return \Illuminate\Http\Response
     */
    public function edit(ExternalToolLog $externalToolLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExternalToolLog  $externalToolLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExternalToolLog $externalToolLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExternalToolLog  $externalToolLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExternalToolLog $externalToolLog)
    {
        //
    }
}
