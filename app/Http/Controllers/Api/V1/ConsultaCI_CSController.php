<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\V1\CustomException;

class ConsultaCI_CSController extends Controller
{
    public function store(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        $ServiceCode = $request->ServiceCode;
        $resultado  = null;
        if (!empty($ServiceCode)){
            $res = $client->request(
                'GET',
                "http://172.22.108.160:14081/SM/9/rest/devices?NewUcmdb=true&query=ServiceCode=\"$ServiceCode\"%26NewUcmdb=true",
                [
                    'auth' => ['AUTOSM', '5M4ut*m4t2o2*.,'],
                    'header'=>[
                        'Content-Type'=>'application/json'
                    ],
                    'verify'=> false
                ]
            );
            //dd($res->getStatusCode());
            $statusCode = $res->getStatusCode();
            if ($statusCode<>200){
                //throw new CustomException($statusCode,'Error en la peticion');
                $resultado = json_decode($res->getBody()->getContents(),true);
            }
            else {
                $resultado = json_decode($res->getBody()->getContents(),true);
            }
        } else{
            throw new CustomException(500,'El cuerpo de la petición es invalido.');
        }
        return response()->json($resultado);
    }
}
