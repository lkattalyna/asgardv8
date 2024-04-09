<?php

namespace App\Http\Controllers;

use App\OsGroup;
use Illuminate\Http\Request;
use App\Http\Traits\ConnectionTrait;

class NetworkingPymesController extends Controller
{
    //
    Use ConnectionTrait;
    private $method = "local";

    public function restartGaoke()
    {
        $inventario = 80;
        $groups = $this->getGroups($inventario,$this->method);
        return view('networkingPymes.restartGaoke',compact('groups','inventario'));
    }


    public function restartGaokeStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 408;
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
    public function updateGaoke()
    {
        $inventario = 80;
        $groups = $this->getGroups($inventario,$this->method);
        return view('networkingPymes.updateGaoke',compact('groups','inventario'));
    }


    public function updateGaokeStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 407;
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
