<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\VirtualHost;
use Illuminate\Http\Request;
use App\Http\Traits\ConnectionTrait;
use App\VmHnasReport;
use Illuminate\Support\Facades\View;

class ConvergenceController extends Controller
{
    Use ConnectionTrait;

    public function citrixProfile()
    {
        return view('convergence.citrixProfile');
    }
    public function citrixProfileStore(Request $request)
    {
        $this->validate($request, [
            'user' => 'required|string|min:4|max:20',
        ]);
        $user = $request->input('user');
        //$log = $this->getExternalToolLog('ConvergenceCitrixProfile');
        $string = "";
        $results = shell_exec("powershell.exe -executionpolicy bypass -NoProfile ". app_path() . "\scripts\VIRTUALIZATION\ProfilesCitrix.ps1 -profile $user" . escapeshellarg($string));
        dd(json_decode($results));
        if($results === null){
            return redirect()->route('convergence.citrixProfile')->with('error','Ha ocurrido un error al ejecutar el comando, por favor intente de nuevo o contacte al administrador');
        }else{
            if(isset($results->Error)){
                $log->update([
                    'd_end_script' => date("Y-m-d H:i:s"),
                    'status' => 12,
                    'result' => "Fallo en la ejecución para el usuario *$user*",
                ]);
                return redirect()->route('convergence.citrixProfile')->with('error',$results->Error);
            }else{
                $log->update([
                    'd_end_script' => date("Y-m-d H:i:s"),
                    'status' => 2,
                    'result' => "Ejecución para el usuario *$user* realizada exitosamente",
                ]);
                return redirect()->route('convergence.citrixProfile')->with('error',$results->Error);
            }
        }

    }
    public function hnasReport()
    {
        $reports = VmHnasReport::orderBy('created_at')->get(['id','created_at']);
        return view('convergence.hnasReport',compact('reports'));
    }
    public function hnasReportStore(Request $request)
    {
        $this->validate($request, [
            'report' => 'required',
        ]);
        //dd($request->input('report'));
        $report = VmHnasReport::find($request->input('report'));
        //dd($report);
        return view('convergence.hnasReportRs',compact('report'));
    }
}
