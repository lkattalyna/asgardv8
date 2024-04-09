<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\InterfazRed;
use Illuminate\Http\Request;
use App\Http\Resources\V1\VirtualResource;
use App\Http\Resources\V1\CustomException;
use DB;

class ConsultarSDController extends Controller
{
    public function store(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        $id = $request->id;
        $resultado  = null;
        //dd($sd);
        if (!empty($id)){
            $res = $client->request(
                'GET',
                "http://172.22.108.160:14081/SM/9/rest/contacts?query=ContactName=\"$id\"&view=expand" ,
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
