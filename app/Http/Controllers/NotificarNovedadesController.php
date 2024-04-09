<?php

namespace App\Http\Controllers;
use App\Models\NovedadesMaquinaBu;
use App\Models\ReportesMaquinasBu;
use Illuminate\Http\Request;
use  DB;
use PhpParser\Node\Expr\AssignOp\Concat;

class NotificarNovedadesController extends Controller
{
    public function indexNovedadesCliente(){
        $sql  = 'select id,nombre,estado from asgard.clientes_novedades_bus;';
        $clientes = DB::select($sql);
        return  view('novedadesBackup.gestionNovedades.notificarNovedad',compact('clientes'));
    }

    public function busquedaNovedadesPorCliente(Request $request){
        $this->validate($request,[
            'cliente'=>'required'
        ]);
        //Obtener clientes novedades
        $sql  = 'select id,nombre,estado from asgard.clientes_novedades_bus;';
        $clientes = DB::select($sql);
        $clienteSeleccionado = $request->except('_token');
        //Servicio que trae la traduccion del cliente segun  cliente seleccionado
        $client = new \GuzzleHttp\Client();
        $endpointIdClient ="https://prod-150.westus.logic.azure.com/workflows/946c2533cb3c4f64a5666b65e7839229/triggers/manual/paths/invoke/idCliente?api-version=2016-06-01&sp=%2Ftriggers%2Fmanual%2Frun&sv=1.0&sig=dnoD2xBt6977NYyfhYI-dmAy5qWSe5j5s3Rv07QtyDQ";

        $bodyCliente= array([
            "nombreCliente" => $clienteSeleccionado['cliente']
        ]);
        $res = $client->request('POST',$endpointIdClient,[
            'headers'=>[
                'Content-Type' =>'application/json'
            ],
            'json' =>$bodyCliente[0]
        ]);
        $result = json_decode($res->getBody()->getContents(),true);


        //Servicio que trae la maquinas segun  la traduccion del cliente.
        // $client = new \GuzzleHttp\Client();
        // $serverIpPro = env('PROD_SERVER_2');
        //endpoint Produccion
        //$endpointClientes = "http://$serverIpPro/asgard/api/v1/Clients?client=";
        //enpoint desarrollo

        //$endpointClientes = "http://localhost:8000/api/v1/Clients?client=";
        //$res = $client->request('GET',$endpointClientes.$result['TraduccionCliente']);
        //$res = $client->request('GET',$endpointClientes.'FIDUBOGOTA');
        //$maquinas = json_decode($res->getBody()->getContents(),true);
        $maquinas = ReportesMaquinasBu::clients($result['TraduccionCliente']);
        //Servicio que trae las novedades por maquina.
        // $client = new \GuzzleHttp\Client();
        //endpoint Produccion
        //$endpointReporte = "http://$serverIpPro/asgard/api/v1/ReportClient?nameClient=";
        //endpoint desarrollo
        //$endpointReporte = "http://localhost:8000/api/v1/ReportClient?nameClient=";
        $reportes=[];
        $novedadesMaquina = [];
        try {
            if($maquinas[0]->Client){
                foreach($maquinas as $maquina){
                   // $res = $client->request('GET',$endpointReporte.$maquina['Client']);
                    //$novedad = json_decode($res->getBody()->getContents(),true);
                    $novedadMaquina =ReportesMaquinasBu::reportsClient($maquina->Client);
                    array_push($reportes,$novedadMaquina);
                }
                $novedad="";
                foreach($reportes as $reporte){
                    $novedad .= "- MAQUINA: ".$reporte[0]->Client.
                                " - INCIDENTE: ".$reporte[0]->ID_Incidente.
                                " - ESTADO: ".$reporte[0]->Estado.
                                " - FECHA Y HORA DE APERTURA: ".$reporte[0]->Fecha_hora_de_apertura."\n";
                }
                $novedadesMaquina= array([
                    'tipo'=>'Novedades',
                    'cliente'=>$result['TraduccionCliente'],
                    'novedad'=>$novedad,
                    'estado'=>'cliente_con_novedad',
                    'idCliente'=>$result['idCliente']
                ]);

                return view('novedadesBackup.gestionNovedades.notificarNovedad',compact("clientes",'clienteSeleccionado','novedadesMaquina'));
                //return response()->json($novedad);
            }
        } catch (\Throwable $th) {
             try {
                if($maquinas[0]['Data']){

                    $novedadesMaquina= array([
                        'tipo'=>'Novedades',
                        'cliente'=>$result['TraduccionCliente'],
                        'novedad'=>'',
                        'estado'=>'novedad_documentada',
                        'idCliente'=>$result['idCliente']
                    ]);

                    $sinNovedad = array([
                        'message'=> 'No se encontraron novedades para  la ventana del cliente'
                    ]);

                    return view('novedadesBackup.gestionNovedades.notificarNovedad',compact('sinNovedad','clientes','clienteSeleccionado','novedadesMaquina'));
                }
             } catch (\Throwable $e) {
                $error = array([
                    "error"=>"Internal Server Error".$th
                ]);
                //return response()->json(["error"=>"Internal Service Error : ".$error]);
                return view('novedadesBackup.gestionNovedades.notificarNovedad',compact("error","clientes"));
             }
        }
        return view('novedadesBackup.gestionNovedades.notificarNovedad',compact('clientes'));
    }

    public function notificarNovedades(Request $request){
        $campos = $request->all();
        $idCliente = $campos['idCliente'];
        $novedadesCliente = $request->except('_token','idCliente');
        $client = new \GuzzleHttp\Client();
        $endpointEnviarCorreo ="https://prod-182.westus.logic.azure.com/workflows/d9ab1bfdd1f74f658bfebc2b76499f73/triggers/manual/paths/invoke/correoBackup?api-version=2016-06-01&sp=%2Ftriggers%2Fmanual%2Frun&sv=1.0&sig=hyzrLnCLogoco6TV0iIpIBgSo0w7SSQq_aFOVQk8tYQ";

        $resultadoNotificacion = "";
        //guardar novedades del cliente por maquina.
        try {
                $bodyCliente= array([
                    "tipo" => $campos['tipo'],
                    "id_Cliente"=>$campos['idCliente'],
                    "Novedad"=>$campos['novedad']
                ]);
                $res = $client->request('POST',$endpointEnviarCorreo,[
                    'headers'=>[
                        'Content-Type' =>'application/json'
                    ],
                    'json' =>$bodyCliente[0]
                ]);
                $result = json_decode($res->getBody()->getContents(),true);
                if($result['estado']){
                    NovedadesMaquinaBu::create($novedadesCliente);
                    $resultadoNotificacion="Se realizo la notificación de las novedades al cliente ".$novedadesCliente['cliente'];
                    return redirect()->route('novedadesBackup.indexNovedadesCliente')->with('resultadoNotificacion',$resultadoNotificacion);
                }
        } catch (\Throwable $th) {
            $resultadoNotificacion='Internal Service Error';
            return redirect()->route('novedadesBackup.indexNovedadesCliente')->with('error',$resultadoNotificacion);
        }

    }
    public function notificarNovedadesAjax(Request $request){
        $campos = $request->all();
        $novedadesCliente = $request->except('_token','idCliente');

        $client = new \GuzzleHttp\Client();
        $endpointEnviarCorreo ="https://prod-182.westus.logic.azure.com/workflows/d9ab1bfdd1f74f658bfebc2b76499f73/triggers/manual/paths/invoke/correoBackup?api-version=2016-06-01&sp=%2Ftriggers%2Fmanual%2Frun&sv=1.0&sig=hyzrLnCLogoco6TV0iIpIBgSo0w7SSQq_aFOVQk8tYQ";
        $resultadoNotificacion = "";
        //guardar novedades del cliente por maquina.
        try {
                $bodyCliente= array([
                    "tipo" => $campos['tipo'],
                    "id_Cliente"=>$campos['idCliente'],
                    "Novedad"=>$campos['novedad']
                ]);
                $res = $client->request('POST',$endpointEnviarCorreo,[
                    'headers'=>[
                        'Content-Type' =>'application/json'
                    ],
                    'json' =>$bodyCliente[0]
                ]);

                $result = json_decode($res->getBody()->getContents(),true);
                if($result['estado']){
                    NovedadesMaquinaBu::create($novedadesCliente);
                    $resultadoNotificacion= array([
                        "success"=>"Se realizo la notificación de las novedades al cliente ".$novedadesCliente['cliente']
                    ]);
                    return response()->json($resultadoNotificacion);
                }
        } catch (\Throwable $th) {
            $resultadoNotificacion=array(["error"=>'Internal Service Error']);
            return response()->josn($resultadoNotificacion);
        }
    }
}
