<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\ConnectionTrait;

class ImplementationController extends Controller
{
    Use ConnectionTrait;
    private $method = "local";
    private $other="api";

    public function normalizacionW()
    {
        return view('implementations.normalizacionW');
    }


    public function normalizacionWStore(Request $request)
    {
        //$idTemplate = 131;
        $idTemplate = 124;
        $idInventory = 30;
        $log = $this->getLog(3,13,$idTemplate,1,2);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("name" => "Imp-".$request->ip, "description" => "Host agregado por Asgard", "enabled" => true, "instance_id" => "",
            "variables" => "ansible_host: $request->ip\nansible_connection: winrm\nansible_winrm_server_cert_validation: ignore\nansible_user: $request->username\nansible_password: $request->password");
        //dd(json_encode($variables));
        $hostId = $this->addHostToInventory($idInventory,$variables,"Imp-".$request->ip);
        //dd($hostId);
        $resultado = $this->runPlaybook($idTemplate);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'host_id_list' => $hostId,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
    public function hardeningW()
    {
        return view('implementations.hardeningW');
    }


    public function hardeningWStore(Request $request)
    {
        $idTemplate = 126;
        $idInventory = 31;
        $log = $this->getLog(3,13,$idTemplate,1,2);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("name" => "Imp-".$request->ip, "description" => "Host agregado por Asgard", "enabled" => true, "instance_id" => "",
            "variables" => "ansible_host: $request->ip\nansible_connection: winrm\nansible_winrm_server_cert_validation: ignore\nansible_user: $request->username\nansible_password: $request->password");
        //dd(json_encode($variables));
        $hostId = $this->addHostToInventory($idInventory,$variables,"Imp-".$request->ip);
        //dd($hostId);
        $resultado = $this->runPlaybook($idTemplate);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'host_id_list' => $hostId,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
    public function licenciamientoW()
    {
        return view('implementations.licenciamientoW');
    }

    public function licenciamientoWStore(Request $request)
    {
        $idTemplate = 125;
        $idInventory = 32;
        $log = $this->getLog(3,13,$idTemplate,1,2);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("name" => "Imp-".$request->ip, "description" => "Host agregado por Asgard", "enabled" => true, "instance_id" => "",
            "variables" => "ansible_host: $request->ip\nansible_connection: winrm\nansible_winrm_server_cert_validation: ignore\nansible_user: $request->username\nansible_password: $request->password");
        //dd(json_encode($variables));
        $hostId = $this->addHostToInventory($idInventory,$variables,"Imp-".$request->ip);
        //dd($hostId);
        $resultado = $this->runPlaybook($idTemplate);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'host_id_list' => $hostId,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
    public function tetrationW()
    {
        return view('implementations.tetrationW');
    }


    public function tetrationWStore(Request $request)
    {
        $idTemplate = 123;
        $idInventory = 29;
        $log = $this->getLog(3,13,$idTemplate,1,2);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("name" => "Imp-".$request->ip, "description" => "Host agregado por Asgard", "enabled" => true, "instance_id" => "",
            "variables" => "ansible_host: $request->ip\nansible_connection: winrm\nansible_winrm_server_cert_validation: ignore\nansible_user: $request->username\nansible_password: $request->password");
        //dd(json_encode($variables));
        $hostId = $this->addHostToInventory($idInventory,$variables,"Imp-".$request->ip);
        //dd($hostId);
        $resultado = $this->runPlaybook($idTemplate);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'host_id_list' => $hostId,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }

    public function antivirusW()
    {
        return view('implementations.antivirusW');
    }


    public function antivirusWStore(Request $request)
    {
        $this->validate($request, [
            'hosts' => 'required|string',
        ]);
        $idInventory = 34;
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
                $hostList .= ";Imp-".$host;
            }
        }
        $idTemplate = 135;
        $log = $this->getLog(3,13,$idTemplate,1,2);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        //dd($hostId);
        $variables = array("extra_vars" => array("HOST" => $hostList));
        //dd($variables);
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
            'host_id_list' => $hostId,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }

    public function checkPasoWin()
    {
        return view('implementations.checkPasoWin');
    }


    public function checkPasoWinStore(Request $request)
    {
        $this->validate($request, [
            'hosts' => 'required|string',
            'operation' => 'required',
            'stage' => 'required',
        ]);
        $idInventory = 34;
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
        $idTemplate = 338;
        //$log = $this->getLog(4,13,$idTemplate,1,2);
        $log = $this->getLog(5,13,$idTemplate,1,2);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        //dd($hostId);
        $variables = array("extra_vars" => array("HOST" => $hostList,"operation" => $request->input('operation'),"id_asgard" => $id_asgard, "stage" => $request->input('stage')));
        //dd($variables);
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
            'host_id_list' => $hostId,
            //'result' => "http://172.22.16.179:443/$id_asgard",
            'result' => "/IMPLEMENTACION/IMP_TR_001/$id_asgard.html",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
    public function checkPasoUnix()
    {
        return view('implementations.checkPasoUnix');
    }


    public function checkPasoUnixStore(Request $request)
    {
        $this->validate($request, [
            'hosts' => 'required|string',
            'operation' => 'required',
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
        $idTemplate = 340;
        //$log = $this->getLog(4,13,$idTemplate,1,2);
        $log = $this->getLog(5,13,$idTemplate,1,2);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        //dd($hostId);
        $variables = array("extra_vars" => array("HOST" => $hostList,"operation" => $request->input('operation'),"id_asgard" => $id_asgard));
        //dd($variables);
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
            'host_id_list' => $hostId,
            //'result' => "http://172.22.16.179:443/$id_asgard",
            'result' => "/IMPLEMENTACION/IMP_TR_002/$id_asgard.html",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
    //_______________ ⬇⬇ Actualizacion Bash a YAML Linux⬇⬇ ________________

public function hardeningUnix() 
{
    $inventario = 106;
    $groups = $this->getGroups($inventario,$this->other);
    return view('implementations.hardeningUnix',compact('groups','inventario'));
}

public function hardeningUnixStore(Request $request) 
{
    $this->validate($request, [
        'host' => 'required',
    ]);
    $idTemplate = 518;
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
