<?php

namespace App\Http\Controllers;

use App\JobSchedule;
use App\ExecutionLog;
use Illuminate\Http\Request;

class JobScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\JobSchedule  $jobSchedule
     * @return \Illuminate\Http\Response
     */
    public function show(JobSchedule $jobSchedule)
    {
        if(!is_null($jobSchedule->id_job)){
            $jobSchedule['id_ex_log']= ExecutionLog::where('id_job', $jobSchedule->id_job)->first('id');
        }
        //dd($jobSchedule->id_ex_log);
        return view('jobSchedules.show',compact('jobSchedule'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\JobSchedule  $jobSchedule
     * @return \Illuminate\Http\Response
     */
    public function edit(JobSchedule $jobSchedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\JobSchedule  $jobSchedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobSchedule $jobSchedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\JobSchedule  $jobSchedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobSchedule $jobSchedule)
    {
        //
    }
}
