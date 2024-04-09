<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\V1\CustomException;

class AsociarRFaSDController extends Controller
{
    public function store(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        $resultado  = null;
        $cuerpo = $request->all();
        if (!empty($cuerpo)) {
            $res = $client->request(
                'POST',
                //http://smapp.triara.co:14081/SM/9/rest/screlation
                "http://172.22.108.160:14081/SM/9/rest/screlation",
                [
                    'auth' => ['AUTOSM', '5M4ut*m4t2o2*.,'],
                    'header' => [
                        'Content-Type' => 'application/json'
                    ],
                    'verify' => false,
                    'json' => $cuerpo
                ]
            );
            //dd($res->getStatusCode());
            $statusCode = $res->getStatusCode();
            if ($statusCode <> 200) {
                //throw new CustomException($statusCode,'Error en la peticion');
                $resultado = json_decode($res->getBody()->getContents(), true);
            } else {
                $resultado = json_decode($res->getBody()->getContents(), true);
            }
        } else {
            throw new CustomException(500, 'El cuerpo de la petición es invalido.');
        }
        return response()->json($resultado);
    }
}
