<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\TurnManagement;
use App\TurnManagementCases;
use App\Mail\SendMail;
use App\User;

class TurnManagementController extends Controller
{
    public function turnManage(){


        $turnos = TurnManagement::all();
        $casos = TurnManagementCases::all();

        $backpack = [
            "turnos" => $turnos,
            "casos" => $casos
        ];

        return view('turnManagement.turnForm',$backpack);
    }

    public function turnManageStore(Request $request){
        $this->validate($request, [
            'turn' => 'required',

        ]);
        $campos = $request->all();
        $turn = $campos['turn'];
        $area = $campos['group'];
        $observations = $campos['observations'];
        $names = Auth::user()->name;        
        $casesSC = $campos['masSuspC'];	
        $casesSR = $campos['masSuspR'];
        $casesSL = $campos['masSuspL'];
		$casesPC = $campos['masPendC'];	
        $casesPR = $campos['masPendR'];        
        $atributos = [
            'name' => $names,
            'turn' => $campos['turn'],
            //'suspended_case' => isset($campos['suspended_case']) ? 1 : 0,
            //'suspended_name' => $campos['masSuspC'],
            //'suspended_reason' => $campos['suspended_reason'],
            //'suspended_dates' => $campos['suspended_dates'],
            //'pending_case' => isset($campos['pending_case']) ? 1 : 0,
            //'pending_name' => $campos['pending_name'],
            //'pending_reason' => $campos['pending_reason'],
            'observations' => $campos['observations'],
        ];
		
		if($casesSC[0] != null){
			for($x = 0; $x < sizeof($casesSC); $x++){
				$atributosCasosS = [
					'name' => $names,
					'turn' => $campos['turn'],
					'type' => 'SUSPENDIDO',
					'case' => $casesSC[$x],
					'reason'=>$casesSR[$x],
					'dates'=>$casesSL[$x]
				];
				$dataCasesS = TurnManagementCases::create($atributosCasosS);
			}
		}
		
		if($casesPC[0] != null){
			for($x = 0; $x < sizeof($casesSC); $x++){
				$atributosCasosP = [
					'name' => $names,
					'turn' => $campos['turn'],
					'type' => 'PENDIENTE',
					'case' => $casesSC[$x],
					'reason'=>$casesSR[$x],
					'dates'=>'-'
				];
				$dataCasesP = TurnManagementCases::create($atributosCasosP);
			}
		}

        //Variables del correo
        $email = Auth::user()->email;
        //Grupos e integrantes
        if($area == "test"){
            $area = "jsdiazs@indracompany.com, msachury@indracompany.com, msguerra@indracompany.com";
        }
        if($area == "lider"){
            $area = "merodriguezr@indracompany.com";
        }
        if($area == "compensar"){
            $area = "svasquez@indracompany.com, merodriguezr@indracompany.com";
        }
        if($area == "gestionOpDel"){
            $area = "jaromeroa@indracompany.com, ccalderonm@indracompany.com, masacevedo@indracompany.com, rcsandoval@indracompany.com, mfhernandez@indracompany.com, merodriguezr@indracompany.com";
        }
        if($area == "titan"){
            $area = "fctalero@indracompany.com, jcpiraquive@indracompany.com, lcmoralesc@indracompany.com, merodriguezr@indracompany.com";
        }
        if($area == "ireIaas"){
            $area = "jltrujillo@indracompany.com, hosanchez@indracompany.com, mshernandezc@indracompany.com, ncmarroquin@indracompany.com, hjbarrera@indracompany.com, merodriguezr@indracompany.com";
        }
        if($area == "ireIaasUnix"){
            $area = "mfigueroa@indracompany.com, falizcano@indracompany.com, yegarzon@indracompany.com, jmcaraballo@indracompany.com, merodriguezr@indracompany.com";
        }
        if($area == "ireIaasWin"){
            $area = "crbarbosa@indracompany.com, mjdiazr@indracompany.com, gazamora@indracompany.com, lchernandezv@indracompany.com, merodriguezr@indracompany.com";
        }
        if($area == "premium"){
            $area = "mcastanedaa@indracompany.com, merodriguezr@indracompany.com";
        }
        if($area == "notificacion"){
            $area = "cjcastrom@indracompany.com, ccmedina@indracompany.com, eybautista@indracompany.com, laalfonso@indracompany.com, merodriguezr@indracompany.com";
        }        
        $destinatario = $area;
        $copia = $email;
        $asunto = "Notificación entrega de turno";
        $cuerpo = "Este es un correo automático de notificación. $names ha realizado la entrega del turno $turn con las siguientes observaciones: $observations. Para más detalles, consultar en Asgard.";
        $adjunto = "";
        //dd($destinatario, $copia, $asunto, $cuerpo, $adjunto);
        //$this->sendEmail($destinatario,$copia, $asunto,$cuerpo,$adjunto);
        $string = "";
        //dd(app_path() . "\scripts\GENERAL_FUNCTIONS\R002-SendMail.ps1");
        $results = shell_exec("powershell.exe -executionpolicy bypass -NoProfile ". app_path() . "\scripts\TEST\R002-SendMail.ps1 -destinatario '$destinatario' -copia '$copia' -asunto '$asunto' -cuerpo '$cuerpo' -adjunto '$adjunto'" . escapeshellarg($string));
        //dd("powershell.exe -executionpolicy bypass -NoProfile ". app_path() . "\scripts\TEST\R002-SendMail.ps1 '-destinatario $destinatario -copia $copia -asunto $asunto -cuerpo $cuerpo -adjunto $adjunto'" . escapeshellarg($string));
        //dd($results);
        $mail = json_decode($results, true);
        //dd($mail);

        $data = TurnManagement::create($atributos);
        if(isset($data)){
            return redirect()->route('turns.turnManage')
                ->with('success', 'El registro de entrega de turno ha sido exitoso.');
        }else{
            return redirect()->route('turns.turnManage')
                ->withErrors(['Hubo un error al hacer la entrega de turno.']);
        }
    }

}
