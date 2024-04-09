<?php

namespace App\Http\Controllers;

use App\Inventory;
use Illuminate\Http\Request;
use App\Http\Traits\ConnectionTrait;

class AmtPHController extends Controller
{
    Use ConnectionTrait;
    private $method = "local";

    public function reinicioDatosComp()
    {
        $inventario = 51;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPH.reinicioDatosComp',compact('groups','inventario'));
    }


    public function reinicioDatosCompStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 222;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host,));
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
    public function reinicioEscalonado()
    {
        $inventario = 51;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPH.reinicioEscalonado',compact('groups','inventario'));
    }


    public function reinicioEscalonadoStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 227;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host,));
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
    public function bajadaDominio()
    {
        $inventario = 51;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPH.bajadaDominio',compact('groups','inventario'));
    }


    public function bajadaDominioStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'dominio' => 'required',
            'cluster' => 'required',
        ]);
        $idTemplate = 233;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host, "DOMINIO" => $request->input('dominio'), "CLUSTER" => $request->input('cluster')));
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
    public function subidaDominio()
    {
        $inventario = 51;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPH.subidaDominio',compact('groups','inventario'));
    }


    public function subidaDominioStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'dominio' => 'required',
            'cluster' => 'required',
        ]);
        $idTemplate = 234;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host, "DOMINIO" => $request->input('dominio'), "CLUSTER" => $request->input('cluster')));
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
    public function estDataSource()
    {
        $inventario = 51;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPH.estDataSource',compact('groups','inventario'));
    }


    public function estDataSourceStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'dominio' => 'required',
        ]);
        $idTemplate = 229;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host, "DOMINIO" => $request->input('dominio')));
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
    public function reinicioDomTrafico()
    {
        $inventario = 51;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPH.reinicioDomTrafico',compact('groups','inventario'));
    }


    public function reinicioDomTraficoStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 259;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host));
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
    public function reinicioClusterEAP()
    {
        $inventario = 51;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPH.reinicioClusterEAP',compact('groups','inventario'));
    }


    public function reinicioClusterEAPStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 293;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host,));
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
    public function jobPurge()
    {
        $inventario = 69;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPH.jobPurge',compact('groups','inventario'));
    }
    public function jobPurgeStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 350;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host,));
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
    public function ESBAlarm()
    {
        $inventario = 69;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPH.ESBAlarm',compact('groups','inventario'));
    }
    public function ESBAlarmStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 351;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host,));
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
    public function ITELRestart()
    {
        $inventario = 72;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPH.ITELRestart',compact('groups','inventario'));
    }
    public function ITELRestartStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'machine' => 'required',
        ]);
        $idTemplate = 361;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host,"MACHINE" => $request->input('machine')));
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
    public function ITELState()
    {
        $inventario = 72;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPH.ITELState',compact('groups','inventario'));
    }
    public function ITELStateStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 366;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host));
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
    public function ITELOsbTriara()
    {
        $inventario = 78;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPH.ITELOsbTriara',compact('groups','inventario'));
    }
    public function ITELOsbTriaraStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 384;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host, "MACHINE" => $request->input('machine') ));
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
    public function stateEAP()
    {
        $inventario = 51;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPH.stateEAP',compact('groups','inventario'));
    }
    public function stateEAPStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 380;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host));
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
    public function errorEAP()
    {
        $inventario = 51;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPH.errorEAP',compact('groups','inventario'));
    }
    public function errorEAPStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'dominio' => 'required',
        ]);
        $idTemplate = 381;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host, "DOMINIO" => $request->input('dominio')));
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
    public function ITELVeneciaDown()
    {
        $inventario = 72;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPH.ITELVeneciaDown',compact('groups','inventario'));
    }
    public function ITELVeneciaDownStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 396;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host));
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
    public function ITELVeneciaUp()
    {
        $inventario = 72;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPH.ITELVeneciaUp',compact('groups','inventario'));
    }
    public function ITELVeneciaUpStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 397;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host));
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
    public function diagEapBSCS()
    {
        $inventario = 51;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPH.diagEapBSCS',compact('groups','inventario'));
    }
    public function diagEapBSCSStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 404;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host));
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
    public function ITELTriaraDown()
    {
        $inventario = 78;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPH.ITELTriaraDown',compact('groups','inventario'));
    }
    public function ITELTriaraDownStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 411;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host));
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
    public function ITELTriaraUp()
    {
        $inventario = 78;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPH.ITELTriaraUp',compact('groups','inventario'));
    }
    public function ITELTriaraUpStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 412;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host));
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
    public function downSoaTriara()
    {
        $inventario = 78;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPH.downSoaTriara',compact('groups','inventario'));
    }
    public function downSoaTriaraStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 424;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host));
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
    public function ITELTriaraSoaUp()
    {
        $inventario = 78;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPH.ITELTriaraSoaUp',compact('groups','inventario'));
    }
    public function ITELTriaraSoaUpStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 425;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host));
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
    public function ITELVeneciaSoaDown()
    {
        $inventario = 72;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPH.ITELVeneciaSoaDown',compact('groups','inventario'));
    }
    public function ITELVeneciaSoaDownStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 426;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host));
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
    public function ITELVeneciaSoaUp()
    {
        $inventario = 72;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPH.ITELVeneciaSoaUp',compact('groups','inventario'));
    }
    public function ITELVeneciaSoaUpStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 427;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host));
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
    public function ITELTriaraAprovDown()
    {
        $inventario = 78;
        $groups = $this->getGroups($inventario,$this->method);
        //$groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPH.ITELTriaraAprovDown',compact('groups','inventario'));
    }
    public function ITELTriaraAprovDownStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 428;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host));
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
    public function ITELTriaraAprovUp()
    {
        $inventario = 78;
        $groups = $this->getGroups($inventario,$this->method);
        //$groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPH.ITELTriaraAprovUp',compact('groups','inventario'));
    }
    public function ITELTriaraAprovUpStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 429;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host));
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
    public function downCloudVenecia()
    {
        $inventario = 95;
        $groups = $this->getGroups($inventario,$this->method);
        //$groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPH.downCloudVenecia',compact('groups','inventario'));
    }
    public function downCloudVeneciaStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 449;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host));
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
    public function upCloudVenecia()
    {
        $inventario = 95;
        $groups = $this->getGroups($inventario,$this->method);
        //$groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPH.upCloudVenecia',compact('groups','inventario'));
    }
    public function upCloudVeneciaStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 450;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host));
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
    public function downCloudTriara()
    {
        $inventario = 96;
        $groups = $this->getGroups($inventario,$this->method);
        //$groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPH.downCloudTriara',compact('groups','inventario'));
    }
    public function downCloudTriaraStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 453;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host));
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
    public function upCloudTriara()
    {
        $inventario = 96;
        $groups = $this->getGroups($inventario,$this->method);
        //$groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPH.upCloudTriara',compact('groups','inventario'));
    }
    public function upCloudTriaraStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 454;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host));
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

    public function ReinicioOperinspEsb()
    {
        $inventario = 69;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPH.ReinicioOperinspEsb',compact('groups','inventario'));
    }

    public function ReinicioOperinspEsbStore(Request $request)
    { //dd($request->all());
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 468;
        $log = $this->getLog(1,12,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host,));
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
    public function InspEocecmBajar()
    {
        $inventario = 108;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPH.InspEocecmBajar',compact('groups','inventario'));
    }

    public function InspEocecmBajarStore(Request $request)
    { //dd($request->all());
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 516;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;        
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host));      
        $resultado = $this->runPlaybook($idTemplate,$variables);      
        $resultado = $resultado['job'];      
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    
    public function InspEocecmSubir()
    {
        $inventario = 108;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPH.InspEocecmSubir',compact('groups','inventario'));
    }

    public function InspEocecmSubirStore(Request $request)
    {  
        $this->validate($request, [
            'host' => 'required',
            'manejado' => 'required',
        ]);
        $idTemplate = 517;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;      
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host,"MANEJADO" => $request->manejado));
        $resultado = $this->runPlaybook($idTemplate,$variables);      
        $resultado = $resultado['job'];       
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
}
