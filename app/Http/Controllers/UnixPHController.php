<?php

namespace App\Http\Controllers;

use App\OsGroup;
use Illuminate\Http\Request;
use App\Http\Traits\ConnectionTrait;

class UnixPHController extends Controller
{
    Use ConnectionTrait;
    private $method = "api";

    public function create()
    {
        $inventario = 21;
        $groups = $this->getGroups($inventario,$this->method);
        $grupos = OsGroup::where('flag',$inventario)->where('show_to','all')->orderBy('name')->get();
        return view('unixPH.create',compact('groups','inventario','grupos'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'username' =>'required',
            'password' => 'required',
            'caso' => 'required',
            'grupo' => ' required',
        ]);
        $idTemplate = 89; // creacion y eliminacion de usuarios
        $log = $this->getLog(3,12,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "USERNAME"=> strtolower($request->username), "PASSWORD" => $request->password, "case" => $request->caso,
        "action" => 'add',"GROUP" => $request->grupo, "comment" => $request->comment, "id_asgard" => $id_asgard));
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

    public function sevenSteps()
    {
        $inventario = 21;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unix.sevenSteps',compact('groups','inventario'));
    }


    public function sevenStepsStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $variables = array("extra_vars" => array("HOST" => $request->host,));
        $idTemplate = 52;
        //dd($variables);
        $log = $this->getLog(3,12,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
    public function change()
    {
        $inventario = 21;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unixPH.change',compact('groups','inventario'));
    }

    public function changeStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'username' => 'required',
            'password' => 'required',
            'caso' => 'required',
        ]);
        $idTemplate = 89; // creacion y eliminacion de usuarios
        $log = $this->getLog(3,12,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "USERNAME"=> strtolower($request->username), "PASSWORD" => $request->password, "case" => $request->caso,
        "action" => 'Change',"GROUP" => $request->grupo,"VAL_SUBGRUPOS" => $request->val_subgrupos,"SUB_GROUP" => $request->sub_grupo, "comment" => $request->comment, "id_asgard" => $id_asgard));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }

    public function delete()
    {
        $inventario = 21;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unixPH.delete',compact('groups','inventario'));
    }

    public function deleteStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'username' => 'required',
        ]);
        $idTemplate = 89; // creacion y eliminacion de usuarios
        $log = $this->getLog(3,12,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "user"=> $request->username, "action" => 'Eliminacion'));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }

    public function freeMemory()
    {
        $inventario = 21;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unix.freeMemory',compact('groups','inventario'));
    }

    public function freeMemoryStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 54;
        $variables = array("extra_vars" => array("HOST" => $request->host));
        //dd(json_encode($variables));
        $log = $this->getLog(3,12,$idTemplate);

        $id_asgard = $log->id;
        //$id_asgard = 1;
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }

    public function unlock()
    {
        $inventario = 21;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unixPH.unlock',compact('groups','inventario'));
    }

    public function unlockStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'username' => 'required',
        ]);
        $idTemplate = 89; // creacion y eliminacion de usuarios
        $log = $this->getLog(3,12,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "USERNAME"=> $request->username,
        "action" => 'Unlock'));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }


    public function lineabase()
    {
        $inventario = 21;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unixPH.lineabase',compact('groups','inventario'));
    }

    public function dnsclaro()
    {
        $inventario = 21;
        $groups = $this->getGroups($inventario,$this->method);
        $grupos = OsGroup::where('flag',$inventario)->where('show_to','all')->orderBy('name')->get();
        return view('unixPH.dnsclaro',compact('groups','inventario','grupos'));
    }


    public function dnsclaroStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 147;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host));
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
    public function uptimeRelease()
    {
        return view('unixPH.uptimeRelease');
    }
    public function uptime()
    {
        return view('unixPH.uptime');
    }
    public function checkPlatforms()
    {
        return view('unixPH.checkPlatforms');
    }
    public function checkPasoUnix()
    {
        return view('unixPH.checkPasoUnix');
    }
    public function checkPasoUnixStore(Request $request)
    {
        $this->validate($request, [
            'hosts' => 'required|string',
        ]);
        $idInventory = 68;
        $hosts = explode(',',$request->hosts);
        $hostId = '';
        $idHosts = "";
        $hostList = "";
        foreach($hosts as $host){
            $variables = array("name" => "Imp-".$host, "description" => "Host agregado por Asgard", "enabled" => true, "instance_id" => "",
            "variables" => "ansible_host: $host");
            //dd(json_encode($variables));
            $hostId = $this->addHostToInventory($idInventory,$variables,"Imp-".$host);
            if ($host === reset($hosts)) {
                $idHosts = $hostId;
                $hostList = "Imp-".$host;
            }else{
                $idHosts = $idHosts .','. $hostId;
                $hostList .= ",Imp-".$host;
            }
        }
        $idTemplate = 367;
        $log = $this->getLog(5,13,$idTemplate,1,2);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        //dd($hostId);
        $variables = array("extra_vars" => array("HOST" => $hostList,"operation" => 'PH',"id_asgard" => $id_asgard));
        //dd($variables);
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
            'host_id_list' => $hostId,
            'result' => "/UNIX/UNX_PH_002/$id_asgard.html",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
    public function checkSOUnix()
    {
        $inventario = 94; //77
        $groups = $this->getGroups($inventario,$this->method);
        //dd($groups);
        return view('unixPH/sevenStepsPH',compact('groups','inventario'));
    }

    public function checkSOUnixStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 375;
        $log = $this->getLog(5,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1002;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
            'result' => "/UNIX/UNX_PH_001/$id_asgard.html",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function prevalidation()
    {
        $inventario = 77;
        $groups = $this->getGroups($inventario,$this->method);
        //dd($groups);
        return view('unixPH.prevalidation',compact('groups','inventario'));
    }

    public function prevalidationStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'case' => 'required',
        ]);
        return redirect()->route('unixPH.prevalidation');

        /*
        $idTemplate = 0;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("server" => $request->host, "casech" => $request->host));
        dd(json_encode($variables));
        /*
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);*/
    }
    public function restart()
    {
        $inventario = 77;
        $groups = $this->getGroups($inventario,$this->method);
        //dd($groups);
        return view('unixPH.restart',compact('groups','inventario'));
    }

    public function restartStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'case' => 'required',
        ]);
        return redirect()->route('unixPH.restart');

        /*
        $idTemplate = 0;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("server" => $request->host, "casech" => $request->host));
        dd(json_encode($variables));
        /*
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);*/
    }
    public function validation()
    {
        $inventario = 77;
        $groups = $this->getGroups($inventario,$this->method);
        //dd($groups);
        return view('unixPH.validation',compact('groups','inventario'));
    }

    public function validationStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'case' => 'required',
        ]);
        return redirect()->route('unixPH.validation');

        /*
        $idTemplate = 0;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("server" => $request->host, "casech" => $request->host));
        dd(json_encode($variables));
        /*
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);*/
    }
    public function uploadDb()
    {
        $inventario = 77;
        $groups = $this->getGroups($inventario,$this->method);
        //dd($groups);
        return view('unixPH.uploadDb',compact('groups','inventario'));
    }

    public function uploadDbStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'case' => 'required',
        ]);
        return redirect()->route('unixPH.uploadDb');

        /*
        $idTemplate = 0;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("server" => $request->host, "casech" => $request->host));
        dd(json_encode($variables));
        /*
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);*/
    }
    public function validationNFSVenecia()
    {
        $inventario = 55;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unixPH.validationNFSVenecia',compact('groups','inventario'));
    }

    public function validationNFSVeneciaStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            //'username' => 'required',
        ]);
        $idTemplate = 410; // creacion y eliminacion de usuarios
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }

	public function testConectividadUnixPH(){
    $inventario = 77;
    $groups = $this->getGroups($inventario,$this->method);
    return view('unixPH.connectivityUnixPH',compact('groups','inventario'));
}

public function testConectividadUnixPHStore(Request $request){

    $campos = $request->all();
    $HOST = $campos["host"][0];
    $ips_ping_destino = array_values($campos["ipDestino"]);
    $ips_telnet_destino = array_values($campos["ipTelnet"]);
    $ports_telnet_destino = array_values($campos["puertoTelnet"]);
    $telnet_opts= array();
    $do_ping    = "false";
    $do_telnet  = "false";
    $do_tracert = "false";
    $idTemplate = 471;
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
            $history = $this->gethistory($id_asgard,$ping,$obj,$obj,5,$idTemplate);
       }
   }
   if($do_tracert =='true'){
    $tracert = 'tracert';
        foreach($ips_ping_destino as $obj){
            $history = $this->gethistory($id_asgard,$tracert,$obj,$obj,5,$idTemplate);
        }
   }
   if($do_telnet =='true'){
    $telnet = 'telnet';
        foreach($telnet_opts as $obj){
            $history = $this->gethistory($id_asgard,$telnet,implode(':',$obj),implode(':',$obj),5,$idTemplate);
        }
   }
   $resultado = $resultado['job'];
   $log->update([
       'id_job' => $resultado,
       'result' => "/UNIX/UNIX_CONECTIVIDAD_001/$id_asgard.html",
   ]);
   return redirect()->route('executionLogs.show',$id_asgard);
}

//_______________ ⬇⬇ Actualizacion Bash a YAML HPUX⬇⬇ ________________

public function UpBashYaml()
    {
        $inventario = 103;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unixPH.UpBashYaml',compact('groups','inventario'));
    }

    public function UpBashYamlStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 490;
        $log = $this->getLog(5,13,$idTemplate);
        $id_asgard = $log->id;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'result' => "/UNIX/checkPasoOperacionUnix/$id_asgard.html",
            //'result' => "/UNIX/LINUX/UNIX_CHECK_PASO_OP_001/$id_asgard.html",
            //'result' => "http://172.22.16.179:443/$id_asgard",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
//____________________________________________________________________________
//_______________ ⬇⬇ Actualizacion Bash a YAML Linux⬇⬇ ________________

public function UpBashYamlLinux()
    {
        $inventario = 106;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unixPH.UpBashYamlLinux',compact('groups','inventario'));
    }

    public function UpBashYamlLinuxStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 495;
        $log = $this->getLog(5,13,$idTemplate);
        $id_asgard = $log->id;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'result' => "/UNIX/checkPasoOperacionUnix/$id_asgard.html",
            //'result' => "/UNIX/LINUX/UNIX_CHECK_PASO_OP_001/$id_asgard.html",

        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
//____________________________________________________________________________
//_______________ ⬇⬇ Actualizacion Bash a YAML SUN⬇⬇ ________________

public function UpBashYamlSUN()
    {
        $inventario = 104;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unixPH.UpBashYamlSUN',compact('groups','inventario'));
    }

    public function UpBashYamlSUNStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 502;
        $log = $this->getLog(5,13,$idTemplate);
        $id_asgard = $log->id;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'result' => "/UNIX/checkPasoOperacionUnix/$id_asgard.html",
            //'result' => "/UNIX/LINUX/UNIX_CHECK_PASO_OP_001/$id_asgard.html",

        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
//____________________________________________________________________________
//_______________ ⬇⬇ Actualizacion Bash a YAML AIX⬇⬇ ________________

public function UpBashYamlAIX()
    {
        $inventario = 105;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unixPH.UpBashYamlAIX',compact('groups','inventario'));
    }

    public function UpBashYamlAIXStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 500;
        $log = $this->getLog(5,13,$idTemplate);
        $id_asgard = $log->id;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'result' => "/UNIX/checkPasoOperacionUnix/$id_asgard.html",
            //'result' => "/UNIX/LINUX/UNIX_CHECK_PASO_OP_001/$id_asgard.html",

        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
//____________________________________________________________________________


}
