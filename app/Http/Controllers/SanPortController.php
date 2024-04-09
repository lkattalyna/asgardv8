<?php

namespace App\Http\Controllers;

use App\SanPort;
use App\SyncLog;
use App\SanSwitch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Traits\ConnectionTrait;

class SanPortController extends Controller
{
    Use ConnectionTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = SanSwitch::orderBy('sw')->get(['id','sw']);
        #return view('san.inventories.ports.index',compact('items','log'));
        return view('san.inventories.ports.index',compact('items'));
    }
    public function report()
    {
        $items = SanPort::orderBy('id_switch')->get(['id','name','slot','port','status','service','id_switch']);
        $log = SyncLog::where('process','sync_san_switches')->latest()->first('created_at');
        if(!$log){
            $log = 'Nunca';
        }else{
            $log = $log->created_at;
        }
        return view('san.inventories.ports.report',compact('items','log'));
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
     * @param  \App\SanPort  $sanPort
     * @return \Illuminate\Http\Response
     */
    public function show(SanPort $sanPort)
    { 
        $ip = $sanPort->getSwitch->ip;        
        $log = $this->getExternalToolLog('SanPortState');
        $string = "";
        if($sanPort->slot != 'N/A' && $sanPort->slot != '' ){
            $results = shell_exec("powershell.exe -executionpolicy bypass -NoProfile ". app_path() . "\scripts\SAN\R001-ExecutionScripts.ps1 -op 1 -params '-opcion 1 -parametros *$sanPort->port@$ip@$sanPort->slot*'" . escapeshellarg($string));
        }else{
            $results = shell_exec("powershell.exe -executionpolicy bypass -NoProfile ". app_path() . "\scripts\SAN\R001-ExecutionScripts.ps1 -op 1 -params '-opcion 1 -parametros *$sanPort->port@$ip*'" . escapeshellarg($string));
        }
        $results = json_decode($results,true);
        
        if(isset($results['Error'])){
            $log->update([
                'd_end_script' => date("Y-m-d H:i:s"),
                'status' => 12,
                'result' => 'Fallo en la ejecución del job',
            ]);
            $console = $results['Error'];
        }elseif(is_null($results)){
            $log->update([
                'd_end_script' => date("Y-m-d H:i:s"),
                'status' => 12,
                'result' => 'Fallo en la ejecución del job',
            ]);
            $console = "No se logro ejecutar el script contacte al administrador";
        }else{
            $log->update([
                'd_end_script' => date("Y-m-d H:i:s"),
                'status' => 2,
                'result' => 'Ejecución realizada exitosamente',
            ]);
            $console = $results['Stdout']['value'];
        }
        return view('san.inventories.ports.show',compact('sanPort','console'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SanPort  $sanPort
     * @return \Illuminate\Http\Response
     */
    public function edit(SanPort $sanPort)
    {
        return view('san.inventories.ports.edit',compact('sanPort'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SanPort  $sanPort
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SanPort $sanPort)
    {
        $this->validate($request, [
            'im' => 'required|string|min:1|max:15',
            'comment' => 'required|string|min:1|max:300',
        ]);
        $sanPort->update([
            'im' => $request->input('im'),
            'comment' => $request->input('comment'),
        ]);
        return redirect()->route('sanPorts.index')->with('success', 'El puerto ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SanPort  $sanPort
     * @return \Illuminate\Http\Response
     */
    public function destroy(SanPort $sanPort)
    {
        $sanPort->delete();
        return redirect()->route('sanPorts.index')->with('error', 'El puerto ha sido eliminado con éxito');
    }

    public function list(  ){
        /*$items = SanSwitch::orderBy('sw')->get(['id','sw']);
        return view('san.inventories.ports.list',compact('items'));*/
        $query = DB::table('san_ports')->join('san_switches', 'san_ports.id_switch', '=', 'san_switches.id')->orderBy('san_ports.id_switch')->select('san_ports.*','san_switches.sw');
        return DataTables::queryBuilder($query)->toJson();
    }
    public function getPorts(Request $request){
        //dd($request->tp);
        if($request->ajax()){
            if ($request->has("sw")){
                if ($request->tp == 'table'){
                    $items = SanPort::where('id_switch',$request->sw)->get();
                    $libre=0;$aprovisionado=0;$reservado=0;$total=0;
                    foreach($items as $item){
                        switch($item->status){
                            case "LIBRE":
                                $libre++;
                            break;
                            case "RESERVADO":
                                $reservado++;
                            break;
                            case "APROVISIONADO":
                                $aprovisionado++;
                            break;
                        }
                        $total++;
                    }
                    $view = View::make('san.inventories.ports.listRs',compact('items','libre','aprovisionado','reservado','total'));
                }
                $sections = $view->renderSections();
                return response()->json($sections['contentPanel']);
            }
        }
    }
}
