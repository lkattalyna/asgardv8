<?php

namespace App\Http\Controllers;

use App\Inventory;
use Illuminate\Http\Request;
use App\Http\Traits\ConnectionTrait;

class BalancerController extends Controller
{
    Use ConnectionTrait;
    private $method = "local";

    ////////////////////////////////////////////////////////Conexión al API BAl///////////////////////////////////////////////////////////////////

    public function getBalancers($ip)
    {
        $client = new \GuzzleHttp\Client(['verify' => false ]);
        $serverURL = $ip;
        $AuthKey = 'QXV0b0JhbDpDb250cm9sMjAyMCo=';
        $res = $client->request('GET', "https://$serverURL/mgmt/tm/ltm/node", [
            'headers' => [
                'Authorization' => "Basic $AuthKey",
                'Cookie' => [
                    'BIGIPAuthCookie' => '65D01FB640A4AFFB8A91E9823AB5E7EAF6600188',
                    'BIGIPAuthUsernameCookie' => 'AutoBal',
                ],
            ],
        ]);
        $response =json_decode($res->getBody()->getContents(),true);
        //dd($response);
        $balancers = array();
        foreach($response['items'] as $balancer){
            if(isset($balancer['name'])){
                array_push($balancers, $balancer['name']);
            }

        }
        //dd($balancers);
        return $balancers;
    }
    public function getPools($ip)
    {
        $client = new \GuzzleHttp\Client(['verify' => false ]);
        $serverURL = $ip;
        $AuthKey = 'QXV0b0JhbDpDb250cm9sMjAyMCo=';
        $res = $client->request('GET', "https://$serverURL/mgmt/tm/ltm/pool", [
            'headers' => [
                'Authorization' => "Basic $AuthKey",
                'Cookie' => [
                    'BIGIPAuthCookie' => '65D01FB640A4AFFB8A91E9823AB5E7EAF6600188',
                    'BIGIPAuthUsernameCookie' => 'AutoBal',
                ],
            ],
        ]);
        $response =json_decode($res->getBody()->getContents(),true);
        //dd($response);
        $pools = array();
        foreach($response['items'] as $pool){
            if(isset($pool['name'])){
                array_push($pools, $pool['name']);
            }

        }
        //dd($pools);
        return $pools;
    }
    public function getBalancerState($ip)
    {
        $client = new \GuzzleHttp\Client(['verify' => false ]);
        $serverURL = $ip;
        $AuthKey = 'QXV0b0JhbDpDb250cm9sMjAyMCo=';
        $res = $client->request('GET', "https://$serverURL/mgmt/tm/sys/failover", [
            'headers' => [
                'Authorization' => "Basic $AuthKey",
                'Cookie' => [
                    'BIGIPAuthCookie' => '65D01FB640A4AFFB8A91E9823AB5E7EAF6600188',
                    'BIGIPAuthUsernameCookie' => 'AutoBal',
                ],
            ],
        ]);
        $response =json_decode($res->getBody()->getContents(),true);
        //dd($response);
        if (strpos($response['apiRawValues']['apiAnonymous'], 'active') !== false) {
            $status = 'active';
        }
        if (strpos($response['apiRawValues']['apiAnonymous'], 'standby') !== false) {
            $status = 'standby';
        }
        //dd($status);
        return $status;
    }
    //////////////////////////////////////////////////////////////Fin API BAL////////////////////////////////////////////////////////////////////////

    public function nodoF5()
    {
        $inventario = 22;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('balancers.nodoF5',compact('groups','inventario'));
    }


    public function nodoF5Store(Request $request)
    {
        $this->validate($request, [
            'group' => 'required',
            'host' => 'required|ipv4',
            'name' => 'required',
            'state' => 'required',
        ]);
        $idTemplate = 67;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "name" => $request->name, "state" => $request->state));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);*/
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
    public function nodoNS()
    {
        $inventario = 52;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('balancers.nodoNS',compact('groups','inventario'));
    }


    public function nodoNSStore(Request $request)
    {
        $this->validate($request, [
            'group' => 'required',
            'servidor' => 'required',
            'state' => 'required',
        ]);
        $idTemplate = 68;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->group, "servidor" => $request->name, "state" => $request->state));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);*/
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
    public function snatF5()
    {
        //$inventario = 22;
        return view('balancers.snatF5');
    }


    public function snatF5Store(Request $request)
    {
        $this->validate($request, [
            'member' => 'required',
            'state' => 'required',
        ]);
        $idTemplate = 69;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => 'CORREO_JES', "member" => $request->member, "state" => $request->state));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);*/
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
    public function adminPuertosF5()
    {
        $inventario = 22;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('balancers.adminPuertosF5',compact('groups','inventario'));
    }


    public function adminPuertosF5Store(Request $request)
    {
        $this->validate($request, [
            'group' => 'required',
            'host' => 'required|ipv4',
            'name' => 'required|string',
            'pool' => 'required|string',
            'port' => 'required|integer',
            'state' => 'required|string',
        ]);
        $request->host;
        $idTemplate = 130;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "name" => $request->name, "state" => $request->state, "pool" => $request->pool, "port" => $request->port));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);*/
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
        ]);
        //dd($resultado);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
    public function servicioNS()
    {
        $inventario = 52;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('balancers.servicioNS',compact('groups','inventario'));
    }


    public function servicioNSStore(Request $request)
    {
        $this->validate($request, [
            'group' => 'required',
            'service' => 'required|string',
            'state' => 'required|string',
        ]);
        $idTemplate = 133;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->group, "state" => $request->state, "servicio" => $request->service));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);*/
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
        ]);
        //dd($resultado);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
    public function grupoServicioNS()
    {
        $inventario = 52;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('balancers.grupoServicioNS',compact('groups','inventario'));
    }


    public function grupoServicioNSStore(Request $request)
    {
        $this->validate($request, [
            'group' => 'required',
            'sgroup' => 'required|string',
            'nserver' => 'required|string',
            'port' => 'required|integer',
            'state' => 'required|string'
        ]);
        $idTemplate = 134;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->group, "grupo" => $request->sgroup, "servidor" => $request->nserver, "puerto" => $request->port, "state" => $request->state));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);*/
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
        ]);
        //dd($resultado);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
    public function addVSF5()
    {
        $inventario = 22;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('balancers.addVSF5',compact('groups','inventario'));
    }


    public function addVSF5Store(Request $request)
    {
        $this->validate($request, [
            'group' => 'required',
            'host' => 'required|ipv4',
            'name' => 'required|string',
            'ipVS' => 'required|ipv4',
            'portVS' => 'required|integer',
            'nodos' => 'required'
        ]);
        //dd('PASO');
        $idTemplate = 129;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $nodos = array();
        foreach($request->nodos as $nodo){
            $node = explode('*',$nodo);
            array_push($nodos,["IP_nodo" => $node[1], "name_nodo" => $node[0], "port_nodo" => $node[2]]);
        }
        //dd($nodos);
        $variables = array("extra_vars" => array("HOST" => $request->host, "Descripcion" => $request->description, "IP_VS" => $request->ipVS, "Puerto_VS" => $request->portVS,
        "Nombre_Servicio" => str_replace(' ','_',$request->name), "test" => $nodos));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
        ]);
        //dd($resultado);
        return redirect()->route('executionLogs.show',$id_asgard);

    }

    //////////////////////////////////////////////

    public function addVSNS()
    {
        $inventario = 52;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('balancers.addVSNS',compact('groups','inventario'));
    }


    public function addVSNSStore(Request $request)
    {
        $this->validate($request, [
            'group' => 'required',
            'name' => 'required|string',
            'ipVS' => 'required|ipv4',
            'portVS' => 'required|integer',
            'vsProtocol' => 'required',
            'vsDomain' => 'required|integer',
            'portN' => 'required|integer',
            'cServer' => 'required|integer',
            'nodos' => 'required'
        ]);
        if($request->cServer == 1){
            $node = explode('*',$request->nodos[0]);
            $variables = array("extra_vars" => array("HOST" => $request->group, "dirip" => $request->ipVS, "puerto" => $request->portVS, "id" => $request->vsDomain,
                "svcport" => $request->portN, "nom_lbvs" => str_replace(' ','_',$request->name),"protocolo" => $request->vsProtocol,"dirIP1" => $node[1], "servidor1" => $node[0]));
            $idTemplate = 142;
        }elseif($request->cServer == 2){
            $node = explode('*',$request->nodos[0]);
            $node1 = explode('*',$request->nodos[1]);
            $variables = array("extra_vars" => array("HOST" => $request->group, "dirip" => $request->ipVS, "puerto" => $request->portVS, "id" => $request->vsDomain,
                "svcport" => $request->portN, "nom_lbvs" => str_replace(' ','_',$request->name),"protocolo" => $request->vsProtocol,
                "dirIP1" => $node[1], "servidor1" => $node[0], "dirIP2" => $node1[1], "servidor2" => $node1[0]));
            $idTemplate = 136;
        }
        //dd(json_encode($variables));
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
        ]);
        //dd($resultado);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
    public function uptimeF5()
    {
        $inventario = 22;
        $groups = $this->getGroups($inventario,$this->method);
        return view('balancers.uptimeF5',compact('groups','inventario'));
    }


    public function uptimeF5Store(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $idTemplate = 252;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "id_asgard" => $id_asgard));
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
    public function requestNS()
    {
        $inventario = 52;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('balancers.requestNS',compact('groups','inventario'));
    }


    public function requestNSStore(Request $request)
    {
        $this->validate($request, [
            'group' => 'required',
            'ou' => 'required|string',
            'ciudad' => 'required|string',
            'dpto' => 'required|string',
            'nomcomun' => 'required|string',
            'organizacion' => 'required|string'
        ]);
        if(!is_null($request->input('correo'))){
            $this->validate($request, [
                'correo' => 'required|email',
            ]);
        }
        $idTemplate = 240;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->group, "OU" => $request->input('ou'), "ciudad" => $request->input('ciudad'), "correo" => $request->input('correo'),
            "dpto" => $request->input('dpto'), "nomcomun" => $request->input('nomcomun'), "organizacion" => $request->input('organizacion')));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
        ]);
        //dd($resultado);
        return redirect()->route('executionLogs.show',$id_asgard);

    }

    public function sslCertNS()
    {
        $inventario = 52;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('balancers.sslCertNS',compact('groups','inventario'));
    }


    public function sslCertNSStore(Request $request)
    {
        $this->validate($request, [
            'group' => 'required',
            'nomcertificado' => 'required|string',
            'cert' => 'required|string|min:1500|max:2000'
        ]);
        $idTemplate = 241;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->group, "nomcertificado" => $request->input('nomcertificado'), "codcertificado" => $request->input('cert') ));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
        ]);
        //dd($resultado);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
    public function perfilSSLF5()
    {
        $inventario = 22;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('balancers.perfilSSLF5',compact('groups','inventario'));
    }


    public function perfilSSLF5Store(Request $request)
    {
        $this->validate($request, [
            'group' => 'required',
            'name' => 'required|string|min:1|max:50',
            'crt' => 'required|string|min:1|max:50',
            'key' => 'required|string|min:1|max:50',
        ]);
        // 'host' => 'required|ipv4', agregar campo
        $idTemplate = 232;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->group, "name" => str_replace(' ','_',$request->name), "crt" => $request->crt, "key" => $request->input('key')));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
        ]);
        //dd($resultado);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
    public function requestF5()
    {
        $inventario = 22;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('balancers.requestF5',compact('groups','inventario'));
    }


    public function requestF5Store(Request $request)
    {
        $this->validate($request, [
            'group' => 'required',
            'name' => 'required|string|min:1|max:50',
            'cn' => 'required|string|min:1|max:50',
            'org' => 'required|string|min:1|max:50',
            'ou' => 'required|string|min:1|max:50',
        ]);
        if(is_null($request->input('subject'))){
            $subject = "";
        }else{
            $subject = $request->input('subject');
        }
        if(is_null($request->input('mail'))){
            $mail = "";
        }else{
            $mail = $request->input('mail');
        }
        //dd($request);
        // 'host' => 'required|ipv4', agregar campo
        $idTemplate = 231;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->group, "Name" => str_replace(' ','_',$request->name), "cn" => str_replace(' ','_',$request->input('cn')), "id_asgard" => $id_asgard,
            "mail" => $mail, "org" => str_replace(' ','_',$request->input('org')), "ou" => str_replace(' ','_',$request->input('ou')), "subject" => $subject));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
        ]);
        //dd($resultado);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
    public function healthCheckNS()
    {
        $inventario = 52;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('balancers.healthCheckNS',compact('groups','inventario'));
    }


    public function healthCheckNSStore(Request $request)
    {
        $this->validate($request, [
            'group' => 'required',
        ]);
        $idTemplate = 285;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->group));
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
    public function healthCheckF5()
    {
        $inventario = 22;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('balancers.healthCheckF5',compact('groups','inventario'));
    }


    public function healthCheckF5Store(Request $request)
    {
        $this->validate($request, [
            'group' => 'required',
            'email' => 'required|email',
        ]);
        $idTemplate = 287;
        $log = $this->getLog(4,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->group, "id_asgard" => $id_asgard, "mail" => $request->input('email')));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
            'result' => "http://172.22.16.179:443/$id_asgard/Estado_Balanceadores_F5.html",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
    public function nodosGTMF5()
    {
        $inventario = 64;
        $hosts = Inventory::where('id_inventory', $inventario)->orderBy('name_host')->get('name_host');
        return view('balancers.nodosGTMF5',compact('hosts','inventario'));
    }

    public function nodosGTMF5Store(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'ipGTM' => 'required|ipv4',
            'server' => 'required|string|min:1|max:50',
            'status' => 'required',
            'vs' => 'required|string|min:1|max:60',
        ]);
        $idTemplate = 296;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->input('host'), "IP_GTM" => $request->input('ipGTM'), "Server_GTM" => $request->input('server'),
            "Status" => $request->input('status'), "VS_GTM" => $request->input('vs')));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
        ]);
        //dd($resultado);
        return redirect()->route('executionLogs.show',$id_asgard);

    }

    public function addServiceMemberNS()
    {
        $inventario = 52;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('balancers.addServiceMemberNS',compact('groups','inventario'));
    }


    public function addServiceMemberNSStore(Request $request)
    {
        $this->validate($request, [
            'group' => 'required',
            'sgroup' => 'required|string',
            'nserver' => 'required|string',
            'port' => 'required|integer',
        ]);
        $idTemplate = 312;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->group, "grupo" => $request->sgroup, "servidor" => $request->nserver, "svcport" => $request->port));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //d($resultado);
        $log->update([
            'id_job' => $resultado,
        ]);
        //dd($resultado);
        return redirect()->route('executionLogs.show',$id_asgard);

    }

    public function addServerNS()
    {
        $inventario = 52;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('balancers.addServerNS',compact('groups','inventario'));
    }


    public function addServerNSStore(Request $request)
    {
        $this->validate($request, [
            'group' => 'required',
            'server' => 'required|string',
            'snipaddr' => 'required|ipv4',
            'id' => 'required|string',
        ]);
        $idTemplate = 311;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->group, "servidor" => $request->input('server'), "dirIP" => $request->dirIP, "id" => $request->id));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //d($resultado);
        $log->update([
            'id_job' => $resultado,
        ]);
        //dd($resultado);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
    public function reportMemberLB()
    {
        $inventario = 52;
        $groups = $this->getGroups($inventario,$this->method);
        return view('balancers.reportMemberLB',compact('groups','inventario'));
    }
    public function reportMemberLBStore(Request $request)
    {
        $this->validate($request, [
            'group' => 'required',
            'host' => 'required',
        ]);
        $idTemplate = 388;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->group, "virtualserver" => $request->host));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
        ]);
        //dd($resultado);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function reportInventoryLB()
    {
        $inventario = 52;
        $groups = $this->getGroups($inventario,$this->method);
        return view('balancers.reportInventoryLB',compact('groups','inventario'));
    }
    public function reportInventoryLBStore(Request $request)
    {
        $this->validate($request, [
            'group' => 'required',
        ]);
        $idTemplate = 390;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->group));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
        ]);
        //dd($resultado);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function visorMobile()
    {
        $inventario = 22;
        $groups = $this->getGroups($inventario,$this->method);
        return view('balancers.visorMobile',compact('groups','inventario'));
    }


    public function visorMobileStore(Request $request)
    {
        $this->validate($request, [
            //'group' => 'required',
            'email' => 'required|email',
        ]);
        $idTemplate = 391;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("id_asgard" => $id_asgard, "mail" => $request->input('email')));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
            //'result' => "http://172.22.16.179:443/$id_asgard/Estado_Balanceadores_F5.html",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
    public function visorUnique()
    {
        $inventario = 52;
        $groups = $this->getGroups($inventario,$this->method);
        return view('balancers.visorUnique',compact('groups','inventario'));
    }


    public function visorUniqueStore(Request $request)
    {
        $this->validate($request, [
            //'group' => 'required',
            'email' => 'required|email',
        ]);
        $idTemplate = 400;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("id_asgard" => $id_asgard, "correo" => $request->input('email')));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
            //'result' => "http://172.22.16.179:443/$id_asgard/Estado_Balanceadores_F5.html",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
    public function addSnipNS()
    {
        $inventario = 52;
        $groups = $this->getGroups($inventario,$this->method);
        return view('balancers.addSnipNS',compact('groups','inventario'));
    }
    public function addSnipNSStore(Request $request)
    {
        $this->validate($request, [
            'group' => 'required',
            'snipaddr' => 'required|ipv4',
            'mascara' => 'required|ipv4',
        ]);
        $idTemplate = 431;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->group, "snipaddr" => $request->snipaddr, "mascara" => $request->mascara, "id" => $request->id, "vlanid" => $request->vlanid ));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //d($resultado);
        $log->update([
            'id_job' => $resultado,
        ]);
        //dd($resultado);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
	public function addVlanCitrix()
    {
        $inventario = 52;
        $groups = $this->getGroups($inventario,$this->method);
        $backpack = [
            "inventario" => $inventario,
            "groups" => $groups,
            "tituloVista" => "Adición VLAN ID Citrix NS" ,
            "descripcion" => "Creación y adición VLAN ID Citrix NS ADC"
        ];

        return view('balancers.addVlanCitrix',$backpack);
    }

    public function addVlanCitrixStore(Request $request)
    {
        $this->validate($request, [
            'group' => 'required',
            'etiqueta' => 'required',
            'vlanid' => 'required',
        ]);

        $campos = $request->all();
        $idTemplate = 430;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => [
            "HOST" => $campos['group'],
            "etiqueta" => $campos['etiqueta'],
            "vlanid" => $campos['vlanid'],
            "id"     => $campos["id"]
        ]);
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

	  public function addVlanSelfipF5()
    {
        $inventario = 22;
        $groups = $this->getGroups($inventario,$this->method);
        return view('balancers/addVlanSelfipF5',compact('groups','inventario'));
    }


    public function addVlanSelfipF5Store(Request $request)
    {
        $this->validate($request, [

            'host' => 'required',
            'address' => 'required',
            'mask' => 'required',
            'name_vlan' => 'required',
            'tag' => 'required',
            'interface' => 'required'

        ]);
        $idTemplate = 432;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "name_vlan" => $request->name_vlan, "tag" => $request->tag, "interface" => $request->interface, "address" => $request->address, "mask" => $request->mask));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
            //'result' => "http://172.22.16.179:443/$id_asgard/Estado_Balanceadores_F5.html",
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }

    public function stateTennis()
    {
        $inventario = 52;
        $groups = $this->getGroups($inventario,$this->method);
        return view('balancers.stateTennis',compact('groups','inventario'));
    }
    public function stateTennisStore(Request $request)
    {
        $this->validate($request, [
            'server' => 'required',
            'state' => 'required',
        ]);
        $idTemplate = 437;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("servidor" =>$request->input('server') , "state" => $request->state ));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
        ]);
        //dd($resultado);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
	
	public function servFiduoccNS()
    {
        $inventario = 52;
        $groups = $this->getGroups($inventario,$this->method);
        return view('balancers.servFiduoccNS',compact('groups','inventario'));
    }
	
	public function servFiduoccNsStore(Request $request)
    { 
        $this->validate($request, [
            'server' => 'required',
            'state' => 'required',
        ]);
        $idTemplate = 467;
        $log = $this->getLog(1,13,$idTemplate);
        $id_asgard = $log->id;       
        $variables = array("extra_vars" => array("servidor" =>$request->input('server') , "state" => $request->state ));     
        $resultado = $this->runPlaybook($idTemplate,$variables);       
        $resultado = $resultado['job'];     
        $log->update([
            'id_job' => $resultado,
        ]);      
        return redirect()->route('executionLogs.show',$id_asgard);
    }

    public function servFiduBogota()
    {
        $inventario = 52;
        $groups = $this->getGroups($inventario,$this->method);
        return view('balancers.servFiduBogota',compact('groups','inventario'));
    }
	
	public function servFiduBogotaStore(Request $request)
    { 
        $this->validate($request, [
            'server' => 'required',
            'state' => 'required',
            'email' => 'required',
        ]);
        $idTemplate = 513;
        $log = $this->getLog(1,13,$idTemplate);
        $id_asgard = $log->id;       
        $variables = array("extra_vars" => array("servidor" =>$request->input('server') , "state" => $request->state , "correo" => $request->email));     
        $resultado = $this->runPlaybook($idTemplate,$variables);       
        $resultado = $resultado['job'];     
        $log->update([
            'id_job' => $resultado,
        ]);      
        return redirect()->route('executionLogs.show',$id_asgard);
    }

    public function servServPostalesNac()
    {
        $inventario = 52;
        $groups = $this->getGroups($inventario,$this->method);
        return view('balancers.servServPostalesNac',compact('groups','inventario'));
    }
	
	public function servServPostalesNacStore(Request $request)
    { 
        $this->validate($request, [
            'server' => 'required',
            'state' => 'required',
            'email' => 'required',
        ]);
        $idTemplate = 513;
        $log = $this->getLog(1,13,$idTemplate);
        $id_asgard = $log->id;       
        $variables = array("extra_vars" => array("servidor" =>$request->input('server') , "state" => $request->state , "correo" => $request->email));     
        $resultado = $this->runPlaybook($idTemplate,$variables);       
        $resultado = $resultado['job'];     
        $log->update([
            'id_job' => $resultado,
        ]);      
        return redirect()->route('executionLogs.show',$id_asgard);
    }

    public function SerCristalNs()
    {
        $inventario = 52;
        $groups = $this->getGroups($inventario,$this->method);
        return view('balancers.SerCristalNs',compact('groups','inventario'));
    }

	public function SerCristalNsStore(Request $request)
    { //dd($request->all());
        $this->validate($request, [
            'server' => 'required',
            'state' => 'required',
            'email' => 'required',
        ]);
        $idTemplate = 513;
        $log = $this->getLog(1,13,$idTemplate);
        $id_asgard = $log->id;
        $variables = array("extra_vars" => array("servidor" =>$request->input('server') , "state" => $request->state , "correo" => $request->email));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }

    public function ServEditorialTiempo()
    {
        $inventario = 52;
        $groups = $this->getGroups($inventario,$this->method);
        return view('balancers.ServEditorialTiempo',compact('groups','inventario'));
    }


	public function ServEditorialTiempoStore(Request $request)
    { //dd($request->all());
        $this->validate($request, [
            'server' => 'required',
            'state' => 'required',
            'email' => 'required',
        ]);
        $idTemplate = 467;
        $log = $this->getLog(1,13,$idTemplate);
        $id_asgard = $log->id;
        $variables = array("extra_vars" => array("servidor" =>$request->input('server') , "state" => $request->state , "correo" => $request->email));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
        
    }

    public function ServConsorcio()
    {
        $inventario = 52;
        $groups = $this->getGroups($inventario,$this->method);
        return view('balancers.ServConsorcio',compact('groups','inventario'));
    }

	public function ServConsorcioStore(Request $request)
    { //dd($request->all());
        $this->validate($request, [
            'server' => 'required',
            'state' => 'required',
            'email' => 'required',
        ]);
        $idTemplate = 521;
        $log = $this->getLog(1,13,$idTemplate);
        $id_asgard = $log->id;
        $variables = array("extra_vars" => array("servidor" =>$request->input('server') , "state" => $request->state , "correo" => $request->email));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }

    public function testbranch(){
        return view('balancers.testbranch');
    }


}
