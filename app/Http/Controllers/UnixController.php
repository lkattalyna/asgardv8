<?php

namespace App\Http\Controllers;

use App\OsGroup;
use App\Inventory;
use Illuminate\Http\Request;
use App\Http\Traits\ConnectionTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UnixController extends Controller
{
    Use ConnectionTrait;
    private $method = "local";

    public function create()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        $grupos = OsGroup::where('flag',$inventario)->where('show_to','all')->orderBy('name')->get();
        return view('unix.create',compact('groups','inventario','grupos'));
    }

    public function store(Request $request)
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
    public function createAdm()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        $grupos = OsGroup::where('flag',$inventario)->where('show_to','unixAdmin')->orderBy('name')->get();
        return view('unix.createAdm',compact('groups','inventario','grupos'));
    }

    public function createAdmStore(Request $request)
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

    public function sevenSteps()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unix.sevenSteps',compact('groups','inventario'));
    }


    public function sevenStepsStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 52;
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

    public function sevenStepsFreeMemory()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unix.sevenStepsFreeMemory',compact('groups','inventario'));
    }


    public function sevenStepsFreeMemoryStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 498;
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

    public function change()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unix.change',compact('groups','inventario'));
    }

    public function changeStore(Request $request)
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
    public function resetUserByAD()
    {
        $inventario = 16;
        $username = strtolower(Auth::user()->username);
        $groups = $this->getGroups($inventario,$this->method);
        return view('unix.resetUserByAD',compact('groups','inventario','username'));
    }

    public function resetUserByADStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'password' => 'required',
        ]);
        $idTemplate = 55; // creacion y eliminacion de usuarios
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "user"=> strtolower($request->Auth::user()->username), "password" => $request->password, "action" => 'Reset',
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

    public function delete()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unix.delete',compact('groups','inventario'));
    }

    public function deleteStore(Request $request)
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
    public function disable()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unix.disable',compact('groups','inventario'));
    }

    public function disableStore(Request $request)
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

    public function freeMemory()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unix.freeMemory',compact('groups','inventario'));
    }

    public function freeMemoryStore(Request $request)
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
    public function inventario()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unix.inventario',compact('groups','inventario'));
    }

    public function inventarioStore(Request $request)
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
    public function checkPaso()
    {
        $inventario = 24;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unix.checkPaso',compact('groups','inventario'));
    }

    public function checkPasoStore(Request $request)
    {
        $this->validate($request, [
            'hosts' => 'required|string',
        ]);
        $idInventory = 24;
        $hosts = explode(',',$request->hosts);
        $hostId = '';
        $idHosts = "";
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
        $idTemplate = 117;
        $log = $this->getLog(4,12,$idTemplate,2,2);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("id_asgard" => $id_asgard));
        //dd(json_encode($variables));
        $resultado = $this->runWorkFlow($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['workflow_job'];
        $log->update([
            'id_job' => $resultado,
            'result' => "http://172.22.16.179:443/$id_asgard",
            'host_id_list' => $idHosts,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function rutasEstaticas()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unix.rutasEstaticas',compact('groups','inventario'));
    }

    public function rutasEstaticasStore(Request $request)
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

    public function pasoPrevio()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unix.pasoPrevio',compact('groups','inventario'));
    }


    public function pasoPrevioStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'case' => 'required|string',
        ]);
        $idTemplate = 148;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1000;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard, "opcion" => "vista", "case" => $request->case));
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

    public function pasoPosterior()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unix.pasoPosterior',compact('groups','inventario'));
    }

    public function pasoPosteriorStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'case' => 'required|string',
        ]);
        $idTemplate = 148;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1000;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard, "opcion" => "compara", "case" => $request->case));
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

    public function uptime()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unix.uptime',compact('groups','inventario'));
    }

    public function uptimeStore(Request $request)
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
    public function logrotate()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unix.logrotate',compact('groups','inventario'));
    }

    public function logrotateStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 191;
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
    public function snapSList()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unix.snapSList',compact('groups','inventario'));
    }

    public function snapSListStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'action' => 'required',
        ]);
        $idTemplate = 162;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard, "action" => $request->action));
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
    public function snapSolaris()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unix.snapSolaris',compact('groups','inventario'));
    }

    public function snapSolarisStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'action' => 'required',
        ]);
        if($request->input('action') != 'Todo'){
            $this->validate($request, [
                'pool' => 'required|string|min:1|max:100',
            ]);
        }
        $idTemplate = 162;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        if($request->input('action') == 'Todo'){
            $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard, "action" => $request->action));
        }else{
            $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard, "action" => $request->action,"pools" => $request->input('pool')));
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
    public function portListen()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unix.portListen',compact('groups','inventario'));
    }

    public function portListenStore(Request $request)
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
    public function diskManagement()
    {
        $inventario = 16;
        $groups = Inventory::where('id_inventory',$inventario)->where('name_group','like',"%_CLUSTER")->distinct('name_group')->orderBy('name_group')->pluck('name_group');
        return view('unix.diskManagement',compact('groups','inventario'));
    }

    public function diskManagementStore(Request $request)
    {
        $this->validate($request, [
            'group' => 'required',
            'accion' => 'required|string',
        ]);
        $idTemplate = 263;
        if($request->input('accion') == 'Etiquetar'){
            if($request->input('distro') == 'ASM'){
                if(empty($request->input('asmDisk'))){
                    return redirect()->route('unix.diskManagement')->with('error','Debe ingresar información de los discos a configurar');
                }else{
                    $asm = $request->input('asmDisk');
                    $disks = '';
                    foreach($asm as $disk){
                        if($disk === end($asm)){
                            $disks .= $disk;
                        }else{
                            $disks .= $disk.':';
                        }

                    }
                    $log = $this->getLog(4,13,$idTemplate);
                    $id_asgard = $log->id;
                    //$id_asgard = 1;
                    $variables = array("extra_vars" => array("HOST" => $request->input('group'), "id_asgard" => $id_asgard, "opcion" => "asm", "ID_Disk" => $disks ));
                }
            }elseif($request->input('distro') == 'UDEV'){
                if(empty($request->input('udevDisk'))){
                    return redirect()->route('unix.diskManagement')->with('error','Debe ingresar información de los discos a configurar');
                }else{
                    $udev = $request->input('udevDisk');
                    $disks = '';
                    foreach($udev as $disk){
                        if($disk === end($udev)){
                            $disks .= $disk;
                        }else{
                            $disks .= $disk.':';
                        }
                    }
                    $log = $this->getLog(4,13,$idTemplate);
                    $id_asgard = $log->id;
                    //$id_asgard = 1;
                    $variables = array("extra_vars" => array("HOST" => $request->input('group'), "id_asgard" => $id_asgard, "opcion" => "udev", "ID_Disk" => $disks ));
                }
            }
        }if($request->input('accion') == 'Listar'){
            $log = $this->getLog(4,13,$idTemplate);
            $id_asgard = $log->id;
            //$id_asgard = 1;
            $variables = array("extra_vars" => array("HOST" => $request->input('group'), "id_asgard" => $id_asgard, "opcion" => "listar"));
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
    public function folderPermission()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unix.folderPermission',compact('groups','inventario'));
    }

    public function folderPermissionStore(Request $request)
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
    public function simpana()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unix.simpana',compact('groups','inventario'));
    }

    public function simpanaStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'option' => 'required|string',
        ]);
        $idTemplate = 317;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "option" => $request->input('option'),"id_asgard" => $id_asgard));
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
    public function restartServices()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unix.restartServices',compact('groups','inventario'));
    }

    public function restartServicesStore(Request $request)
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
    public function cleanFileSystem()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unix.cleanFileSystem',compact('groups','inventario'));
    }

    public function cleanFileSystemStore(Request $request)
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
    public function configLvm()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        //dd($groups);
        return view('unix.configLvm',compact('groups','inventario'));
    }

    public function configLvmStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'option' => 'required',
        ]);
        $idTemplate = 359;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard, "disk" => $request->disk, "fs" => $request->fs, "lv" => $request->lv, "option" => $request->input('option'), "size" => $request->size, "vg" => $request->vg));
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
    //________________↓↓↓ ACTIVACIÓN ENVIO LOGS ↓↓↓ __________________________//

    function activacionEnvioLogs(){
        $inventario = 105;
        $groups = $this->getGroups($inventario,$this->method);
        return view('unix.activacionEnvioLogs',compact('groups','inventario'));
    }
    function activacionEnvioLogsStore(Request $request){
        $this->validate($request, [
            'host' => 'required',
            'logName' => 'required',
        ]);
        $campos =$request->all();
        if(isset($campos['checkMailSending'])){
            $this->validate($request, [
                'email_destinatario' => 'required',
            ],[
                'email_destinatario.required'=>'El campo correo electrónico es obligatorio.'
            ]);
        }
        $HOST = $campos["host"][0];            
        $idTemplate = 511;
        $log = $this->getLog(5,13,$idTemplate);
        $id_asgard = $log->id;
        $log_name=(string)$campos["logName"];
        $variables = array("extra_vars" =>
            [
                "HOST"  => $HOST,
                "id_asgard" => $id_asgard,
                "message_log"=> $log_name,
            ]
        );
        $resultado =$this->runPlaybook($idTemplate,$variables);
        $adjunto = "E:\\FILES\\UNIX\\UNIX_LOGS_004\\".$id_asgard.".json";
        $string="";
        if(!isset($campos['checkMailSending'])){
            $createdFile = false;
            do{
                $createdFile=Storage::disk('fileserver')->exists('\\UNIX\\UNIX_LOGS_004\\'.$id_asgard.'.json');
                if($createdFile){
                    $results = shell_exec("powershell.exe -executionpolicy bypass -NoProfile ". app_path() . "\scripts\TEST\R004_DeleteFileAtt.ps1 -adjunto '$adjunto'" . escapeshellarg($string));       
                    break;
                }
            } while(!$createdFile);

            $resultado = $resultado['job'];
            $log->update([
                'id_job' => $resultado,
                'result' => "/UNIX/UNIX_LOGS_HTML_005/$id_asgard.html",
            ]);
            return redirect()->route('executionLogs.show',$id_asgard);
        }else{
            $destinatario =$campos['email_destinatario'];
            $asunto = "Generación Log ".$id_asgard." - LogName ".$log_name." - server ".$HOST;
            $cuerpo ="Apresiado(a) usuario, Asgard envía el log ".$id_asgard.".csv, el cual se encontrara como archivo adjunto en este correo.";
            $sendMail = false;
            do{
                $sendMail=Storage::disk('fileserver')->exists('\\UNIX\\UNIX_LOGS_004\\'.$id_asgard.'.json');
                if($sendMail){
                    $results = shell_exec("powershell.exe -executionpolicy bypass -NoProfile ". app_path() . "\scripts\TEST\R003-SendMail-Attached.ps1 -destinatario '$destinatario' -asunto '$asunto' -cuerpo '$cuerpo' -adjunto '$adjunto'" . escapeshellarg($string));
                    $mail = json_decode($results, true);        
                    break;
                }
            } while(!$sendMail); 

            $resultado = $resultado['job'];
            $log->update([
                'id_job' => $resultado,
                'result' => "/UNIX/UNIX_LOGS_HTML_005/$id_asgard.html",
            ]);
            if($mail['response']){
                    return redirect()->route('executionLogs.show',$id_asgard)->with('success', ' El envío de correo electrónico al destinatario "'.$destinatario.'" fue exitoso.');
            }else{
                    return redirect()->route('executionLogs.show',$id_asgard)->with('error', ' El envío de correo electrónico al destinatario "'.$destinatario.'" fue fallido. '.$mail['error']);
            }
        }  
    }
        //________________↓↓↓ GET LISTADO LOGNAME ↓↓↓ __________________________//
    public function getListLogNameByHost(Request $request) {

            $this->validate($request, [
                'host' => 'required'
            ]);

            $idTemplate = 510;
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
                "url"       => "file/-UNIX-UNIX_MESSAGE_003/".$id_asgard.".json"
            ];
            return response()->json(["data" => $finalRequest]);
    }
}

