<?php

namespace App\Http\Controllers;

use App\OsGroup;
use App\Inventory;
use Illuminate\Http\Request;
use App\Http\Traits\ConnectionTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SupportPHController extends Controller
{
    //Definición de variables globales del controlador
    Use ConnectionTrait;
    private $method = "local";

    public function checkSOUnix()
    {
        $inventario = 77;
        $groups = $this->getGroups($inventario,$this->method);
        //dd($groups);
        return view('supportPH/linux/checkUnixPH',compact('groups','inventario'));
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
    public function checkSOWindows()
    {
        $inventario = 4;
        $groups = $this->getGroups($inventario,$this->method);
        //dd($groups);
        return view('supportPH/windows/checkWindowsPH',compact('groups','inventario'));
    }

    public function checkSOWindowsStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 377;
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
            'result' => "/WINDOWS/WIN_PH_001/$id_asgard.html",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function checkAD()
    {
        $inventario = 56;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('supportPH/windows/checkAD',compact('groups','inventario'));
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






    public function serviceManagementV2()
    {
        $inventario = 4;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('supportPH.windows.serviceManagementV2PH',compact('groups','inventario'));
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
            $idTemplate = 474;
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

            $idTemplate = 459;
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
}
