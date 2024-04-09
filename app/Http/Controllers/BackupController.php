<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\ConnectionTrait;
use Illuminate\Support\Facades\Storage;


class BackupController extends Controller
{
    Use ConnectionTrait;
    private $method = "local";

    public function checkPWindows()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);
        return view('backup.checkWin',compact('groups','inventario'));
    }
    public function runCheckWindows(Request $request)
    {

        $this->validate($request, [
            'host' => 'required',
        ]);
        $variables = array("extra_vars" => array("HOST" => ($request->host)));

        $idTemplate = 87;
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

        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function checkPUnix()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);
        return view('backup.checkUnix',compact('groups','inventario'));
    }
    public function runCheckUnix(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
        ]);
        $variables = array("extra_vars" => array("HOST" => ($request->host)));
        $idTemplate = 86;

        $log = $this->getLog(3,13,$idTemplate);

        $id_asgard = $log->id;
        //$id_asgard = 1;
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function vadp()
    {
        return view('backup.vadp');
    }
    public function vadpStore(Request $request)
    {
        $idTemplate = 98;

        $log = $this->getLog(3,13,$idTemplate);

        $id_asgard = $log->id;
        //$id_asgard = 1;
        $resultado = $this->runPlaybook($idTemplate);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function pingCS02()
    {
        return view('backup.pingCS02');
    }
    public function pingCS02Store(Request $request)
    {
        $this->validate($request, [
            'cliente' => 'required|ipv4',
        ]);
        $idTemplate = 371;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("CLNT" => $request->input('cliente')));
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
    public function backupTask()
    {
        return view('backup.backupTask');
    }
    public function backupTaskStore(Request $request)
    {
        // Proceso de almacenado de datos en el disco
        $this->validate($request, [
            'report' => 'required|file|max:7000',
            'master' => 'required|file|max:7000',
            'exception' => 'required|file|max:7000',
            'SMIREIASS' => 'required|file|max:7000',
            'SMBACKUP' => 'required|file|max:7000',


        ]);
        $file = $request->file("report");
        $nombre = 'report.xlsx';
        $tam=$file->getSize();
        //indicamos que queremos guardar un nuevo archivo en el disco local
        $ext = $file->getClientOriginalExtension();
        if($this->checkExtension($ext) && $tam < 6000000){
            $file->storeAs('BKP_DATA',$nombre);
        }else{
            return redirect()->back()
                ->with('error','Tamaño o extensión de archivo reporte invalida');
        }
        $file = $request->file("master");
        $nombre = 'master.xlsx';
        $tam=$file->getSize();
        //indicamos que queremos guardar un nuevo archivo en el disco local
        $ext = $file->getClientOriginalExtension();
        if($this->checkExtension($ext) && $tam < 6000000){
            $file->storeAs('BKP_DATA',$nombre);
        }else{
            return redirect()->back()
                ->with('error','Tamaño o extensión de archivo maestro de fallas invalida');
        }
        $file = $request->file("exception");
        $nombre = 'exception.xlsx';
        $tam=$file->getSize();
        // indicamos que queremos guardar un nuevo archivo en el disco local
        $ext = $file->getClientOriginalExtension();
        if($this->checkExtension($ext) && $tam < 6000000){
           $file->storeAs('BKP_DATA',$nombre);

        }else{
           return redirect()->back()
               ->with('error','Tamaño o extensión de archivo excepciones invalida');

         }
        $file = $request->file("SMIREIASS");
        $nombre = 'SMIREIASS.xlsx';
        $tam=$file->getSize();
        //indicamos que queremos guardar un nuevo archivo en el disco local
        $ext = $file->getClientOriginalExtension();
        if($this->checkExtension($ext) && $tam < 6000000){
            $file->storeAs('BKP_DATA',$nombre);

        }else{
            return redirect()->back()
                ->with('error','Tamaño o extensión de archivo excepciones invalida');

            }
            $file = $request->file("SMBACKUP");
            $nombre = 'SMBACKUP.xlsx';
            $tam=$file->getSize();
            //indicamos que queremos guardar un nuevo archivo en el disco local
            $ext = $file->getClientOriginalExtension();
            if($this->checkExtension($ext) && $tam < 6000000){
                $file->storeAs('BKP_DATA',$nombre);

            }else{
                return redirect()->back()
                    ->with('error','Tamaño o extensión de archivo excepciones invalida');








        }
        $log = $this->getExternalToolLog('BackupRevisionVentana');
        $string = "";
        //$results = exec("powershell.exe -executionpolicy bypass -NoProfile ". app_path() . "\scripts\BACKUP\BackupTask.ps1" . escapeshellarg($string));
        Storage::delete('BKP_DATA\BKP_CONSOLIDADO.xlsx');
        $results = shell_exec(app_path() . "\scripts\BACKUP\Backup.bat");


        if(!Storage::exists('BKP_DATA\BKP_CONSOLIDADO.xlsx')){
            $log->update([
                'd_end_script' => date("Y-m-d H:i:s"),
                'status' => 12,
                'result' => "Fallo en la ejecución",
            ]);
            return redirect()->route('backup.backupTask')->with('error','Ha ocurrido un error al ejecutar el comando, por favor intente de nuevo o contacte al administrador');
        }else{
            $log->update([
                'd_end_script' => date("Y-m-d H:i:s"),
                'status' => 2,
                'result' => "Ejecución realizada exitosamente",
            ]);
            return view("backup.backupTaskRs");
        }
    }
    public function scheduleMovil()
    {
        return view('backup.scheduleMovil');
    }
    public function scheduleMovilStore(Request $request)
    {

        $this->validate($request, [
            'report' => 'required|file|max:7000',
            'schedule' => 'required|file|max:7000',
            'dateRep' => 'required|date'
        ]);
        $file = $request->file("report");
        $nombre = 'report.html';
        $tam=$file->getClientSize();
        //indicamos que queremos guardar un nuevo archivo en el disco local
        $ext = $file->getClientOriginalExtension();
        if($this->checkExtension($ext) && $tam < 6000000){
            $file->storeAs('BKP_DATA',$nombre);
        }else{
            return redirect()->back()
                ->with('error','Tamaño o extensión de archivo reporte invalida');
        }
        $file = $request->file("schedule");
        $nombre = 'schedule.html';
        $tam=$file->getClientSize();
        //indicamos que queremos guardar un nuevo archivo en el disco local
        $ext = $file->getClientOriginalExtension();
        if($this->checkExtension($ext) && $tam < 6000000){
            $file->storeAs('BKP_DATA',$nombre);
        }else{
            return redirect()->back()
                ->with('error','Tamaño o extensión de archivo maestro de fallas invalida');
        }
        $log = $this->getExternalToolLog('BackupScheduleMovil');
        $fecha = $request->input('dateRep');
        $fecha = '2020-11-24';
        $string = "";
        $results = shell_exec("powershell.exe -executionpolicy bypass -NoProfile ". app_path() . "\scripts\BACKUP\R001-Backup-HtmlToXlsx.ps1 -fecha '$fecha'" . escapeshellarg($string));
        //dd($results);
        if($results === null){
            $log->update([
                'd_end_script' => date("Y-m-d H:i:s"),
                'status' => 12,
                'result' => "Fallo en la ejecución",
            ]);
            return redirect()->route('backup.scheduleMovil')->with('error','Ha ocurrido un error al ejecutar el comando, por favor intente de nuevo o contacte al administrador');
        }else{
            $results = json_decode($results);
            if(isset($results->Error)){
                $log->update([
                    'd_end_script' => date("Y-m-d H:i:s"),
                    'status' => 12,
                    'result' => "Fallo en la ejecución",
                ]);
                return redirect()->route('backup.scheduleMovil')->with('error',$results->Error);
            }else{
                $log->update([
                    'd_end_script' => date("Y-m-d H:i:s"),
                    'status' => 2,
                    'result' => "Ejecución realizada exitosamente",
                ]);
                return view("backup.scheduleMovilRs");
            }
        }
    }
    private function checkExtension($extension)
    {
        //aqui podemos añadir las extensiones que deseemos permitir
        $extensiones = array("xls", "xlsx", "html", "txt");
        if (in_array(strtolower($extension), $extensiones)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function FailedMaster()
    {
        return view('backup.FailedMaster');
    }
    public function FailedMasterStore(Request $request)
    {

        $this->validate($request, [
            'report' => 'required|file|max:7000',
        ]);
        Storage::delete('BKP_DATA\maestroF.xlsx');
        Storage::delete('reportMF.txt');
        $file = $request->file("report");
        $nombre = 'reportMF.txt';
        $tam=$file->getClientSize();
        //indicamos que queremos guardar un nuevo archivo en el disco local
        $ext = $file->getClientOriginalExtension();
        if($this->checkExtension($ext) && $tam < 6000000){
            $file->storeAs('BKP_DATA',$nombre);
        }else{
            return redirect()->back()
                ->with('error','Tamaño o extensión de archivo reporte invalida');
        }
        if($request->file("master")){
            $file = $request->file("master");
            $nombre = 'masterF.xlsx';
            $tam=$file->getClientSize();
            //indicamos que queremos guardar un nuevo archivo en el disco local
            $ext = $file->getClientOriginalExtension();
            if($this->checkExtension($ext) && $tam < 6000000){
                $file->storeAs('BKP_DATA',$nombre);
            }else{
                return redirect()->back()
                    ->with('error','Tamaño o extensión de archivo maestro de fallas invalida');
            }
        }
        //$log = $this->getExternalToolLog('BackupMaestroFallas');
        Storage::delete('BKP_DATA\Maestro_de_fallas.xlsx');
        $results = shell_exec(app_path() . "\scripts\BACKUP\FailedMaster.bat");
        dd($results);
        /*if(!Storage::exists('BKP_DATA\Maestro_de_fallas.xlsx')){
            $log->update([
                'd_end_script' => date("Y-m-d H:i:s"),
                'status' => 12,
                'result' => "Fallo en la ejecución",
            ]);
            return redirect()->route('backup.failedMaster')->with('error','Ha ocurrido un error al ejecutar el comando, por favor intente de nuevo o contacte al administrador');
        }else{
            $log->update([
                'd_end_script' => date("Y-m-d H:i:s"),
                'status' => 2,
                'result' => "Ejecución realizada exitosamente",
            ]);
            return view("backup.failedMasterRs");
        }*/
    }
    public function jobs()
    {
        return view('backup.jobs');
    }
    public function jobStore(Request $request)
    {
        //dd($request);
        //$someVariable = $request->someVariable;

        $this->validate($request, [
            'buscar' => 'required',
        ]);

        $searchValue = $request->input('buscar');
        //dd($searchValue);
        switch ($searchValue) {
            case '1':
                $exec = shell_exec(app_path() . "\scripts\BACKUP\COMMVAULT\EnableDisableJobs.exe -c");
                $log = $this->getExternalToolLog('StateCommvaultJobs');
                $log->update([
                    'd_end_script' => date("Y-m-d H:i:s"),
                    'status' => 2,
                    'result' => "Ejecución realizada exitosamente",
                ]);
                return view('backup.jobsRs',compact('exec'));
                //return redirect()->route('backup.jobsRs')->with('success','Resultado exitoso');;
                break;
            case '2':
                # code...
                $exec = shell_exec(app_path() . "\scripts\BACKUP\COMMVAULT\EnableDisableJobs.exe -s");
                $log = $this->getExternalToolLog('EnableCommvaultJobs');
                $log->update([
                    'd_end_script' => date("Y-m-d H:i:s"),
                    'status' => 2,
                    'result' => "Ejecución realizada exitosamente",
                ]);
                return view('backup.jobsRs',compact('exec'));
                break;
            case '3':
                # code...
                $exec = shell_exec(app_path() . "\scripts\BACKUP\COMMVAULT\EnableDisableJobs.exe -st");
                $log = $this->getExternalToolLog('DisableCommvaultJobs');
                $log->update([
                    'd_end_script' => date("Y-m-d H:i:s"),
                    'status' => 2,
                    'result' => "Ejecución realizada exitosamente",
                ]);
                return view('backup.jobsRs',compact('exec'));
                break;
            case '4':
                # code...
                $this->validate($request, [
                    'buscar' => 'required',
                    'meses' => 'required',
                ]);
                $mes = $request->meses;
                //dd($mes);
                $client = new \GuzzleHttp\Client();
                $server = '172.27.219.12';
                $res = $client->request('GET', "http://$server/api/jobs?initialMonth=$mes");
                $prints = json_decode($res->getBody()->getContents(),true);
                $exec = shell_exec(app_path() . "\scripts\BACKUP\COMMVAULT\EnableDisableJobs.exe -e");
                $log = $this->getExternalToolLog('ExportCommvaultJobs');
                if(!Storage::exists('results\export.csv')){
                    $log->update([
                        'd_end_script' => date("Y-m-d H:i:s"),
                        'status' => 12,
                        'result' => "Fallo en la ejecución",
                    ]);
                    return redirect()->route('backup.jobRsFile')->with('error','Ha ocurrido un error al ejecutar el comando, por favor intente de nuevo o contacte al administrador');
                }else{
                    $log->update([
                        'd_end_script' => date("Y-m-d H:i:s"),
                        'status' => 2,
                        'result' => "Ejecución realizada exitosamente",
                    ]);
                    return view('backup.jobRsFile',compact('exec','prints'));
                }
                //return view('backup.jobRsFile',compact('exec'));
                break;
        }
        //dd($exec);
        //$exec = json_decode($exec,true);

        //return view('backup.jobs',compact('exec'))->with('success','Salida Consola');
        //return redirect()->route('backup.jobs')->with('error','Ha ocurrido un error al ejecutar el comando, por favor intente de nuevo o contacte al administrador');;
        //return back()->with('success','Se importan');
    }
    public function apiJobs()
    {
        $client = new \GuzzleHttp\Client();
        $server = '172.27.219.12';
        $res = $client->request('GET', "http://$server/api/jobs");
        $prints = json_decode($res->getBody()->getContents(),true);
        //dd($prints['results'],['pendingReason']);
        foreach ($prints['results'] as $api){

        }
        //dd($api);
        return view('backup.apiJobs', compact('prints'));
    }
    //___________________________________________________________________________//
    public function backupDoc1ModificationOfRoutes(){
        $inventario = 35;
        $groups = $this->getGroups($inventario,$this->method);
        return view('backup.backupDoc1ModificationOfRoutes',compact('groups','inventario'));
    }

    public function backupDoc1ModificationOfRoutesStore(Request $request){
        $campos=$request->all();
        $routes=array_values($campos["RUTAS"]);
        $idTemplate = 748;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;

        $arrayRoutes= array();

        foreach($routes as $route){
            $arrayRoutes[]="\"".$route."\"";
        }
        $stringRoutes=implode(' ',$arrayRoutes);
        $variables = array("extra_vars" =>
            [
                "HOST"=> "lnxansibawxprd",
                "RUTAS"=> $routes
            ]
        );

       $resultado = $this->runPlaybook($idTemplate,$variables);

       $resultado = $resultado['job'];

       $log->update([
        'id_job' => $resultado,
        ]);
    return redirect()->route('executionLogs.show',$id_asgard);
    }

    public function poliBackupClientes(){
        return view('backup.poliBackupClientes');
    }
    public function pandasBackup(){
        $results = shell_exec(app_path() . "\scripts\IRE\pan.bat");
        dd($results);
    }
}
