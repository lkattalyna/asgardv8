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

    public function storeTestConectividad(Request $request) {

        $this->validate($request, [
            'host' => 'required',
            "Destino" =>'required',
            "tipo" => 'required',
            "tracer" => 'Tracer',
        ]);

        $idTemplate = 451;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" =>
        [
            "Host"  => $request->host[0],
            "ipDestino" => $request->Destino,
            "tracer"=> "Tracer",
            "tipo"=>$request->tipo
        ]
    );
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


    public function servicesMejoras(){
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('pass.windows.serviceMejora',compact('groups','inventario'));
    }

    public function storeServicesMejoras( Request $request ){
        dd("Conectando...");
    }
}
