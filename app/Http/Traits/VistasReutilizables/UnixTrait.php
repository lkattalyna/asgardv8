<?php

namespace App\Http\Traits\VistasReutilizables;
use Illuminate\Support\Facades\Storage;
trait UnixTrait
{

    public function testConectividadUnixStore( $request,$idTemplate )
    {

        $campos = $request->all();
        $HOST = $campos["host"][0];
        $ips_ping_destino = array_values($campos["ipDestino"]);
        $ips_telnet_destino = array_values($campos["ipTelnet"]);
        $ports_telnet_destino = array_values($campos["puertoTelnet"]);
        $telnet_opts= array();
        $do_ping    = "false";
        $do_telnet  = "false";
        $do_tracert = "false";
        $log = $this->getLog(5,13,$idTemplate);
        $id_asgard = $log->id;

        if(count($ips_telnet_destino) == count($ports_telnet_destino)){
            for($i = 0; $i<count($ips_telnet_destino);$i++){
                $arr_ips_destino = ['ip' => $ips_telnet_destino[$i]];
                $arr_ports_destino = ['port' => $ports_telnet_destino[$i]];
                $telnet_opts []= \Arr::collapse([$arr_ips_destino,$arr_ports_destino]);
            }
        }

       if( in_array("ping",$campos["tipoAccion"])){
           $do_ping    = "true";
       }

       if( in_array("telnet",$campos["tipoAccion"])){
           $do_telnet  = "true";
       }

       if( in_array("tracer",$campos["tipoAccion"])){
           $do_tracert = "true";
       }
       $variables = array("extra_vars" =>
            [
            "host"  => $HOST,
            "id_asgard" => $id_asgard,
            "telnet_opts" => $telnet_opts,
            "ips_ping_destino" => $ips_ping_destino,
            "ips_tracert_destino" => $ips_ping_destino,
            "do_ping" => $do_ping,
            "do_telnet" => $do_telnet,
            "do_tracert" => $do_tracert
            ]
        );

       $resultado = $this->runPlaybook($idTemplate,$variables);

       if($do_ping=='true'){
            $ping = 'ping';
            foreach($ips_ping_destino as $obj){
                $history = $this->gethistory($id_asgard,$ping,$obj,$obj,5,$idTemplate);
           }
       }
       if($do_tracert =='true'){
        $tracert = 'tracert';
            foreach($ips_ping_destino as $obj){
                $history = $this->gethistory($id_asgard,$tracert,$obj,$obj,5,$idTemplate);
            }
       }
       if($do_telnet =='true'){
        $telnet = 'telnet';
            foreach($telnet_opts as $obj){
                $history = $this->gethistory($id_asgard,$telnet,implode(':',$obj),implode(':',$obj),5,$idTemplate);
            }
       }
       $resultado = $resultado['job'];
       $log->update([
           'id_job' => $resultado,
           'result' => "/UNIX/UNIX_CONECTIVIDAD_001/$id_asgard.html",

       ]);
       return redirect()->route('executionLogs.show',$id_asgard);
    }

    public function changeStoreUnix($request,$idTemplate)
    {

        $this->validate($request, [
            'host' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);
        // $idTemplate = 55; // creacion y eliminacion de usuarios
        // $log = $this->getLog(3,13,$idTemplate);
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "user"=> $request->username, "password" => $request->password, "action" => 'Reset',
        "id_asgard" => $id_asgard));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'result' => "http://172.22.16.179:443/$id_asgard",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }


    public function checkSOUnixStore($request, $idTemplate)
    {

        $this->validate($request, [
            'host' => 'required',
        ]);

        // $idTemplate = 375;
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





    /**
     * OLD: restartServiceStore UnixController
     * NEW: 2022-02-28
     * @param $request: Request Object
     * @param $idTemplate: Template AWX
     * @return redirect: Ejecucion en espera hasta resolverse
     */
    public function serviceManagementV2UnixStore($request, $idTemplate)
    {
        $this->validate($request, [
            'host' => 'required',
            'op' => 'required|string',
            'service' => 'required|string|min:1|max:50',
        ]);
        // $idTemplate = 357;
        // $log = $this->getLog(3,13,$idTemplate);
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array(
            "HOST" => $request->host,
            "service_state" => $request->input('op'),
            "service_name" => $request->input('service'),
            "id_asgard" => $id_asgard
        ));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
            'result' => "http://172.22.16.179:443/$id_asgard",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }


    /**
     * NEW 2022-02-28: RestartServiceStore UnixController
     * Ejecucion Playbook auxiliar del playbook
     * @param $request: Request Object
     * @param $idTemplate: Template AWX
     * @return redirect: Url de resultado en JSON esperado
     */
    public function getServicesUnixByHost( $request, $idTemplate ) {

        $this->validate($request, [
            'host' => 'required'
        ]);

        // $idTemplate = 473;
        //$log = $this->getLog(5,13,$idTemplate);
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

        $finalRequest = [
            "id_job"    => $resultado,
            "url"       => "file/-UNIX-UNIX_018_GETSERVICE/".$id_asgard.".json"
        ];


        $log->update([
            'id_job' => $resultado,
        ]);
        return response()->json(["data" => $finalRequest]);
    }

    public function activacionEnvioLogsUnixStore($request , $idTemplate){
        $this->validate($request, [
            'host' => 'required',
            'logName' => 'required',
        ]);
        $campos =$request->all();
        if(isset($campos['checkMailSending'])){
            $this->validate($request, [
                'email_destinatario' => 'required',
            ],[
                'email_destinatario.required'=>'El campo correo electrónico es obligatorio.'
            ]);
        }
        $HOST = $campos["host"][0];
        $log = $this->getLog(5,13,$idTemplate);
        $id_asgard = $log->id;
        $log_name=(string)$campos["logName"];
        $variables = array("extra_vars" =>
            [
                "HOST"  => $HOST,
                "id_asgard" => $id_asgard,
                "message_log"=> $log_name,
            ]
        );
        $resultado =$this->runPlaybook($idTemplate,$variables);
        $adjunto = "E:\\FILES\\UNIX\\UNIX_LOGS_004\\".$id_asgard.".json";
        $string="";
        if(!isset($campos['checkMailSending'])){
            $createdFile = false;
            do{
                $createdFile=Storage::disk('fileserver')->exists('\\UNIX\\UNIX_LOGS_004\\'.$id_asgard.'.json');
                if($createdFile){
                    $results = shell_exec("powershell.exe -executionpolicy bypass -NoProfile ". app_path() . "\scripts\TEST\R004_DeleteFileAtt.ps1 -adjunto '$adjunto'" . escapeshellarg($string));
                    break;
                }
            } while(!$createdFile);

            $resultado = $resultado['job'];
            $log->update([
                'id_job' => $resultado,
                'result' => "/UNIX/UNIX_LOGS_HTML_005/$id_asgard.html",
            ]);
            return redirect()->route('executionLogs.show',$id_asgard);
        }else{
            $destinatario =$campos['email_destinatario'];
            $asunto = "Generación Log ".$id_asgard." - Message ".$log_name." - server ".$HOST;
            $cuerpo ="Apresiado(a) usuario, Asgard envía el log ".$id_asgard.".csv, el cual se encontrara como archivo adjunto en este correo.";
            $sendMail = false;
            do{
                $sendMail=Storage::disk('fileserver')->exists('\\UNIX\\UNIX_LOGS_004\\'.$id_asgard.'.json');
                if($sendMail){
                    $results = shell_exec("powershell.exe -executionpolicy bypass -NoProfile ". app_path() . "\scripts\TEST\R003-SendMail-Attached.ps1 -destinatario '$destinatario' -asunto '$asunto' -cuerpo '$cuerpo' -adjunto '$adjunto'" . escapeshellarg($string));
                    $mail = json_decode($results, true);
                    break;
                }
            } while(!$sendMail);

            $resultado = $resultado['job'];
            $log->update([
                'id_job' => $resultado,
                'result' => "/UNIX/UNIX_LOGS_HTML_005/$id_asgard.html",
            ]);
            if($mail['response']){
                    return redirect()->route('executionLogs.show',$id_asgard)->with('success', ' El envío de correo electrónico al destinatario "'.$destinatario.'" fue exitoso.');
            }else{
                    return redirect()->route('executionLogs.show',$id_asgard)->with('error', ' El envío de correo electrónico al destinatario "'.$destinatario.'" fue fallido. '.$mail['error']);
            }
        }
    }

    public function getListLogNameUnixByHost($request , $idTemplate) {

            $this->validate($request, [
                'host' => 'required'
            ]);

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
                "url"       => "file/-UNIX-UNIX_MESSAGE_003/".$id_asgard.".json"
            ];
            return response()->json(["data" => $finalRequest]);
    }
    
    public function unixUptimeStore($request,$idTemplate)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'result' => "http://172.22.16.179:443/$id_asgard",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }

    public function rutasEstaticasStore(Request $request,$idTemplate)
    {
        $this->validate($request, [
            'host' => 'required',
            'action' => 'required',
            'interface' => 'required',
            'ip' => 'required|ipv4',
            'mask' => 'required|integer',
        ]);        
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard, "action" => $request->action, "interface" => $request->interface,
                    "ip" => $request->ip, "mask" => $request->mask));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'result' => "http://172.22.16.179:443/$id_asgard",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }

    public function inventarioStore($request,$idTemplate)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'result' => "http://172.22.16.179:443/$id_asgard",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }

}
