<?php

namespace App\Http\Controllers;

use App\Inventory;
use Illuminate\Http\Request;
use App\Http\Traits\ConnectionTrait;

class AmtController extends Controller
{
    Use ConnectionTrait;
    private $method = "local";

    public function soa()
    {
        $inventario = 18;
        $groups = Inventory::where('id_inventory',$inventario)->where('name_group','like',"%WEBLOGIC")->distinct('name_group')->orderBy('name_group')->pluck('name_group');
        return view('amt.soa',compact('groups','inventario'));
    }


    public function soaStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 57;
        $log = $this->getLog(3,12,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host,));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);*/
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
    public function fuse()
    {
        $inventario = 18;
        $groups = Inventory::where('id_inventory',$inventario)->where('name_group','like',"%FUSE")->distinct('name_group')->orderBy('name_group')->pluck('name_group');
        return view('amt.fuse',compact('groups','inventario'));
    }


    public function fuseStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 59;
        $log = $this->getLog(3,12,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);*/
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
    public function backupFormas()
    {
        $inventario = 18;
        $groups = Inventory::where('id_inventory',$inventario)->where('name_group',"FIDUOCCIDENTE_WEBLOGIC")->distinct('name_group')->orderBy('name_group')->pluck('name_group');
        return view('amt.backupFormas',compact('groups','inventario'));
    }


    public function backupFormasStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 101;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);*/
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'result' => "http://172.22.16.179:443/$id_asgard",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
    public function movimientoFormas()
    {
        $inventario = 18;
        $groups = Inventory::where('id_inventory',$inventario)->where('name_group',"FIDUOCCIDENTE_WEBLOGIC")->distinct('name_group')->orderBy('name_group')->pluck('name_group');
        return view('amt.movimientoFormas',compact('groups','inventario'));
    }


    public function movimientoFormasStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 108;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);*/
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'result' => "http://172.22.16.179:443/$id_asgard",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
    public function appTomcatUnix()
    {
        $inventario = 18;
        $groups = Inventory::where('id_inventory',$inventario)->where('name_group','like',"%TOMCAT")->distinct('name_group')->orderBy('name_group')->pluck('name_group');
        return view('amt.appTomcatUnix',compact('groups','inventario'));
    }


    public function appTomcatUnixStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 109;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);*/
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'result' => "http://172.22.16.179:443/$id_asgard",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
    public function appTomcatWindows()
    {
        $inventario = 25;
        $groups = Inventory::where('id_inventory',$inventario)->where('name_group','like',"%TOMCAT")->distinct('name_group')->orderBy('name_group')->pluck('name_group');
        return view('amt.appTomcatWindows',compact('groups','inventario'));
    }


    public function appTomcatWindowsStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 110;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);*/
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
    public function checkSanidad()
    {
        $inventario = 18;
        $groups = Inventory::where('id_inventory',$inventario)->where('name_group','like',"%WEBLOGIC")->distinct('name_group')->orderBy('name_group')->pluck('name_group');
        return view('amt.checkSanidad',compact('groups','inventario'));
    }


    public function checkSanidadStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 111;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);*/
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'result' => "http://172.22.16.179:443/$id_asgard",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
    public function parcheWeblogic()
    {
        $inventario = 18;
        $groups = Inventory::where('id_inventory',$inventario)->where('name_group','like',"%WEBLOGIC")->distinct('name_group')->orderBy('name_group')->pluck('name_group');
        return view('amt.parcheWeblogic',compact('groups','inventario'));
    }


    public function parcheWeblogicStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 112;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);*/
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'result' => "http://172.22.16.179:443/$id_asgard",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
    public function webReports()
    {
        $inventario = 18;
        $groups = Inventory::where('id_inventory',$inventario)->where('name_group','like',"%WEBLOGIC")->distinct('name_group')->orderBy('name_group')->pluck('name_group');
        return view('amt.webReports',compact('groups','inventario'));
    }


    public function webReportsStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 159;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1000;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
            'result' => "http://172.22.16.179:443/$id_asgard",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
    public function checkPasoTomcat()
    {
        return view('amt.checkPasoTomcat');
    }

    public function checkPasoTomcatStore(Request $request)
    {
        $this->validate($request, [
            'hosts' => 'required|string',
            'path' => 'required|string',
            'username' => 'required|string',
        ]);
        $idInventory = 47;
        $hosts = explode(',',$request->hosts);
        $hostId = '';
        foreach($hosts as $host){
            $variables = array("name" => "UNX-".$host, "description" => "Host agregado por Asgard", "enabled" => true, "instance_id" => "",
            "variables" => "ansible_host: $host");
            //dd(json_encode($variables));
            $hostId = $this->addHostToInventory($idInventory,$variables,"UNX-".$host);
            if ($host === reset($hosts)) {
                $idHosts = $hostId;
            }else{
                $idHosts = $idHosts .','. $hostId;
            }
        }

        //dd($request->hosts);
        $idTemplate = 207;
        $log = $this->getLog(4,12,$idTemplate,1,2);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("id_asgard" => $id_asgard,"path" => $request->input('path'), "user" => $request->input('username')));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
            'result' => "http://172.22.16.179:443/$id_asgard",
            'host_id_list' => $idHosts,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function healthCheck()
    {
        $inventario = 18;
        $groups = Inventory::where('id_inventory',$inventario)->distinct('name_group')->orderBy('name_group')->pluck('name_group');
        return view('amt.healthCheck',compact('groups','inventario'));
    }

    public function healthCheckStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        //dd($request->hosts);
        $idTemplate = 278;
        $log = $this->getLog(4,12,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = "test1";
        $variables = array("extra_vars" => array("HOST" => $request->host,"id_asgard" => $id_asgard,"email" => "no_enviar"));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
            'result' => "http://172.22.16.179:443/$id_asgard",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function connectDB()
    {
        $inventario = 18;
        $groups = Inventory::where('id_inventory',$inventario)->distinct('name_group')->orderBy('name_group')->pluck('name_group');
        return view('amt.connectDB',compact('groups','inventario'));
    }

    public function connectDBStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        //dd($request->hosts);
        $idTemplate = 284;
        $log = $this->getLog(4,12,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = "test1";
        $variables = array("extra_vars" => array("HOST" => $request->host,"id_asgard" => $id_asgard,"email" => "no_enviar"));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
            'result' => "http://172.22.16.179:443/$id_asgard",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function checkPOWebLogic()
    {
        $inventario = 18;
        $groups = Inventory::where('id_inventory',$inventario)->distinct('name_group')->orderBy('name_group')->pluck('name_group');
        return view('amt.checkPOWebLogic',compact('groups','inventario'));
    }

    public function checkPOWebLogicStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'path' => 'required|string|min:1|max:20',
            'user' => 'required|string|min:1|max:20',
        ]);
        //dd($request->hosts);
        $idTemplate = 269;
        $log = $this->getLog(4,12,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = "test1";
        $variables = array("extra_vars" => array("HOST" => $request->host,"id_asgard" => $id_asgard,"path" => $request->input('path'), "user" => $request->input('user') ));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
            'result' => "http://172.22.16.179:443/$id_asgard",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function appTomcatUnixPCCAAS()
    {
        $inventario = 18;
        $groups = Inventory::where('id_inventory',$inventario)->where('name_group',"PCAAS_TOMCAT")->distinct('name_group')->orderBy('name_group')->pluck('name_group');
        return view('amt.appTomcatUnixPCCAAS',compact('groups','inventario'));
    }


    public function appTomcatUnixPCCAASStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 109;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);*/
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'result' => "http://172.22.16.179:443/$id_asgard",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
}
