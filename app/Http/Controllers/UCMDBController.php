<?php

namespace App\Http\Controllers;

use Illuminate\Database\PDO\Concerns\ConnectsToDatabase;
use Illuminate\Http\Request;
 class UCMDBController extends Controller
 {
    Use ConnectsToDatabase;

    public function authenticate()
    {
        $client = new \GuzzleHttp\Client();
        $serverUrl= env('UCMDB_SERVER');
        $bodyJson= array(
            [
                "username"=>"ConsultAPi",
                "password"=>"Colombia123*",
                "clientContext"=>1
            ]
        );
        $res =$client->request('POST',"https://$serverUrl/rest-api/authenticate",[
            'headers' => [
                'Content-Type'=>'application/json'
            ],
            'json' => $bodyJson[0],
            'verify' => false
        ]);
       $resultado = json_decode($res->getBody()->getContents(),true);
       return $resultado;
    }

    public function  methodTopology(){

        $client = new \GuzzleHttp\Client();
        $serverUrl= env('UCMDB_SERVER');
        $resultadoAut=$this->authenticate();
        $authKey=$resultadoAut["token"];
        $res =$client->request('POST',"https://$serverUrl/rest-api/topology",[
            'headers'=>[
                'Authorization'=>"Bearer $authKey"
            ],
            'body'=>'APIrest',
            'verify' =>false
        ]);
        $resultado = json_decode($res->getBody()->getContents(),true);

        return $resultado;
    }

    public function topology(){
        $resultado = $this -> methodTopology();
        return view('ucmdb.topology',["data"=>$resultado]);
    }
 }
