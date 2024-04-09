<?php

namespace App\Http\Controllers;

use App\OsGroup;
use App\Inventory;
use Illuminate\Http\Request;
use App\Http\Traits\ConnectionTrait;
use Illuminate\Support\Facades\Storage;

class WindowsController extends Controller
{
    Use ConnectionTrait;
    private $method = "local";

    public function create()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);
        $grupos = OsGroup::where('flag',$inventario)->where('show_to','all')->orderBy('name')->get();
        return view('windows.create',compact('groups','inventario','grupos'));
    }
    public function store(Request $request)
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
    public function change()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);
        $grupos = OsGroup::where('flag',$inventario)->where('show_to','all')->orderBy('name')->get();
        return view('windows.change',compact('groups','inventario','grupos'));
    }
    public function changeStore(Request $request)
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
    public function sevenSteps()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);
        return view('windows.sevenSteps',compact('groups','inventario'));
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
    public function delete()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);
        $grupos = OsGroup::where('flag',$inventario)->where('show_to','all')->orderBy('name')->get();
        return view('windows.delete',compact('groups','inventario','grupos'));
    }
    public function deleteStore(Request $request)
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
    public function edit()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);
        $grupos = OsGroup::where('flag',$inventario)->where('show_to','all')->orderBy('name')->get();
        return view('windows.edit',compact('groups','inventario','grupos'));
    }
    public function update(Request $request)
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
    public function disable()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);
        return view('windows.disable',compact('groups','inventario'));
    }
    public function disableStore(Request $request)
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
    public function freeMemory()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);
        return view('windows.freeMemory',compact('groups','inventario'));
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
    public function extParches()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);
        return view('windows.extParches',compact('groups','inventario'));
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
    public function inventario()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);
        return view('windows.inventario',compact('groups','inventario'));
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
    public function checkPaso()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);
        return view('windows.checkPaso',compact('groups','inventario'));
    }
    public function checkPasoStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 121;
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
        return view('windows.rutasEstaticas',compact('groups','inventario'));
    }

    public function rutasEstaticasStore(Request $request)
    {
        if($request->item == 'adds'){
            $this->validate($request, [
                'host' => 'required',
                'item' => 'required',
                'destination' => 'required|ipv4',
                'gateway' => 'required|ipv4',
                'metric' => 'integer',
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

    public function updateSO()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('windows.updateSO',compact('groups','inventario'));
    }

    public function updateSOStore(Request $request)
    {
        if($request->item == 'archivo'){
            $this->validate($request, [
                'host' => 'required',
                'item' => 'required',
                'ruta' => 'required|string',
            ]);
        }else{
            $this->validate($request, [
                'host' => 'required',
                'item' => 'required',
                'ruta' => 'required|string',
                'url' => 'required|string',
            ]);
        }
        $idTemplate = 71;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        if($request->item == 'archivo'){
            $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard, "item" => $request->item, "rdp_rutades" => $request->ruta));
        }else{
            $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard, "item" => $request->item, "rdp_rutades" => $request->ruta,
            "rdp_urlarchivo" => $request->url));
        }
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function checkSO()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('windows.checkSO',compact('groups','inventario'));
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
    public function extUptime()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('windows.extUptime',compact('groups','inventario'));
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
    public function checkAD()
    {
        $inventario = 56;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('windows.checkAD',compact('groups','inventario'));
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
    public function preVentana()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('windows.preVentana',compact('groups','inventario'));
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
        return view('windows.postVentana',compact('groups','inventario'));
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
    public function serviceManagement()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('windows.serviceManagement',compact('groups','inventario'));
    }

    public function serviceManagementStore(Request $request)
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
    public function checkCluster()
    {
        $inventario = 17;
        $groups = Inventory::where('id_inventory',$inventario)->where('name_group','like',"%_CLUSTER")->distinct('name_group')->orderBy('name_group')->pluck('name_group');
        return view('windows.checkCluster',compact('groups','inventario'));
    }

    public function checkClusterStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 277;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
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
    public function manageWConsultas()
    {
        $inventario = 17;
        $groups = Inventory::where('id_inventory',$inventario)->where('name_group',"CONSORCIO_SALUD")->distinct('name_group')->orderBy('name_group')->pluck('name_group');
        return view('windows.manageWConsultas',compact('groups','inventario'));
    }

    public function manageWConsultasStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'option' => 'required',
        ]);
        $idTemplate = 291;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard, "option" => $request->input('option')  ));
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

    public function manageWCompensar()
    {
        $inventario = 17;
        $groups = Inventory::where('id_inventory',$inventario)->where('name_group',"CONSORCIO_SALUD")->distinct('name_group')->orderBy('name_group')->pluck('name_group');
        return view('windows.manageWCompensar',compact('groups','inventario'));
    }

    public function manageWCompensarStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'option' => 'required',
        ]);
        $idTemplate = 290;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard, "option" => $request->input('option')  ));
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
    public function diskCheck()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);
        return view('windows.diskCheck',compact('groups','inventario'));
    }

    public function diskCheckStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 301;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard, "mail" => "no"  ));
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
        return view('windows.checkCPUProcess',compact('groups','inventario'));
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
    public function debuggingDisks()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);
        return view('windows.debuggingDisks',compact('groups','inventario'));
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

	public function testConectividad(){
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);
        return view('windows.connectivity',compact('groups','inventario'));
    }

    public function testConectividadStore(Request $request){

        $campos = $request->all();
        $HOST = $campos["host"][0];
        $ips_ping_destino = array_values($campos["ipDestino"]);
        $ips_telnet_destino = array_values($campos["ipTelnet"]);
        $ports_telnet_destino = array_values($campos["puertoTelnet"]);
        $telnet_opts= array();
        $do_ping    = "false";
        $do_telnet  = "false";
        $do_tracert = "false";
        $idTemplate = 469;
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
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('windows.serviceManagementV2',compact('groups','inventario'));
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
 //________________↓↓↓ ACTIVACIÓN ENVIO LOGS ↓↓↓ __________________________//

    function activacionEnvioLogs(){
            $inventario = 17;
            $groups = $this->getGroups($inventario,$this->method);
            return view('windows.activacionEnvioLogs',compact('groups','inventario'));
    }
    function activacionEnvioLogsStore(Request $request){
        $this->validate($request, [
            'host' => 'required',
            'logName' => 'required',
            'email_destinatario'=> 'required'
        ]);
	   $campos =$request->all();
        $HOST = $campos["host"][0];
        $idTemplate = 484;
        $log = $this->getLog(5,13,$idTemplate);
        $id_asgard = $log->id;
        $log_name=(string)$campos["logName"];
        $variables = array("extra_vars" =>
            [
                "HOST"  => $HOST,
                "id_asgard" => $id_asgard,
                "log_name"=> $log_name,
            ]
        );
        $resultado =$this->runPlaybook($idTemplate,$variables);

		$destinatario =$campos['email_destinatario'];
		$asunto = "Notificación entrega de log - ".$campos['logName'];
		$cuerpo ="Este es un correo automático de notificación.";
		$adjunto = "E:\\FILES\\WINDOWS\\WIN_LOGS_004\\".$id_asgard.".json";
		$string="";
        $sendMail = false;
		do{
            $sendMail=Storage::disk('fileserver')->exists('\\WINDOWS\\WIN_LOGS_004\\'.$id_asgard.'.json');
			if($sendMail){
				$results = shell_exec("powershell.exe -executionpolicy bypass -NoProfile ". app_path() . "\scripts\TEST\R002-SendMail-Attached.ps1 -destinatario '$destinatario' -asunto '$asunto' -cuerpo '$cuerpo' -adjunto '$adjunto'" . escapeshellarg($string));
				$mail = json_decode($results, true);
                break;
			}
		} while(!$sendMail);

        $resultado = $resultado['job'];
       $log->update([
           'id_job' => $resultado,
           'result' => "/WINDOWS/WIN_LOGS_HTML_005/$id_asgard.html",
       ]);
        if(trim($mail['response']) == 'true'){
            return redirect()->route('executionLogs.show',$id_asgard)->with('success', ' El envío de log '.$id_asgard.'.csv fue exitoso.');
       }else{
            return redirect()->route('executionLogs.show',$id_asgard)->with('error', ' El envío de log '.$id_asgard.'.csv fue fallido.'.$mail['error']);
       }
    }
        //________________↓↓↓ GET LISTADO LOGNAME ↓↓↓ __________________________//
    public function getListLogNameByHost(Request $request) {

            $this->validate($request, [
                'host' => 'required'
            ]);

            $idTemplate = 485;
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
                "url"       => "file/-WINDOWS-WIN_GET_LOGNAME_003/".$id_asgard.".json"
            ];
            return response()->json(["data" => $finalRequest]);
    }
}

