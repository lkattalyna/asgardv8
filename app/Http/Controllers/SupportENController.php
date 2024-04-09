<?php

namespace App\Http\Controllers;

use App\OsGroup;
use App\Inventory;
use Illuminate\Http\Request;
use App\Http\Traits\ConnectionTrait;

class SupportENController extends Controller
{
    //Definición de variables globales del controlador
    Use ConnectionTrait;
    private $method = "local";

    public function checkAD()
    {
        $inventario = 56;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('supportEN/windows/checkAD',compact('groups','inventario'));
    }

    public function checkADStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 243;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1002;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard));
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
    public function checkCPUProcess()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);
        return view('supportEN/windows/checkCPUProcess',compact('groups','inventario'));
    }

    public function checkCPUProcessStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 313;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard ));
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
    public function checkSO()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('supportEN/windows/checkSO',compact('groups','inventario'));
    }

    public function checkSOStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 167;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1002;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard));
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
    public function preVentana()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('supportEN/windows/preVentana',compact('groups','inventario'));
    }

    public function preVentanaStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 244;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1002;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard));
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
    public function postVentana()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);
        return view('supportEN/windows/postVentana',compact('groups','inventario'));
    }

    public function postVentanaStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 245;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1002;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard));
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
    public function freeMemory()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);
        return view('supportEN/windows/freeMemory',compact('groups','inventario'));
    }

    public function freeMemoryStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 80;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'result' => "http://172.22.16.179:443/$id_asgard",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function debuggingDisks()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);
        return view('supportEN/windows/debuggingDisks',compact('groups','inventario'));
    }

    public function debuggingDisksStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 373;
        $log = $this->getLog(5,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard ));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
            'result' => "/WINDOWS/WIN_EN_001/$id_asgard.html",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function sevenSteps()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);
        return view('supportEN/windows/sevenSteps',compact('groups','inventario'));
    }
    public function sevenStepsStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 70;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'result' => "http://172.22.16.179:443/$id_asgard",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }

    public function createUser()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);
        $grupos = OsGroup::where('flag',$inventario)->where('show_to','all')->orderBy('name')->get();
        return view('supportEN/windows/createUser',compact('groups','inventario','grupos'));
    }
    public function createUserStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'tipo' => 'required',
            'name' => 'required',
            'ident' => 'required',
            'email' => 'required|email',
            'username' => 'required',
            'password' => 'required',
            'grupo' => 'required',
            'case' => 'required',
        ]);
        $idTemplate = 72; // creacion y eliminacion de usuarios
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "rdp_user"=> $request->username, "rdp_password" => $request->password, "rdp_case" => $request->case,
        "item" => 'Creacion', "item2" => $request->tipo, "rdp_groups" => $request->grupo, "rdp_cedula" => $request->ident, "rdp_correo" => $request->email,
        "rdp_fulluser" => $request->name, "id_asgard" => $id_asgard ));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function changePassUser()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);
        $grupos = OsGroup::where('flag',$inventario)->where('show_to','all')->orderBy('name')->get();
        return view('supportEN/windows/changeUser',compact('groups','inventario','grupos'));
    }
    public function changePassUserStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'tipo' => 'required',
            'username' => 'required',
            'password' => 'required',
            'case' => 'required',
        ]);
        $idTemplate = 72; // creacion y eliminacion de usuarios
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "rdp_user"=> $request->username, "rdp_password" => $request->password, "rdp_case" => $request->case,
        "item" => 'Reset', "item2" => $request->tipo, "id_asgard" => $id_asgard));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function disableUser()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);
        return view('supportEN/windows/disableUser',compact('groups','inventario'));
    }
    public function disableUserStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'tipo' => 'required',
            'username' => 'required',
            'case' => 'required',
            'status' => 'required',
        ]);
        $idTemplate = 72; // creacion y eliminacion de usuarios
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "rdp_user"=> $request->username, "rdp_case" => $request->case, "rdp_disable" => $request->status,
        "item" => 'Disable', "item2" => $request->tipo, "id_asgard" => $id_asgard));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function deleteUser()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);
        $grupos = OsGroup::where('flag',$inventario)->where('show_to','all')->orderBy('name')->get();
        return view('supportEN/windows/deleteUser',compact('groups','inventario','grupos'));
    }
    public function deleteUserStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'tipo' => 'required',
            'username' => 'required',
            'case' => 'required',
        ]);
        $idTemplate = 72; // creacion y eliminacion de usuarios
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "rdp_user"=> $request->username, "rdp_case" => $request->case,
        "item" => 'Eliminacion', "item2" => $request->tipo, "id_asgard" => $id_asgard));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function editUser()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);
        $grupos = OsGroup::where('flag',$inventario)->where('show_to','all')->orderBy('name')->get();
        return view('supportEN/windows/editUser',compact('groups','inventario','grupos'));
    }
    public function editUserStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'tipo' => 'required',
            'name' => 'required',
            'ident' => 'required',
            'email' => 'required|email',
            'username' => 'required',
            'grupo' => 'required',
            'case' => 'required',
        ]);
        $idTemplate = 72; // creacion y eliminacion de usuarios
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "rdp_user"=> $request->username, "rdp_case" => $request->case,
        "item" => 'Modificacion', "item2" => $request->tipo, "rdp_groups" => $request->grupo, "rdp_cedula" => $request->ident, "rdp_correo" => $request->email,
        "rdp_fulluser" => $request->name, "id_asgard" => $id_asgard));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function extParches()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);
        return view('supportEN/windows/extParches',compact('groups','inventario'));
    }
    public function extParchesStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 119;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'result' => "http://172.22.16.179:443/$id_asgard",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function extUptime()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('supportEN/windows/extUptime',compact('groups','inventario'));
    }

    public function extUptimeStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 230;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1002;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard));
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
    public function inventario()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);
        return view('supportEN/windows/inventario',compact('groups','inventario'));
    }
    public function inventarioStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 120;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'result' => "http://172.22.16.179:443/$id_asgard",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function rutasEstaticas()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('supportEN/windows/rutasEstaticas',compact('groups','inventario'));
    }

    public function rutasEstaticasStore(Request $request)
    {
        if($request->item == 'adds'){
            $this->validate($request, [
                'host' => 'required',
                'item' => 'required',
                'destination' => 'required|ipv4',
                'gateway' => 'required|ipv4',
                'metric' => 'required|integer',
                'mask' => 'required|ipv4',

            ]);
        }elseif($request->item == 'deletes'){
            $this->validate($request, [
                'host' => 'required',
                'item' => 'required',
                'destination' => 'required|ipv4',
            ]);
        }

        $idTemplate = 100;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        if($request->item == 'adds'){
            $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard, "item" => $request->item, "item_destination" => $request->destination,
                    "item_gateway" => $request->gateway, "item_mask" => $request->mask, "item_metric" => $request->metric));
        }elseif($request->item == 'deletes'){
            $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard, "item" => $request->item, "item_destination" => $request->destination));
        }
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'result' => "http://172.22.16.179:443/$id_asgard",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }



    public function serviceManagementV2()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('supportEN.windows.serviceManagementV2EN',compact('groups','inventario'));
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
            $idTemplate = 262;
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

            $idTemplate = 473;
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










        // UNIX FUNCTIONS
    public function unixRutasEstaticas()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        return view('supportEN.unix.rutasEstaticas',compact('groups','inventario'));
    }

    public function unixRutasEstaticasStore(Request $request)
    {
        
        $this->validate($request, [
            'host' => 'required',
            'action' => 'required',
            'interface' => 'required',
            'ip' => 'required|ipv4',
            'mask' => 'required|integer',

        ]);
        $idTemplate = 122;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard, "action" => $request->action, "interface" => $request->interface,
                    "ip" => $request->ip, "mask" => $request->mask));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'result' => "http://172.22.16.179:443/$id_asgard",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }



    public function unixPortListen()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        return view('supportEN.unix.portListen',compact('groups','inventario'));
    }

    public function unixPortListenStore(Request $request)
    {
        
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 202;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
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


    public function testConectividadUnix(){
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unix.connectivityUnix',compact('groups','inventario'));
    }

    public function testConectividadUnixStore(Request $request){
        
        $campos = $request->all();
        $HOST = $campos["host"][0];
        $ips_ping_destino = array_values($campos["ipDestino"]);
        $ips_telnet_destino = array_values($campos["ipTelnet"]);
        $ports_telnet_destino = array_values($campos["puertoTelnet"]);
        $telnet_opts= array();
        $do_ping    = "false";
        $do_telnet  = "false";
        $do_tracert = "false";
        $idTemplate = 470;
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





    public function unixFolderPermission()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        return view('supportEN.unix.folderPermission',compact('groups','inventario'));
    }

    public function unixFolderPermissionStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'option' => 'required|string',
            'path' => 'required|string|min:1|max:200',
        ]);
        if($request->input('option') == 'NO_recursivo_owner' || $request->input('option') == 'RECURSIVO_owner'){
            $this->validate($request, [
                'owner' => 'required|string|min:1',
            ]);
        }elseif($request->input('option') == 'NO_recursivo_permisos' || $request->input('option') == 'RECURSIVO_permisos'){
            $this->validate($request, [
                'ugo' => 'required|string|min:3|max:3',
            ]);
        }elseif ($request->input('option') == 'NO_RECURSIVO_permisos_propietario' || $request->input('option') == 'RECURSIVO_permisos_propietario') {
            $this->validate($request, [
                'owner' => 'required|string|min:1',
                'ugo' => 'required|string|min:3|max:3',
            ]);
        }
        $idTemplate = 306;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        if($request->input('option') == 'NO_recursivo_owner' || $request->input('option') == 'RECURSIVO_owner'){
            $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard, 'options' => $request->input('option'),
            'path' => $request->input('path'),'owner' => $request->input('owner')));
        }elseif($request->input('option') == 'NO_recursivo_permisos' || $request->input('option') == 'RECURSIVO_permisos'){
            $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard, 'options' => $request->input('option'),
            'path' => $request->input('path'), 'ugo' => $request->input('ugo')));
        }elseif ($request->input('option') == 'NO_RECURSIVO_permisos_propietario' || $request->input('option') == 'RECURSIVO_permisos_propietario') {
            $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard, 'options' => $request->input('option'),
            'path' => $request->input('path'), 'owner' => $request->input('owner'),'ugo' => $request->input('ugo')));
        }
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


    public function unixFreeMemory()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        return view('supportEN.unix.freeMemory',compact('groups','inventario'));
    }

    public function unixFreeMemoryStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 54; // creacion y eliminacion de usuarios
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'result' => "http://172.22.16.179:443/$id_asgard",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }

    public function unixUptime()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        return view('supportEN.unix.uptime',compact('groups','inventario'));
    }

    public function unixUptimeStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 160;
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



    public function unixCleanFileSystem()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unix.cleanFileSystem',compact('groups','inventario'));
    }

    public function unixCleanFileSystemStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 365;
        $log = $this->getLog(5,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
            'result' => "/UNIX/UNX_EN_018/$id_asgard.html",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }

    public function unixRestartServices()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        return view('supportEN.unix.restartServices',compact('groups','inventario'));
    }

    public function unixRestartServicesStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'op' => 'required|string',
            'service' => 'required|string|min:1|max:50',
        ]);
        $idTemplate = 357;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "service_state" => $request->input('op'), "service_name" => $request->input('service')));
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


    public function unixInventario()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        return view('supportEN.unix.inventario',compact('groups','inventario'));
    }

    public function unixInventarioStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 114;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'result' => "http://172.22.16.179:443/$id_asgard",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }



    public function unixCreate()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        $grupos = OsGroup::where('flag',$inventario)->where('show_to','all')->orderBy('name')->get();
        return view('supportEN.unix.create',compact('groups','inventario','grupos'));
    }

    public function unixCreateStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'name' => 'required',
            'ident' => 'required',
            'email' => 'required|email',
            'username' => 'required',
            'password' => 'required',
            'grupo' => 'required',
            'case' => 'required',
        ]);
        $idTemplate = 55; // creacion y eliminacion de usuarios
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "user"=> strtolower($request->username), "password" => $request->password, "case" => $request->case,
        "action" => 'Creacion',"group" => $request->grupo, "cedula" => $request->ident, "email" => $request->email, "fullname" => $request->name, "id_asgard" => $id_asgard));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }


    public function unixChange()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        return view('supportEN.unix.change',compact('groups','inventario'));
    }

    public function unixChangeStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);
        $idTemplate = 55; // creacion y eliminacion de usuarios
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "user"=> $request->username, "password" => $request->password, "action" => 'Reset',
        "id_asgard" => $id_asgard));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }



    public function unixDelete()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        return view('supportEN.unix.delete',compact('groups','inventario'));
    }

    public function unixDeleteStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'username' => 'required',
        ]);
        $idTemplate = 55; // creacion y eliminacion de usuarios
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "user"=> $request->username, "action" => 'Eliminacion', "id_asgard" => $id_asgard));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }



    public function unixDisable()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        return view('supportEN.unix.disable',compact('groups','inventario'));
    }

    public function unixDisableStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'username' => 'required',
        ]);
        $idTemplate = 55; // creacion y eliminacion de usuarios
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "user"=> $request->username, "action" => 'Deshabilitacion', "id_asgard" => $id_asgard));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }

}
