<?php

namespace App\Http\Controllers;

use App\SyncLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SyncLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipos = SyncLog::select('process')->distinct()->get();
        //dd($users);
        return view('syncLogs.index',compact('tipos'));
    }

    public function showLogs (Request $request)
    {
        $this->validate($request, [
            'tipo' => 'required',
            'f_ini' => 'required|date',
            'f_fin' => 'required|date',
        ]);
        if($request->tipo == 'all'){
            $logs = SyncLog::whereDate('created_at','>=', $request->f_ini)->whereDate('created_at','<=', $request->f_fin)->get();
        }else{
            $logs = SyncLog::where('process',$request->tipo)->whereDate('created_at','>=', $request->f_ini)->whereDate('created_at','<=', $request->f_fin)->get();
        }
        return view('syncLogs.showLogs',compact('logs'));
    }

}
