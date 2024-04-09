<?php

namespace App\Http\Traits\VistasReutilizables;
use Illuminate\Support\Facades\Storage;
trait WindowsTrait
{


    public function testConectividadStore( $request, $idTemplate ){
        $campos = $request->all();
        $HOST = $campos["host"][0];
        $ips_ping_destino = array_values($campos["ipDestino"]);
        $ips_telnet_destino = array_values($campos["ipTelnet"]);
        $ports_telnet_destino = array_values($campos["puertoTelnet"]);
        $telnet_opts= array();
        $do_ping    = "false";
        $do_telnet  = "false";
        $do_tracert = "false";
        // $idTemplate = $idTemplate;
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
                $history = $this->gethistory($id_asgard,$ping,$obj,$obj,6,$idTemplate);
           }
       }
       if($do_tracert =='true'){
        $tracert = 'tracert';
            foreach($ips_ping_destino as $obj){
                $history = $this->gethistory($id_asgard,$tracert,$obj,$obj,6,$idTemplate);
            }
       }
       if($do_telnet =='true'){
        $telnet = 'telnet';
            foreach($telnet_opts as $obj){
                $history = $this->gethistory($id_asgard,$telnet,implode(':',$obj),implode(':',$obj),6,$idTemplate);
            }
       }
       $resultado = $resultado['job'];
       $log->update([
           'id_job' => $resultado,
           'result' => "/WINDOWS/WIN_CONECTIVIDAD_001/$id_asgard.html",
       ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }



    public function getServicesByHost( $request, $idTemplate ) {

        $this->validate($request, [
            'host' => 'required'
        ]);

        // $idTemplate = 473;
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


    public function serviceManagementStoreV2($request , $idTemplate )
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
            // $idTemplate = 262;
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

       public function activacionEnvioLogsStore($request , $idTemplate){
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
                    "log_name"=> $log_name,
                ]
            );
            $resultado =$this->runPlaybook($idTemplate,$variables);
            $adjunto = "E:\\FILES\\WINDOWS\\WIN_LOGS_004\\".$id_asgard.".json";
            $string="";
            if(!isset($campos['checkMailSending'])){
                $createdFile = false;
                do{
                    $createdFile=Storage::disk('fileserver')->exists('\\WINDOWS\\WIN_LOGS_004\\'.$id_asgard.'.json');
                    if($createdFile){
                        $results = shell_exec("powershell.exe -executionpolicy bypass -NoProfile ". app_path() . "\scripts\TEST\R004_DeleteFileAtt.ps1 -adjunto '$adjunto'" . escapeshellarg($string));
                        break;
                    }
                } while(!$createdFile);

                $resultado = $resultado['job'];
                $log->update([
                    'id_job' => $resultado,
                    'result' => "/WINDOWS/WIN_LOGS_HTML_005/$id_asgard.html",
                ]);
                return redirect()->route('executionLogs.show',$id_asgard);
            }else{
                $destinatario =$campos['email_destinatario'];
                $asunto = "Generación Log ".$id_asgard." - LogName ".$log_name." - server ".$HOST;
                $cuerpo ="Apresiado(a) usuario, Asgard envía el log ".$id_asgard.".csv, el cual se encontrara como archivo adjunto en este correo.";
                $sendMail = false;
                do{
                    $sendMail=Storage::disk('fileserver')->exists('\\WINDOWS\\WIN_LOGS_004\\'.$id_asgard.'.json');
                    if($sendMail){
                        $results = shell_exec("powershell.exe -executionpolicy bypass -NoProfile ". app_path() . "\scripts\TEST\R003-SendMail-Attached.ps1 -destinatario '$destinatario' -asunto '$asunto' -cuerpo '$cuerpo' -adjunto '$adjunto'" . escapeshellarg($string));
                        $mail = json_decode($results, true);
                        break;
                    }
                } while(!$sendMail);

                $resultado = $resultado['job'];
                $log->update([
                    'id_job' => $resultado,
                    'result' => "/WINDOWS/WIN_LOGS_HTML_005/$id_asgard.html",
                ]);
                if($mail['response']){
                        return redirect()->route('executionLogs.show',$id_asgard)->with('success', ' El envío de correo electrónico al destinatario "'.$destinatario.'" fue exitoso.');
                }else{
                        return redirect()->route('executionLogs.show',$id_asgard)->with('error', ' El envío de correo electrónico al destinatario "'.$destinatario.'" fue fallido. '.$mail['error']);
                }
            }
        }

        public function getListLogNameByHost($request , $idTemplate) {

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
                    "url"       => "file/-WINDOWS-WIN_GET_LOGNAME_003/".$id_asgard.".json"
                ];
                return response()->json(["data" => $finalRequest]);
        }


    public function changeStoreWIN($request, $idTemplate)
    {
        $this->validate($request, [
            'host' => 'required',
            'tipo' => 'required',
            'username' => 'required',
            'password' => 'required',
            'case' => 'required',
        ]);

        // dd("probando funcionamiento");
        // $idTemplate = 72; // creacion y eliminacion de usuarios

        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "rdp_user"=> $request->username, "rdp_password" => $request->password, "rdp_case" => $request->case,
        "item" => 'Reset', "item2" => $request->tipo, "id_asgard" => $id_asgard));
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

    public function checkCPUProcessStoreWIN($request, $idTemplate)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);

        // dd("probando fun",$request->host);
        // $idTemplate = 313;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard ));
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


    /**
     *
     * NEW 2022-03-24 rutasEstaticasWINStore
     * OLD rutasEstaticasStore WindowsController
     * Ejecucion Playbook
     * @param $request: Request Object
     * @param $idTemplate: Template AWX
     * @return redirect: Url de resultado en JSON esperado
     */
    public function rutasEstaticasWINStore($request, $idTemplate)
    {

        if($request->item == 'adds'){
            $this->validate($request, [
                'host' => 'required|array|max:5',
                'item' => 'required',
                'destination' => 'required|ipv4',
                'gateway' => 'required|ipv4',
                'metric' => '',
                'mask' => 'required|ipv4',

            ]);
        }elseif($request->item == 'deletes'){
            $this->validate($request, [
                'host' => 'required|array|max:5',
                'item' => 'required',
                'destination' => 'required|ipv4',
            ]);
        }

        // $idTemplate = 100;
        // dd($idTemplate);
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        if($request->item == 'adds'){
            $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard, "item" => $request->item, "item_destination" => $request->destination,
                    "item_gateway" => $request->gateway, "item_mask" => $request->mask, "item_metric" => $request->metric));
        }elseif($request->item == 'deletes'){
            $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard, "item" => $request->item, "item_destination" => $request->destination));
        }
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

    /**
     *
     * NEW 2022-03-24 extUptimeWINStore
     * OLD extUptimeStore WindowsController
     * Ejecucion Playbook
     * @param $request: Request Object
     * @param $idTemplate: Template AWX
     * @return redirect: Url de resultado en JSON esperado
     */
    public function extUptimeWINStore($request, $idTemplate)
    {
        $this->validate($request, [
            'host' => 'required|array|max:5',
        ]);
        // $idTemplate = 230;
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

    /**
     *
     * NEW 2022-03-24 inventarioWINStore
     * OLD inventarioStore WindowsController
     * Ejecucion Playbook
     * @param $request: Request Object
     * @param $idTemplate: Template AWX
     * @return redirect: Url de resultado en JSON esperado
     */
    public function inventarioWINStore($request, $idTemplate)
    {
        $this->validate($request, [
            'host' => 'required|array|max:5',
        ]);
        // $idTemplate = 120;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard));
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


}
