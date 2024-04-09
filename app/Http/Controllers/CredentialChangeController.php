<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\CredentialChange;
use App\Mail\SendMail;
use App\User;
use App\OsGroup;
use App\Inventory;
use App\Http\Traits\ConnectionTrait;
use Illuminate\Support\Facades\Storage;


class CredentialChangeController extends Controller
{
    Use ConnectionTrait;
    private $method = "local";

    public function credentialChange(){

        $logs = CredentialChange::all();
        $inventario = 106;
        $groups = $this->getGroups($inventario,$this->method);

        $backpack = [
            "logs" => $logs,
            "inventario" => $inventario,
            "groups" => $groups
        ];

        return view('credentialsChange.credentialsForm',$backpack);
    }

    public function credentialChangeStore(Request $request){
        $names = Auth::user()->name;
        $atributos = [
            'name' => $names
        ];

        $this->validate($request, [
            'userServer' => 'required',
            'newPass' => 'required',
            'ipDestino' => 'required',
			'userEnclosure' => 'required',
			'passEnclosure' => 'required'
        ]);
        $idTemplate = 512;
        $log = $this->getLog(5,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("id_asgard" => $id_asgard, "userServer" => $request->userServer, "newPass" => $request->newPass, "ipDestino" => $request->ipDestino, "userEnclosure" => $request->userEnclosure, "passEnclosure" => $request->passEnclosure, "id_asgard" => $id_asgard));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);*/
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'result' => "/RES/RES_HP_CREDENCIALES/$id_asgard.html",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

        //dd($atributos);
        //$data = credentialChange::create($atributos);
        //if(isset($data)){
        //    return redirect()->route('turns.turnManage')
        //        ->with('success', 'El cambio de contraseña fue exitoso.');
        //}else{
        //    return redirect()->route('turns.turnManage')
        //        ->withErrors(['Hubo un error al hacer el cambio de contraseña.']);
        }
}


