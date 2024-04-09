<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class IncidentesController extends Controller {


    public function declararIncidente()
    {
        $sql  = 'select EMPRESA from asgard.clientes_datacenter;';
        $clientes_datacenter = DB::select($sql);
        //dd($clientes_datacenter);
        return view('incidentes.declarar',compact('clientes_datacenter'));
    }

    public function declararIncidenteEndpoint(Request $request)
    {
        $campos = $request->all();
        $vector_esc = array();
        foreach ($campos as $key => $value){
            if($value == "on"){
                array_push($vector_esc, $key);
            }
        }
        $crear_im = FALSE;
        $crear_sala= FALSE;
        if($campos['no_caso'] ?? null == 'no'){
            $crear_im = TRUE;
        }
        if($campos['no_url'] ?? null == 'no'){
            $crear_sala= TRUE;
        }
        $post_data = array(
            "Nombre" => $campos['Nombre'],
            "Documento" => $campos['Documento'],
            "Correo" => $campos['Correo'],
            "sintomas" => $campos['sintomas'],
            "description" => $campos['description'],
            "detectado" => $campos['detectado'],
            "crear_im" => $crear_im,
            "id_caso" => $campos['id_caso'],
            "nombre_cliente" => $campos['nombre_cliente'],
            "cod_serv" => $campos['cod_serv'],
            "crear_sala" => $crear_sala,
            "url_teams" => $campos['url_teams'],
            "vector_esc" => $vector_esc);

            $client = new \GuzzleHttp\Client();
            $resultado  = null;
            $res = $client->request(
                'POST',
                "https://prod-89.westus.logic.azure.com:443/workflows/9166ca29c127481ba6cd63430ec308f7/triggers/manual/paths/invoke?api-version=2016-06-01&sp=%2Ftriggers%2Fmanual%2Frun&sv=1.0&sig=x6Osx_kLDOXzIC6xf6icXbwP4UDZx228NKtuwJazHmI",
                [
                    'header'=>[
                        'Content-Type'=>'application/json'
                    ],
                    'json' => $post_data,
                    'verify'=> false
                ]
            );
            $statusCode = $res->getStatusCode();
            if ($statusCode<>200){
                throw new CustomException($statusCode,'Error en la peticion');
            }
            else {
                $resultado = json_decode($res->getBody()->getContents(),true);
                return redirect()->route('incidentes.declararINFO');
            }
    }

    public  function declararIncidenteIFO(){
        return view('incidentes.declararINFO');
    }

}
