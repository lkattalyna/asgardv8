<?php

namespace App\Http\Controllers\Pass;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Inventory;
use App\Http\Traits\ConnectionTrait;

class WindowsController extends Controller
{

    Use ConnectionTrait;
    private $method = "local";

    public function testConectividad(){
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);
        return view('pass.windows.connectivity',compact('groups','inventario'));
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
            "url"       => "file/-PASS-WIN_GET_SERVICES_001/".$id_asgard.".json"
            // http://172.18.91.203/asgard/file/-PASS-WIN_GET_SERVICES_001/index.json
        ];

        return response()->json(["data" => $finalRequest]);
    }


    public function servicesMejoras(){
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('pass.windows.serviceMejora',compact('groups','inventario'));
    }

    // public function getServicesByHost(Request $request){
    //     $inventario = 17;
    //     $groups = $this->getGroups($inventario,$this->method);;
    //     return view('pass.windows.serviceMejora',compact('groups','inventario'));
    // }

    public function storeServicesMejoras( Request $request ){
        dd("Conectando...");
    }
}
