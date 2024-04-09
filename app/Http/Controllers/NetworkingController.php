<?php

namespace App\Http\Controllers;

use App\OsGroup;
use Illuminate\Http\Request;
use App\Http\Traits\ConnectionTrait;

class NetworkingController extends Controller
{
    Use ConnectionTrait;
    private $method = "local";

    public function valUptime()
    {
        $inventario = 5;
        $groups = $this->getGroups($inventario,$this->method);
        return view('networking.valUptime',compact('groups','inventario'));
    }


    public function valUptimeStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 197;
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

    public function checkInventario()
    {
        $inventario = 5;
        $groups = $this->getGroups($inventario,$this->method);
        return view('networking.checkInventario',compact('groups','inventario'));
    }


    public function checkInventarioStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 198;
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
    public function macSearchPC()
    {
        $inventario = 5;
        $groups = $this->getGroups($inventario,$this->method);
        return view('networking.macSearchPC',compact('groups','inventario'));
    }


    public function macSearchPCStore(Request $request)
    {
        $this->validate($request, [
            'mac' => 'required|min:4|max:14',
        ]);
        $idTemplate = 216;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("MAC" => $request->mac));
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
    public function tShootCAV()
    {
        $inventario = 49;
        $groups = $this->getGroups($inventario,$this->method);
        return view('networking.tShootCAV',compact('groups','inventario'));
    }


    public function tShootCAVStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 217;
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
}
