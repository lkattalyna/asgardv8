<?php

namespace App\Http\Controllers;

use App\SanLun;
use App\SanSwitch;
use App\SanStorage;
use App\VmDatastorage;
use Illuminate\Http\Request;
use App\Http\Traits\ConnectionTrait;

class SanController extends Controller
{
    Use ConnectionTrait;

    public function portState()
    {
        $sws = SanSwitch::orderBy('sw')->get(['ip','sw']);
        return view('san.queries.portState', compact('sws'));

    }
    public function portStateStore(Request $request)
    {
        $this->validate($request, [
            'sw' => 'required|ipv4',
        ]);
        if($request->input('port') != '00'){
            $this->validate($request, [
                'port' => 'required|integer',
            ]);
        }
        if($request->input('getSlot') == 1){
            $slot = $request->input('slot');
            $this->validate($request, [
                'slot' => 'required|integer',
            ]);
        }
        //dd($request);
        //$ip = '172.22.8.77';
        //$port = '0';
        $ip = $request->input('sw');
        $port = $request->input('port');
        $log = $this->getExternalToolLog('SanPortState');
        $string = "";
        if($request->input('getSlot') == 1){
            $results = shell_exec("powershell.exe -executionpolicy bypass -NoProfile ". app_path() . "\scripts\SAN\R001-ExecutionScripts.ps1 -op 1 -params '-opcion 1 -parametros *$port@$ip@$slot*'" . escapeshellarg($string));
        }else{
            $results = shell_exec("powershell.exe -executionpolicy bypass -NoProfile ". app_path() . "\scripts\SAN\R001-ExecutionScripts.ps1 -op 1 -params '-opcion 1 -parametros *$port@$ip*'" . escapeshellarg($string));
        }
        $results = json_decode($results,true);
        //dd($results);
        if(isset($results['Error'])){
            return redirect()->route('san.portState')->with('error', $results['Error']);
            $log->update([
                'd_end_script' => date("Y-m-d H:i:s"),
                'status' => 12,
                'result' => 'Fallo en la ejecución del job',
            ]);
        }else{
            $log->update([
                'd_end_script' => date("Y-m-d H:i:s"),
                'status' => 2,
                'result' => 'Ejecución realizada exitosamente',
            ]);
            //dd(sizeof($results));
            //return $results;
            return view('san.queries.portStateRs',compact('results'));
            //return $results;
        }
    }
    public function WWNSearch()
    {
        return view('san.queries.WWNSearch');

    }
    public function WWNSearchStore(Request $request)
    {
        //dd($request);
        /////Fabric 1
		$ip1 = "172.22.73.77";
		/////Fabric 2
		$ip2 = "172.22.73.74";
        $this->validate($request, [
            'wwn' => 'required',
        ]);
        $wwn = $request->input('wwn');

        //dd($request);
        //$ip = '172.22.8.77';
        //$port = '0';
        $ip = $request->input('sw');
        $port = $request->input('port');
        $log = $this->getExternalToolLog('SanWWNSearch');
        $string = "";
        $result = shell_exec("powershell.exe -executionpolicy bypass -NoProfile ". app_path() . "\scripts\SAN\R001-ExecutionScripts.ps1 -op 1 -params '-opcion 2 -parametros *$wwn@$ip1*'" . escapeshellarg($string));
        if(trim($result) == "False"){
            $result = shell_exec("powershell.exe -executionpolicy bypass -NoProfile ". app_path() . "\scripts\SAN\R001-ExecutionScripts.ps1 -op 1 -params '-opcion 2 -parametros *$wwn@$ip2*'" . escapeshellarg($string));
            if(trim($result) == "False"){
                return redirect()->route('san.WWNSearch')->with('error', "La WWN enviada no se encuentra registrada");
                $log->update([
                    'd_end_script' => date("Y-m-d H:i:s"),
                    'status' => 12,
                    'result' => 'Fallo en la ejecución del job',
                ]);
            }
        }
        $result = json_decode($result,true);
        $sws = SanSwitch::where('domain', $result['Decimal'])->first(['ip','sw', 'fabric']);
        $result['Ip'] = $sws->ip;
        $result['Sw'] = $sws->sw;
        $result['Fabric'] = $sws->fabric;
        $log->update([
            'd_end_script' => date("Y-m-d H:i:s"),
            'status' => 2,
            'result' => 'Ejecución realizada exitosamente',
        ]);
        return view('san.queries.WWNSearchRs',compact('result'));
    }
    public function ZoneSearch()
    {
        return view('san.queries.ZoneSearch');

    }
    public function ZoneSearchStore(Request $request)
    {
        //dd($request);
        /////Fabric 1
		$ip1 = "172.22.73.75";
		/////Fabric 2
		$ip2 = "172.22.73.74";
        $this->validate($request, [
            'wwn1' => 'required',
            'wwn2' => 'required',
        ]);
        $wwn1 = strtolower($request->input('wwn1'));
        $wwn2 = strtolower($request->input('wwn2'));
        $log = $this->getExternalToolLog('SanZoneSearch');
        $string = "";
        $results = shell_exec("powershell.exe -executionpolicy bypass -NoProfile ". app_path() . "\scripts\SAN\R001-ExecutionScripts.ps1 -op 1 -params '-opcion 3 -parametros *$wwn1@$ip1@$wwn2@$ip2*'" . escapeshellarg($string));
        //dd(trim($results));
        $results = json_decode($results,true);
        //dd($results);
        if(isset($results['Error'])){
            $log->update([
                'd_end_script' => date("Y-m-d H:i:s"),
                'status' => 12,
                'result' => 'Fallo en la ejecución del job',
            ]);
            return redirect()->route('san.ZoneSearch')->with('error', $results['Error']);
        }else{
            $zonas = array();
            foreach ($results as $result) {
                $zona = array();
                foreach ($result['value'] as $rs) {
                    $name = $rs['Alias'];
                    $sw = SanSwitch::where('domain', $rs['Decimal'])->first(['sw']);
                    $rs["switch"] = $sw->sw;
                    array_push($zona, $rs);
                    //dd($rs);
                }
                array_push($zonas,array('name' => $name, "zonas" => $zona));
            }
        }
        $log->update([
            'd_end_script' => date("Y-m-d H:i:s"),
            'status' => 2,
            'result' => 'Ejecución realizada exitosamente',
        ]);
        return view('san.queries.ZoneSearchRs',compact('zonas','wwn1','wwn2'));

    }
    public function wwnNaa(Request $request)
    {
        $datastorages = VmDatastorage::orderBy('name')->where('naa', '!=', '')->get(['name','naa']);
        return view('san.queries.wwnNaa',compact('datastorages'));
    }
    public function wwnNaaStore(Request $request)
    {
        $this->validate($request, [
            'wwn' => 'required',
        ]);
        $wwn = strtolower($request->input('wwn'));
        $storages = SanStorage::where('trademark', 'HITACHI')->get(['serial','model','name']);
        $vendor = "";
        $result = array();
        $log = $this->getExternalToolLog('SanWWN-NAASearch');
        foreach($storages as $storage){
            if ($storage->model == 'HUS VM' || $storage->model == 'G200' || $storage->model == 'G400' || $storage->model == 'G600' || $storage->model == 'G800') {
                $ser = substr($storage->serial, 1);
            }else{
                $ser = $storage->serial;
            }
            $shex = dechex($ser);
            $flag = strpos($wwn, $shex); //encontrar serial de almacenamiento
            if ($flag !== false) {
                $vendor = "HITACHI";
                $result['vendor'] = "HITACHI";
                $result['name'] = $storage->name; //nombre del almacenamiento
                $result['serial'] = $storage->serial;
                $result['lunhex'] = substr($wwn, -4); //lun en decimal
                $result['lundec'] = hexdec($result['lunhex']); //lun en hexadecimal
                $result['pool'] = 'N/A';
                $result['capacity'] = 'N/A';
                $result['lunName'] = 'N/A';
            }
        }
        if($vendor == ""){
            $storage = SanLun::where('device_id', $wwn)->first();
            if($storage != NULL){
                $type = explode(' ',$storage->type);
                $vendor = "DELL";
                $result['vendor'] = "DELL";
                $result['name'] = $storage->service_code; //nombre del almacenamiento
                $result['serial'] = $type[0];
                $result['lunhex'] = $wwn; //lun en decimal
                $result['lundec'] = 'N/A'; //lun en hexadecimal
                $result['pool'] = $type[2];
                $result['capacity'] = $storage->size;
                $result['lunName'] = $storage->name;
            }
        }
        if($vendor == ""){
            $log->update([
                'd_end_script' => date("Y-m-d H:i:s"),
                'status' => 12,
                'result' => 'Fallo en la ejecución del job',
            ]);
            return redirect()->route('san.wwnNaa')->with('error', "La WWN/NAA buscada no se encuentra registrada");
        }else{
            $log->update([
                'd_end_script' => date("Y-m-d H:i:s"),
                'status' => 2,
                'result' => 'Ejecución realizada exitosamente',
            ]);
            return view('san.queries.wwnNaaRs',compact('result'));
        }
    }
    public function fabricCommand(Request $request)
    {
        if($request->ajax()){
            if ($request->has("fabric")){
                $sws = SanSwitch::distinct()->where('fabric', $request->fabric)->orderBy('sw')->get(['sw']);
                return $sws;
            }
        }else{
            $fabrics = SanSwitch::distinct()->orderBy('fabric')->get(['fabric']);
            return view('san.admin.fabricCommand',compact('fabrics'));
        }


    }
    public function fabricCommandStore(Request $request)
    {
        $this->validate($request, [
            'fabric' => 'required|string',
            'command' => 'required|integer|min:1|max:10',
            'switch' => 'required',
        ]);
        switch ($request->input('command')) {
            case '1': // ESTADISTICAS DE ERRORES
                $command = "porterrshow";
                break;
            case '2': // LIMPIAR ESTADISTICAS
                $command1 = "slotstatsclear";
                $command2 = "statsclear";
                break;
            case '3': // LINK Y MAC ADDRESS
                $command = "ifmodeshow eth0";
                break;
            case '4': // SUPPORT SHOW
                $command = "supportshow";
                break;
            case '5': // UPTIME SWITCH
                $command = "switchuptime";
                break;
            case '6': // VALIDACIÓN NTP
                $command = "tsclockserver";
                break;
            case '7': // VALIDACIÓN CONFIGURACIÓN IP
                $command = "ipaddrshow";
                break;
            case '8': // VALIDACIÓN DE USUARIOS
                $command = "userconfig --show -a pipeline grep -e name -e Enabled";
                break;
            case '9': // VALIDACION NOMBRE DE PUERTOS
                $command = "switchshow -portname";
                break;
            case '10': // Creacion de usuario
                //$command = "userconfig --add asgard -r admin -p 4sG4rd2021.";
                $command = "userconfig --add asgard -r admin -l 1-128 -h 128 -c admin -p 4sG4rd2021.";
                break;
        }
        ini_set('max_execution_time', 300);
        //$log = $this->getExternalToolLog('SanWWNSearch');
        $string = "";
        $con = false;
        $fabric = $request->input('fabric');
        //dd("powershell.exe -executionpolicy bypass -NoProfile ". app_path() . "\scripts\SAN\R001-ExecutionScripts.ps1 -op 1 -params '-opcion 5 -parametros *$fabric@$command@admin*'");
        if($request->input('switch') == "0"){
            $fabric = $request->input('fabric');
            $results = shell_exec("powershell.exe -executionpolicy bypass -NoProfile ". app_path() . "\scripts\SAN\R001-ExecutionScripts.ps1 -op 1 -params '-opcion 5 -parametros *$fabric@$command@admin*'" . escapeshellarg($string));
        }else{
            $switch = $request->input('switch');
            $results = shell_exec("powershell.exe -executionpolicy bypass -NoProfile ". app_path() . "\scripts\SAN\R001-ExecutionScripts.ps1 -op 1 -params '-opcion 5 -parametros *$switch@$command@admin*'" . escapeshellarg($string));
        }
        //dd($results);
        $results = json_decode($results,true);
        //dd(count($results));
        if(is_null($results) || $results == "" || count($results) == 0){
            /*$log->update([
                'd_end_script' => date("Y-m-d H:i:s"),
                'status' => 12,
                'result' => 'Fallo en la ejecución del job',
            ]);*/
            return redirect()->route('san.fabricCommand')->with('error','Hubo un error al ejecutar el script contacte al administrador');
        }else{
            /*$log->update([
                'd_end_script' => date("Y-m-d H:i:s"),
                'status' => 2,
                'result' => 'Ejecución realizada exitosamente',
            ]);*/
            return view('san.admin.fabricCommandRs',compact('results','command'));
        }

    }
    public function sanExtend()
    {
        sleep(20);
        return view('san.admin.sanExtend');
    }
}
