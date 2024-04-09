<?php

namespace App\Http\Controllers;

use App\CloudApiAccount;
use Illuminate\Http\Request;
use App\Http\Traits\ConnectionTrait;

class CloudController extends Controller
{
    Use ConnectionTrait;
    private $method = "local";

    public function serviceRestart()
    {
        return view('cloud.serviceRestart');
    }


    public function serviceRestartStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        //$idTemplate = 17;
        $idTemplate = 19;
        $log = $this->getLog(7,14,$idTemplate,1,0,'172.22.16.179');
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => array($request->input('host')), "id_asgard" => $id_asgard));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables,'172.22.16.179');
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }

}
