<?php

namespace App\Http\Controllers;

use App\Config;
use Carbon\Carbon;
use App\ExecutionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExecutionLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // if(Auth::user()->group == 'GRP-ASG-Admin-Master' || Auth::user()->group =='GRP-ASG-DES' || Auth::user()->group =='GRP-ASG-Cord-PAAS'
            // || Auth::user()->group =='GRP-ASG-Cord-IAAS' || Auth::user()->group == 'GRP-ASG-Gte-IAAS-PASS'){
        if( strpos(Auth::user()->group,'GRP-ASG-Admin-Master') !== false ||
            strpos(Auth::user()->group,'GRP-ASG-DES') !== false ||
            strpos(Auth::user()->group,'GRP-ASG-Cord-PAAS') !== false ||
            strpos(Auth::user()->group,'GRP-ASG-Cord-IAAS') !== false ||
            strpos(Auth::user()->group,'GRP-ASG-Gte-IAAS-PASS') !== false
        ){
            $logs = ExecutionLog::latest()->take(100)->get();
        }else{
            $logs = ExecutionLog::where('user_group',Auth::user()->group)->latest()->take(100)->get();
        }
        return view('executionLogs.index',compact('logs'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExecutionLog  $executionLog
     * @return \Illuminate\Http\Response
     */
    public function show(ExecutionLog $executionLog)
    {
        return view('executionLogs.show',compact('executionLog'));
    }

    /*
        Estados de los playbooks
            0 = en progreso...
        Exitosos
            1 = OK resultado sera un link local Asgard
            2 = OK resultado sera = campo resultado de la tabla
            3 = OK resultado consumirá el stdout de la API
            4 = OK resultado sera un link externo
            5 = DISPONIBLE
            6 = DISPONIBLE
            7 = Ansible en otra instancia de servidor
            8 = DISPONIBLE
            9 = DISPONIBLE
        Fallidos
            11 = DISPONIBLE
            12 = ERROR resultado sera = campo resultado de la tabla
            13 = ERROR mostrara resultado ansible
            14 = ERROR mostrara resultado ansible en otra instancia de servidor
    */
    public function getJobStatus($job, ExecutionLog $executionLog){
        $client = new \GuzzleHttp\Client();
        if(is_null($executionLog->server)){
            $serverURL = env('PROD_SERVER');
            $AuthKey = env('AUTH_KEY');
        }else{
            $serverURL = $executionLog->server;
            $AuthKey = env('AUTH_KEY');
        }
        if($executionLog->form == 1){
            $res = $client->request('GET', "http://$serverURL/api/v2/jobs/$job", [
                'headers' => [
                    'Authorization' => "Basic $AuthKey",
                ],
            ]);
        }elseif($executionLog->form == 2){
            $res = $client->request('GET', "http://$serverURL/api/v2/workflow_jobs/$job", [
                'headers' => [
                    'Authorization' => "Basic $AuthKey",
                ],
            ]);
        }

        $respuesta = json_decode($res->getBody()->getContents(),true);
        // Estado exitoso del job
        if($respuesta['status'] =='successful'){
            $fecha_ini = new Carbon($respuesta['started']);
            $fecha_fin = new Carbon($respuesta['finished']);
            if($executionLog->form == 1){
                $id_template = $respuesta['job_template'];
            }elseif($executionLog->form == 2){
                $id_template = $respuesta['workflow_job_template'];
            }
            if(strlen($respuesta['extra_vars']) > 1000){
                $extraVars = substr($respuesta['extra_vars'],0,999);
            }else{
                $extraVars = $respuesta['extra_vars'];
            }
            $executionLog->update([
                'd_ini_script' => $fecha_ini->toDateTimeString(),
                'd_end_script' => $fecha_fin->toDateTimeString(),
                'id_inventory' => $respuesta['inventory'],
                'id_template' => $id_template,
                'vars' => $extraVars,
                'elapsed' => $respuesta['elapsed'],
                'playbook' => $respuesta['name'],
                'status'   => $executionLog->id_success,
            ]);
            if($executionLog->del_host == 2){
                if(is_null($executionLog->server)){
                    $this->unableHost($executionLog->host_id_list);
                }else{
                    $this->unableHost($executionLog->host_id_list, $executionLog->server);
                }

            }
            return redirect()->route('executionLogs.show',$executionLog->id)
            ->with('success','La tarea ha terminado con éxito');
        }
        // Estado fallido del job
        elseif($respuesta['status'] =='failed'){
            if($executionLog->id_failed == 12){
                $resultado = "Error en el proceso de ejecución del playbook";
            }else{
                $resultado = "Error desconocido";
            }

            $fecha_ini = new Carbon($respuesta['started']);
            $fecha_fin = new Carbon($respuesta['finished']);
            if($executionLog->form == 1){
                $id_template = $respuesta['job_template'];
            }elseif($executionLog->form == 2){
                $id_template = $respuesta['workflow_job_template'];
            }
            if(strlen($respuesta['extra_vars']) > 1000){
                $extraVars = substr($respuesta['extra_vars'],0,999);
            }else{
                $extraVars = $respuesta['extra_vars'];
            }
            $executionLog->update([
                'd_ini_script' => $fecha_ini->toDateTimeString(),
                'd_end_script' => $fecha_fin->toDateTimeString(),
                'id_inventory' => $respuesta['inventory'],
                'id_template' =>$id_template,
                'vars' => $extraVars,
                'elapsed' => $respuesta['elapsed'],
                'playbook' => $respuesta['name'],
                'status'   => $executionLog->id_failed,
                'result' => $resultado,
            ]);
            return redirect()->route('executionLogs.show',$executionLog->id)
            ->with('error','La tarea ha terminado con un estado fallido');
        }elseif($respuesta['status'] =='canceled'){
            $fecha_ini = new Carbon($respuesta['started']);
            $fecha_fin = new Carbon($respuesta['finished']);
            if($executionLog->form == 1){
                $id_template = $respuesta['job_template'];
            }elseif($executionLog->form == 2){
                $id_template = $respuesta['workflow_job_template'];
            }
            if(strlen($respuesta['extra_vars']) > 1000){
                $extraVars = substr($respuesta['extra_vars'],0,999);
            }else{
                $extraVars = $respuesta['extra_vars'];
            }
            $executionLog->update([
                'd_ini_script' => $fecha_ini->toDateTimeString(),
                'd_end_script' => $fecha_fin->toDateTimeString(),
                'id_inventory' => $respuesta['inventory'],
                'id_template' =>$id_template,
                'vars' => $extraVars,
                'elapsed' => $respuesta['elapsed'],
                'playbook' => $respuesta['name'],
                'status'   => 12,
                'result' => "Trabajo cancelado por el usuario",
            ]);
            return redirect()->route('executionLogs.show',$executionLog->id)
            ->with('error','La tarea ha terminado con un estado fallido');
        }
        return redirect()->route('executionLogs.show',$executionLog->id)
            ->with('info', 'La tarea sigue en proceso de ejecución');
    }
    public function getJobResult($job,$server=NULL){
        $client = new \GuzzleHttp\Client();
        //dd($server);
        if(is_null($server)){
            $serverURL = env('PROD_SERVER');
            $AuthKey = env('AUTH_KEY');
        }else{
            $serverURL = $server;
            $AuthKey = env('AUTH_KEY');
        }
        $res = $client->request('GET', "http://$serverURL/api/v2/jobs/$job/stdout/?format=html", [
            'headers' => [
                'Authorization' => "Basic $AuthKey",
            ],
        ]);
        return $res->getBody()->getContents();
    }
    public function unableHost($idHost, $server=NULL){
        $hosts = explode(',',$idHost);
        foreach($hosts as $host){
            $client = new \GuzzleHttp\Client();
            if(is_null($server)){
                $serverURL = env('PROD_SERVER');
                $AuthKey = env('AUTH_KEY');
            }else{
                $serverURL = $server;
                $AuthKey = env('AUTH_KEY');
            }
            $varEnable = array("enabled" => false);
            $res = $client->request('PATCH', "http://$serverURL/api/v2/hosts/$host/", [
                'headers' => [
                    'Authorization' => "Basic $AuthKey",
                ],
                'json' => $varEnable,
            ]);
        }
        return "Host $idHost desactivado(s)";
    }

    public function showRs(ExecutionLog $executionLog)
    {
        switch($executionLog->status){
            case 1:
                $executionLog['link'] = asset('scriptRs/'.$executionLog->result);
            break;
            case 3:
                $executionLog['link'] = route('ExecutionLog.getJobResult',$executionLog->id_job);
            break;
            case 4:
                $executionLog['link'] = $executionLog->result;
            break;
            case 5:
                $strs = explode('/',$executionLog->result);
                $url =  "";
                $file = array_pop($strs);
                foreach($strs as $str){
                    if ($str === end($strs)) {
                        $url .= $str;
                    }else{
                        $url .= $str.'-';
                    }
                }
                $executionLog['link'] = route('files.get',[$url,$file]);
            break;
            case 6:
                $executionLog['link'] = $executionLog->result;
            break;
            case 7:
                $executionLog['link'] = route('ExecutionLog.getJobResultServer',[$executionLog->id_job, $executionLog->server]);
            break;
            case 13:
                $executionLog['link'] = route('ExecutionLog.getJobResult',$executionLog->id_job);
            break;
            case 14:
                //dd($executionLog->server);
                $executionLog['link'] = route('ExecutionLog.getJobResultServer',[$executionLog->id_job, $executionLog->server]);
                //dd($executionLog['link']);
            break;
        }
        //dd($executionLog->link);
        return view('executionLogs.showRs', compact('executionLog'));

    }
}
