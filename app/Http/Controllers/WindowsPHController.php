<?php

namespace App\Http\Controllers;

use App\OsGroup;
use App\WinShareFolder;
use Illuminate\Http\Request;
use App\Http\Traits\ConnectionTrait;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;

class WindowsPHController extends Controller
{
    Use ConnectionTrait;
    private $method = "local";

    public function restartPoolCom()
    {
        $inventario = 4;
        $groups = $this->getGroups($inventario,$this->method);
        return view('windowsPH.restartPoolCom',compact('groups','inventario'));
    }
    public function restartPoolComStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'pool' => 'required|string|min:1|max:50',
        ]);
        $idTemplate = 140;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("host_name" => $request->host, "apppool" => $request->input('pool')));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function restartIISCom()
    {
        $inventario = 4;
        $groups = $this->getGroups($inventario,$this->method);
        return view('windowsPH.restartIISCom',compact('groups','inventario'));
    }
    public function restartIISComStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 141;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("host_name" => $request->host));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function restartServicesCom()
    {
        $inventario = 4;
        $groups = $this->getGroups($inventario,$this->method);
        return view('windowsPH.restartServicesCom',compact('groups','inventario'));
    }
    public function restartServicesComStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'serviceOne' => 'required|string|min:1|max:50',
        ]);
        $idTemplate = 144;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        if($request->input('serviceTwo') != '0'){
            $variables = array("extra_vars" => array("host_name" => $request->host, "service1" => $request->input('serviceOne'),  "service2" => $request->input('serviceTwo')));
        }else{
            $variables = array("extra_vars" => array("host_name" => $request->host, "service1" => $request->input('serviceOne')));
        }
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function updateAtUserAD()
    {
        $inventario = 4;
        $groups = $this->getGroups($inventario,$this->method);
        return view('windowsPH.updateAtUserAD',compact('groups','inventario'));
    }
    public function updateAtUserADStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 181;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("rdp_host" => $request->host));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function reportSWP()
    {
        $inventario = 4;
        $groups = $this->getGroups($inventario,$this->method);
        return view('windowsPH.reportSWP',compact('groups','inventario'));
    }
    public function reportSWPStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 199;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("nameserver" => $request->host));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function sharedFolderPer()
    {
        return view('windowsPH.sharedFolderPer',compact('groups','inventario'));
    }
    public function getSharedFolders($domain)
    {
        $folders = WinShareFolder::where('dc', $domain)->distinct('folder_name')->get('folder_name');
        foreach($folders as $folder){
            $folder['show'] = str_replace("*","\\" ,$folder->folder_name);
        }
        return $folders;
    }
    public function sharedFolderPerStore(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'domain' => 'required|string',
            'folder' => 'required|string',
            'permission' => 'required|integer|min:1|max:2',
            'action' => 'required|string|min:6|max:7',
        ]);
        if($request->input('domain') == 'COLBTADC01.co.attla.corp'){
            $credential = 28;
        }elseif($request->input('domain') == 'WDCBOG01.comcel.com.co'){
            $credential = 8;
            //$credential = 26;
        }elseif($request->input('domain') == 'WCBOGDC01.claro.co'){
            $credential = 35;
        }
        if($request->input('permission') == 1){
            $permission = 'Colaborador';
        }elseif($request->input('permission') == 2){
            $permission = 'Lectura';
        }
        $folder = str_replace("\\\\","",$request->input('folder'));
        $folder = str_replace("\\","\\\\\\\\",$folder);
        $folder = WinShareFolder::where('folder_name','like',"%$folder")->where('permission', $permission)->first();
        if(is_null($folder)){
            return redirect()->back()->with('error','No esta disponible el tipo de permiso para la carpeta seleccionada');
        }
        $idTemplate = 255;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("credentials" => array($credential),"extra_vars" => array("group" => $folder->ad, "host" => $folder->dc, "state" => $request->input('action'), "user" => $request->input('username')));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function queryKb()
    {
        $inventario = 4;
        $groups = $this->getGroups($inventario,$this->method);
        return view('windowsPH.queryKb',compact('groups','inventario'));
    }
    public function queryKbStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'username' => 'required|string',
            'password' => 'required|string',
            'domain' => 'required|string',
            'kb' => 'required|string|min:5|max:100',
        ]);
        if($request->input('domain') == 'COLBTADC01.co.attla.corp'){
            $credential = 28;
        }elseif($request->input('domain') == 'WDCBOG01.comcel.com.co'){
            $credential = 8;
            //$credential = 26;
        }elseif($request->input('domain') == 'WCBOGDC01.claro.co'){
            $credential = 35;
        }
        $idTemplate = 267;
        $log = $this->getLog(1,12,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $hosts = '';
        $test = $request->input('host');
        foreach($test as $host){
            if ($host === end($test)) {
                $hosts = $hosts.$host;
            }else{
                $hosts = $hosts.$host.',';
            }
        }
        //dd($hosts);
        $variables = array("credentials" => array($credential),"extra_vars" => array("host" => $hosts, "origen" => $request->input('domain'), "kb" => $request->input('kb'),
            "User" => $request->input('username'), "Password" => $request->input('password')));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
            'result' => "/windowsit/Win_PH_014/HotfixReport.html",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function checkSO()
    {
        $inventario = 4;
        $groups = $this->getGroups($inventario,$this->method);
        return view('windowsPH.checkSO',compact('groups','inventario'));
    }
    public function checkSOStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'destFolder' => 'required|string|min:1|max:50',
        ]);
        $idTemplate = 307;
        $log = $this->getLog(5,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard, "dest_folder" => strtoupper($request->input('destFolder')) ));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
            'result' => "windowsit/Win_PH_016/$request->destFolder/$id_asgard.html",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function getCheckSO (Request $request) {
        $view =  view('windowsPH.getCheckSO');
        if($request->ajax()){
            if ($request->has("case")){
                $folder = strtoupper($request->input('case'));
                if(Storage::disk('fileserver')->exists("WINDOWSIT/Win_PH_016/$folder")){
                    $files = Storage::disk('fileserver')->files("WINDOWSIT/Win_PH_016/$folder");
                    $items = array();
                    foreach($files as $file){
                        array_push($items,str_replace("WINDOWSIT/Win_PH_016/$folder/","",$file));
                    }
                }else{
                    $items = 'No existen ejecuciones para el número de caso solicitado';
                }
                $view = View::make('windowsPH.getCheckSOTable',compact('items','folder'));
                $sections = $view->renderSections();
                return response()->json($sections['contentPanel']);
            }
        }else return $view;
    }
    public function getCheckSOShow (Request $request, $folder, $file) {
        return view('windowsPH.getCheckSOShow',compact('file','folder'));
    }
    public function localUsersReport()
    {
        $inventario = 4;
        $groups = $this->getGroups($inventario,$this->method);
        return view('windowsPH.localUsersReport',compact('groups','inventario'));
    }
    public function localUsersReportStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'case' => 'required|string|min:1|max:50',
        ]);
        $idTemplate = 315;
        $log = $this->getLog(5,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "CASO" => strtoupper($request->input('case')) ));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
            'result' => "windowsit/Win_PH_017/".strtoupper($request->input('case')).".html",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }

	public function testConectividadPH(){
    $inventario = 4;
    $groups = $this->getGroups($inventario,$this->method);
    return view('windowsPH.connectivityWinPH',compact('groups','inventario'));
}

public function testConectividadPHStore(Request $request){

    $campos = $request->all();
    $HOST = $campos["host"][0];
    $ips_ping_destino = array_values($campos["ipDestino"]);
    $ips_telnet_destino = array_values($campos["ipTelnet"]);
    $ports_telnet_destino = array_values($campos["puertoTelnet"]);
    $telnet_opts= array();
    $do_ping    = "false";
    $do_telnet  = "false";
    $do_tracert = "false";
    $idTemplate = 472;
    $log = $this->getLog(5,13,$idTemplate);
    $id_asgard = $log->id;

    if(count($ips_telnet_destino) == count($ports_telnet_destino)){
        for($i = 0; $i<count($ips_telnet_destino);$i++){
            $arr_ips_destino = ['ip' => $ips_telnet_destino[$i]];
            $arr_ports_destino = ['port' => $ports_telnet_destino[$i]];
            $telnet_opts []= \Arr::collapse([$arr_ips_destino,$arr_ports_destino]);
        }
    }
    if( in_array("ping",$campos["tipoAccion"])){
        $do_ping    = "true";
    }

    if( in_array("telnet",$campos["tipoAccion"])){
        $do_telnet  = "true";
    }

    if( in_array("tracer",$campos["tipoAccion"])){
        $do_tracert = "true";
    }
    $variables = array("extra_vars" =>
        [
            "host"  => $HOST,
            "id_asgard" => $id_asgard,
            "telnet_opts" => $telnet_opts,
            "ips_ping_destino" => $ips_ping_destino,
            "ips_tracert_destino" => $ips_ping_destino,
            "do_ping" => $do_ping,
            "do_telnet" => $do_telnet,
            "do_tracert" => $do_tracert
        ]
    );

    $resultado = $this->runPlaybook($idTemplate,$variables);

    if($do_ping=='true'){
        $ping = 'ping';
        foreach($ips_ping_destino as $obj){
            $history = $this->gethistory($id_asgard,$ping,$obj,$obj,6,$idTemplate);
       }
   }
   if($do_tracert =='true'){
    $tracert = 'tracert';
        foreach($ips_ping_destino as $obj){
            $history = $this->gethistory($id_asgard,$tracert,$obj,$obj,6,$idTemplate);
        }
   }
   if($do_telnet =='true'){
    $telnet = 'telnet';
        foreach($telnet_opts as $obj){
            $history = $this->gethistory($id_asgard,$telnet,implode(':',$obj),implode(':',$obj),6,$idTemplate);
        }
   }
   $resultado = $resultado['job'];
   $log->update([
       'id_job' => $resultado,
       'result' => "/WINDOWS/WIN_CONECTIVIDAD_001/$id_asgard.html",
   ]);
    return redirect()->route('executionLogs.show',$id_asgard);
}



public function serviceManagementV2()
    {
        $inventario = 4;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('windowsPH.serviceManagementV2PH',compact('groups','inventario'));
    }


    public function serviceManagementStoreV2(Request $request)
        {
            $this->validate($request, [
                'host' => 'required',
                'option' => 'required|string|min:4|max:7',
            ]);
            if(!$request->input('option') == 'listar'){
                $this->validate($request, [
                    'service' => 'required|string|min:1|max:50',
                ]);
            }
            $idTemplate = 474;
            $log = $this->getLog(4,13,$idTemplate);
            $id_asgard = $log->id;
            //$id_asgard = 1;
            if($request->input('option') == 'listar'){
                $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard, "option" => $request->input('option')));
            }else{
                $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard, "option" => $request->input('option'), "service" => $request->input('service')));
            }

            //dd(json_encode($variables));
            $resultado = $this->runPlaybook($idTemplate,$variables);
            $resultado = $resultado['job'];
            //dd($resultado);
            $log->update([
                'id_job' => $resultado,
                'result' => "http://172.22.16.179:443/$id_asgard",
            ]);
            return redirect()->route('executionLogs.show',$id_asgard);
        }


    public function getServicesByHost(Request $request) {

            $this->validate($request, [
                'host' => 'required'
            ]);

            $idTemplate = 459;
            $log = $this->getLog(3,13,$idTemplate);
            $id_asgard = $log->id;

            $variables = array("extra_vars" =>
                [
                    "HOST"  => $request->host,
                    "id_asgard" => $id_asgard
                ]
            );

            $resultado = $this->runPlaybook($idTemplate,$variables);

            $resultado = $resultado['job'];

            $log->update([
                'id_job' => $resultado,
            ]);
            $finalRequest = [
                "id_job"    => $resultado,
                "url"       => "file/-WINDOWS-WIN_GETSERVICES_002/".$id_asgard.".json"
            ];

            return response()->json(["data" => $finalRequest]);
    }

}
