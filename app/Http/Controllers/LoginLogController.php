<?php

namespace App\Http\Controllers;

use App\LoginLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = LoginLog::select('username')->distinct()->get();
        //dd($users);
        return view('loginLogs.index',compact('users'));
    }

    public function showLogs (Request $request)
    {
        $this->validate($request, [
            'usuario' => 'required',
            'f_ini' => 'required|date',
            'f_fin' => 'required|date',
        ]);
        if($request->usuario == 'all'){
            $logs = LoginLog::whereDate('created_at','>=', $request->f_ini)->whereDate('created_at','<=', $request->f_fin)->get();
        }else{
            $logs = LoginLog::where('username',$request->usuario)->whereDate('created_at','>=', $request->f_ini)->whereDate('created_at','<=', $request->f_fin)->get();
        }
        return view('loginLogs.showLogs',compact('logs'));
    }


}
