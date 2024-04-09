<?php

namespace App\Http\Traits;

use App\Inventory;
use App\JobSchedule;
use App\ExecutionLog;
use App\History;
use App\ExternalToolLog;
use Illuminate\Support\Facades\Auth;
/**
 *
 */
trait ConnectionTrait
{

    public function getHostByInventoryAndGroup($inventory,$group)
    {
        $maquinas = Inventory::where('id_inventory', $inventory)->where('id_group',$group)->orderBy('name_host')->get('name_host');
        return $maquinas;
    }

    public function getGroups($inventario, $method, $server=NULL)
    {
        switch ($method) {
            case 'local':
                $grupos = Inventory::where('id_inventory',$inventario)->distinct()->orderBy('name_group')->get('name_group');
                $groups = array();
                foreach($grupos as $grupo){
                    array_push($groups, $grupo->name_group);
                }
                break;
            case 'api':
                $client = new \GuzzleHttp\Client();
                if(is_null($server)){
                    $serverURL = env('PROD_SERVER');
                    $AuthKey = env('AUTH_KEY');
                }else{
                    $serverURL = $server;
                    $AuthKey = env('AUTH_KEY');
                }
                $res = $client->request('GET', "http://$serverURL/api/v2/inventories/$inventario/groups", [
                    'headers' => [
                        'Authorization' => "Basic $AuthKey",
                    ],
                ]);
                $response =json_decode($res->getBody()->getContents(),true);
                $groups = array();
                foreach($response['results'] as $group){
                    if(isset($group['name'])){
                        array_push($groups, $group['name']);
                    }

                }
                break;


        }
        return $groups;
    }

    public function getHostsByGroup($inventory, $group, $method, $server=NULL)
    {
        switch ($method) {
            case 'local':
                $groups = array();
                /**/
                if(is_array($group)){
                    $groups = $group;
                }else{
                    array_push($groups, $group);
                }
                $maquinas = Inventory::where('id_inventory', $inventory)->whereIn('name_group',$groups)->orderBy('name_host')->get('name_host');
                $hosts = array();
                foreach($maquinas as $maquina){
                    array_push($hosts, $maquina->name_host);
                }
                break;
            case 'api':
                $client = new \GuzzleHttp\Client();
                if(is_null($server)){
                    $serverURL = env('PROD_SERVER');
                    $AuthKey = env('AUTH_KEY');
                }else{
                    $serverURL = $server;
                    $AuthKey = env('AUTH_KEY');
                }
                $hosts = array();
                $res = $client->request('GET', "http://$serverURL/api/v2/inventories/$inventory/hosts", [
                    'headers' => [
                        'Authorization' => "Basic $AuthKey",
                    ],
                ]);

                $response =json_decode($res->getBody()->getContents(),true);
                foreach($response['results'] as $host){
                    if(isset($host['summary_fields']['groups']['results'][0]['name']) && $host['summary_fields']['groups']['results'][0]['name'] == $group){
                        array_push($hosts, $host['name']);
                    }
                }
                if($response['next'] != null){
                    $i = 2;
                    do {
                        $res = $client->request('GET', "http://$serverURL/api/v2/inventories/$inventory/hosts?page=$i", [
                            'headers' => [
                                'Authorization' => "Basic $AuthKey",
                            ],
                        ]);
                        $response =json_decode($res->getBody()->getContents(),true);
                        foreach($response['results'] as $host){
                            if(isset($host['summary_fields']['groups']['results'][0]['name']) && $host['summary_fields']['groups']['results'][0]['name'] == $group){
                                array_push($hosts, $host['name']);
                            }
                        }
                        $i++;
                    } while ($response['next'] != null);

                }
                break;
        }
        return $hosts;
    }

    public function runPlaybook($idTemplate,$variables="",$server=NULL)
    {
        $client = new \GuzzleHttp\Client();
        if(is_null($server)){
            $serverURL = env('PROD_SERVER');
            $AuthKey = env('AUTH_KEY');
        }else{
            $serverURL = $server;
            $AuthKey = env('AUTH_KEY');
        }
        if($variables == ""){
            $res = $client->request('POST', "http://$serverURL/api/v2/job_templates/$idTemplate/launch/", [
                'headers' => [
                    'Authorization' => "Basic $AuthKey",
                ],
            ]);
        }else{
            $res = $client->request('POST', "http://$serverURL/api/v2/job_templates/$idTemplate/launch/", [
                'headers' => [
                    'Authorization' => "Basic $AuthKey",
                ],
                'json' => $variables,
            ]);
        }

        $resultado = json_decode($res->getBody()->getContents(),true);

        return $resultado;
    }
    public function runWorkFlow($idTemplate,$variables="",$server=NULL)
    {
        $client = new \GuzzleHttp\Client();
        if(is_null($server)){
            $serverURL = env('PROD_SERVER');
            $AuthKey = env('AUTH_KEY');
        }else{
            $serverURL = $server;
            $AuthKey = env('AUTH_KEY');
        }
        if($variables == ""){
            $res = $client->request('POST', "http://$serverURL/api/v2/workflow_job_templates/$idTemplate/launch/", [
                'headers' => [
                    'Authorization' => "Basic $AuthKey",
                ],
            ]);
        }else{
            $res = $client->request('POST', "http://$serverURL/api/v2/workflow_job_templates/$idTemplate/launch/", [
                'headers' => [
                    'Authorization' => "Basic $AuthKey",
                ],
                'json' => $variables,
            ]);
        }

        $resultado = json_decode($res->getBody()->getContents(),true);

        return $resultado;
    }
    /**
    * Store a newly log resource.
    *
    * @param  int $id_success
    *   Estados de los playbooks
    *       0 = en progreso...
    *   Exitosos
    *       1 = OK resultado sera un link local en asgard
    *       2 = OK resultado sera = campo resultado de la tabla
    *       3 = OK resultado consumirá el stdout de la API
    *       4 = OK resultado sera un link externo
    *       5 = OK resultado sera un link local en asgard
    *       6 = DISPONIBLE
    *       7 = DISPONIBLE
    *       8 = DISPONIBLE
    *       9 = DISPONIBLE
    * @param  int $id_failed
    *   Fallidos
    *       11 = DISPONIBLE
    *       12 = ERROR resultado sera = campo resultado de la tabla
    *       13 = ERROR resultado consumirá el stdout de la API
    * @param  int $form
    * 1 = Playbook
    * 2 = WorkFlow
    *
    * @param int $hostDelete
    * 0 = No
    * 1 = si
    * @param $server ip del servidor de ansible
    * @return App\ExternalToolLog;
     */
    public function getLog($id_success,$id_failed,$idTemplate = null, $form = 1,$hostDelete = 0, $server=NULL)
    {
        $log = ExecutionLog::create([
            'status' => 0,
            'user' => Auth::user()->username,
            'id_user' => Auth::user()->id,
            'user_group' => Auth::user()->group,
            'form' => $form,
            'del_host' => $hostDelete,
            'id_template' => $idTemplate,
            'id_success' => $id_success,
            'id_failed' => $id_failed,
            'server' => $server
        ]);
        return $log;
    }
    public function getExternalToolLog($script)
    {
        $log = ExternalToolLog::create([
            'd_ini_script' => date("Y-m-d H:i:s"),
            'status' => 0,
            'job_script' => $script,
            'user' => Auth::user()->username,
        ]);
        return $log;
    }
    public function resourcesLog($script, $status=2 , $mensaje="Ejecución realizada exitosamente")
    {
        $log = ExternalToolLog::create([
            'd_ini_script' => date("Y-m-d H:i:s"),
            'status' => 0,
            'job_script' => $script,
            'user' => Auth::user()->username,
            'd_end_script' => date("Y-m-d H:i:s"),
            'status' => $status,
            'result' => $mensaje,
        ]);
        return $log;
    }
    public function AddHostToInventory($idInventory,$variables,$name,$server=NULL)
    {
        $client = new \GuzzleHttp\Client();
        if(is_null($server)){
            $serverURL = env('PROD_SERVER');
            $AuthKey = env('AUTH_KEY');
        }else{
            $serverURL = $server;
            $AuthKey = env('AUTH_KEY');
        }
        $res = $client->request('GET', "http://$serverURL/api/v2/inventories/$idInventory/hosts/?search=$name", [
            'headers' => [
                'Authorization' => "Basic $AuthKey",
            ],
        ]);
        $resultado = json_decode($res->getBody()->getContents(),true);
        if($resultado['count'] > 0){
            foreach($resultado['results'] as $host){
                $idHost = $host['id'];
            }
            $varEnable = array("enabled" => true);
            $res = $client->request('PATCH', "http://$serverURL/api/v2/hosts/$idHost/", [
                'headers' => [
                    'Authorization' => "Basic $AuthKey",
                ],
                'json' => $varEnable,
            ]);
            //$resultado = json_decode($res->getBody()->getContents(),true);
        }else{
            $res = $client->request('POST', "http://$serverURL/api/v2/inventories/$idInventory/hosts/", [
                'headers' => [
                    'Authorization' => "Basic $AuthKey",
                ],
                'json' => $variables,
            ]);
            $resultado = json_decode($res->getBody()->getContents(),true);
            $idHost = $resultado['id'];
        }
        return $idHost;
    }
    public function disableHost($idHost,$server=NULL)
    {
        $client = new \GuzzleHttp\Client();
        if(is_null($server)){
            $serverURL = env('PROD_SERVER');
            $AuthKey = env('AUTH_KEY');
        }else{
            $serverURL = $server;
            $AuthKey = env('AUTH_KEY');
        }
        $varEnable = array("enabled" => false);
        $res = $client->request('PATCH', "http://$serverURL/api/v2/hosts/$idHost/", [
            'headers' => [
                'Authorization' => "Basic $AuthKey",
            ],
            'json' => $varEnable,
        ]);
        $resultado = json_decode($res->getBody()->getContents(),true);
        $status = $resultado['enabled'];
        return $status;
    }
    public function getScheduleLog($idTemplate)
    {
        $log = JobSchedule::create([
            'template_id' => $idTemplate,
            'user_id' => Auth::user()->id,
        ]);
        return $log;
    }

    public function jobSchedule($idTemplate,$variables,$scheduleLog,$server=NULL)
    {
        $client = new \GuzzleHttp\Client();
        if(is_null($server)){
            $serverURL = env('PROD_SERVER');
            $AuthKey = env('AUTH_KEY');
        }else{
            $serverURL = $server;
            $AuthKey = env('AUTH_KEY');
        }
        $res = $client->request('POST', "http://$serverURL/api/v2/job_templates/$idTemplate/schedules/", [
            'headers' => [
                'Authorization' => "Basic $AuthKey",
            ],
            'json' => $variables,
        ]);
        $resultado = json_decode($res->getBody()->getContents(),true);
        $scheduleLog->update([
            'id_schedule' => $resultado['id'],
            'r_rule' => $resultado['rrule'],
            'name' => $resultado['name'],
            'extra_data' => $resultado['extra_data'],
        ]);
        return $scheduleLog->id;
    }
    public function gethistory($id_asgard,$case,$valor_anterior,$valor_nuevo,$id_automatizacion,$idTemplate)
    {
        $history = History::create([
                'id_asgard' => $id_asgard,
                'id_caso' => $case,
                'valor_anterior' => $valor_anterior,
                'valor_nuevo' => $valor_nuevo,
                'id_automatizacion' => $id_automatizacion,
                'usuario' => Auth::user()->username,
				'id_playbook'=> $idTemplate,
        ]);
        return $history;
    }
    public function sendEmail($mail="",$copy="", $affair="", $body = "" , $attached="" )
    {
        # code...
        $string = "";
        //dd(app_path() . "\scripts\SAN\R001-ExecutionScripts.ps1");
        $results = exec("powershell.exe -executionpolicy bypass -NoProfile ". app_path() . "\scripts\GENERAL_FUNCTIONS\R002-SendMail.ps1 -destinatario '$mail' -copia '$copy' -asunto '$affair' -cuerpo '$body' -adjunto '$attached'" . escapeshellarg($string));
        //dd($results);
        $mail = json_decode($results, true);
        //dd($mail);

        return $mail;
    }


}
