<?php

namespace App\Http\Controllers;

use App\Inventory;
use Illuminate\Http\Request;
use App\Http\Traits\ConnectionTrait;

class AmtPHITController extends Controller
{
    Use ConnectionTrait;
    private $method = "local";

    public function depLogsGlasfish()
    {
        $inventario = 62;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPHIT.depLogsGlasfish',compact('groups','inventario'));
    }
    public function depLogsGlasfishStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 316;
        /*$log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;*/
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host,));
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
    public function despliegueVentas()
    {
        $inventario = 62;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPHIT.despliegueVentas',compact('groups','inventario'));
    }
    public function despliegueVentasStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 318;
        /*$log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;*/
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host,));
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
    public function desplieguePCML()
    {
        $inventario = 62;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPHIT.desplieguePCML',compact('groups','inventario'));
    }
    public function desplieguePCMLStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 319;
        /*$log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;*/
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host,));
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
    public function reinicioAgendamiento()
    {
        $inventario = 62;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPHIT.reinicioAgendamiento',compact('groups','inventario'));
    }
    public function reinicioAgendamientoStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 330;
        /*$log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;*/
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host,));
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
    public function papAgendamiento()
    {
        $inventario = 62;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPHIT.papAgendamiento',compact('groups','inventario'));
    }
    public function papAgendamientoStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 320;
        /*$log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;*/
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host,));
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
    public function despliegueMC()
    {
        $inventario = 62;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPHIT.despliegueMC',compact('groups','inventario'));
    }
    public function despliegueMCStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 321;
        /*$log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;*/
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host,));
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
    public function depFileSystem()
    {
        $inventario = 62;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPHIT.depFileSystem',compact('groups','inventario'));
    }
    public function depFileSystemStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 322;
        /*$log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;*/
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host,));
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
    public function depFileWebService()
    {
        $inventario = 62;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPHIT.depFileWebService',compact('groups','inventario'));
    }
    public function depFileWebServiceStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 323;
        /*$log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;*/
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host,));
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
    public function desplieguePostVenta()
    {
        $inventario = 62;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPHIT.desplieguePostVenta',compact('groups','inventario'));
    }
    public function desplieguePostVentaStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 324;
        /*$log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;*/
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host,));
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
    public function reinicioWebService()
    {
        $inventario = 62;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPHIT.reinicioWebService',compact('groups','inventario'));
    }
    public function reinicioWebServiceStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 325;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host,));
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
    public function ventaTecnica()
    {
        $inventario = 62;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPHIT.ventaTecnica',compact('groups','inventario'));
    }
    public function ventaTecnicaStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 326;
        /*$log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;*/
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host,));
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
    public function reinicioVisor()
    {
        $inventario = 62;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPHIT.reinicioVisor',compact('groups','inventario'));
    }
    public function reinicioVisorStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 327;
        /*$log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;*/
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host,));
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
    public function despCallCenter()
    {
        $inventario = 62;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPHIT.despCallCenter',compact('groups','inventario'));
    }
    public function despCallCenterStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 328;
        /*$log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;*/
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host,));
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
    public function woService()
    {
        $inventario = 62;
        $groups = Inventory::where('id_inventory',$inventario)->orderBy('name_group')->pluck('name_group');
        return view('amtPHIT.woService',compact('groups','inventario'));
    }
    public function woServiceStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 329;
        /*$log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;*/
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host,));
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
    public function diagnosticMC()
    {
        $inventario = 51;
        $groups = $this->getGroups($inventario,$this->method);
        return view('amtPHIT.diagnosticMC',compact('groups','inventario'));
    }

    public function diagnosticMCStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 392;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1000;
        $variables = array("extra_vars" => array("HOST_SERVER" => $request->host));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
            //'result' => "http://172.22.16.179:443/$id_asgard",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }

}
