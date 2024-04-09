<?php

namespace App\Http\Controllers;

use App\VmHba;
use App\VmNic;
use App\VmHost;
use App\SyncLog;
use App\VReport;
use App\Snapshot;
use App\History;
use App\VmCommand;
use Carbon\Carbon;
use App\VirtualHost;
use App\VmCheckRepair;
use App\VmClusterCapacity;
use Illuminate\Http\Request;
use App\Http\Traits\ConnectionTrait;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use DB;


class VirtualizationController extends Controller
{
    Use ConnectionTrait;

    public function diagnostic(Request $request)
    {
        $view =  view('virtualizations.diagnostic');
        if($request->ajax()){
            if ($request->has("cod")){
                $hosts = VirtualHost::where('name','like',"%$request->cod%")->get();
                $view = View::make('virtualizations.table',compact('hosts'));
                $sections = $view->renderSections();
                return response()->json($sections['contentPanel']);
            }
        }else return $view;
    }
    public function runDiag($id, $vcenter)
    {
        $idTemplate = 65;
        $log = $this->getLog(1,12,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 2;
        $variables = array("extra_vars" => array("IDASGARD" => (string)$id_asgard,"NAME" => $id, "VCENTER" => $vcenter));

        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'result' => $id_asgard.'_'.$id.'.html',
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }

    public function consumption(Request $request)
    {
        $view =  view('virtualizations.consumption');
        if($request->ajax()){
            if ($request->has("cod")){
                $hosts = VirtualHost::where('name','like',"%$request->cod%")->get();
                $view = View::make('virtualizations.tableC',compact('hosts'));
                $sections = $view->renderSections();
                return response()->json($sections['contentPanel']);
            }
        }else return $view;
    }
    public function runCon($id, $vcenter)
    {
        $idTemplate = 66;
        $log = $this->getLog(1,12,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 2;
        $variables = array("extra_vars" => array("IDASGARD" => (string)$id_asgard,"CODIGOSERVICIO" => $id, "VCENTER" => $vcenter,"COPIEDEMAILS"=>"a@a"));

        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'result' => $id_asgard.'_'.$id.'.html',
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }


    public function activateRoundRobin()
    {
        return view('virtualizations.activateRoundRobin');
    }
    public function loadData()
    {
        $string = "";
        $result = shell_exec("powershell.exe -executionpolicy bypass -NoProfile ". app_path() . "\scripts\prueba.ps1" . escapeshellarg($string));
        $hosts = json_decode($result);
        foreach ($hosts as $host){
            VirtualHost::create([
                'vm_id' => $host->vm,
                'name' => $host->name,
                'power_state' => $host->power_state,
                'memory' => $host->memory_size_MiB,
                'cpu' => $host->cpu_count,
                'cluster' => $host->cluster,
                'datacenter' => $host->datacenter,
                'vcenter' => $host->vcenter,
            ]);
        }
        return 'OK';
    }
    public function reportIndex(Request $request)
    {
        $backList = [
            "Capacidad Cluster DC",
            // "Politica de Round Robin",
            // "Desactivar SSH VMHost VMWare",
            // "Estado Replica Inverfast",
            // "Datastore Duplicados en Clusters",
        ];

        $reportes = VReport::select('report')->whereNotIn('report',$backList)->distinct()->get();
        // dd($reportes->pluck('report')->values());

        $view =  view('virtualizations.vreports',compact('reportes'));
        if($request->ajax()){
            if ($request->has("tipo") && $request->has("f_ini") && $request->has("f_fin")){
                // dd($request->all());

                $rangoFecha = [$request->input("f_ini")." 00:00:00", $request->input("f_fin")." 23:59:59"];
                // where('report',$request->tipo)
                // whereBetween("created_at",$rangoFecha)->
                // dd($request->input('tipo'));
                // $reports = VReport::where('report',$request->input('tipo'))->orderBy('created_at','DESC')->take(10)->get();
                $reports = VReport::where('report',$request->input('tipo'))->whereBetween("created_at",$rangoFecha)->get();
                // dd($reports);

                $view = View::make('virtualizations.tableReports',compact('reports'));
                $sections = $view->renderSections();
                // return response()->json($rangoFecha);
                return response()->json($sections['contentPanel']);
            }
        }else return $view;

    }
    public function snapshot(Request $request)
    {
        $view =  view('virtualizations.snapshots');
        if($request->ajax()){
            if ($request->has("cod")){
                $hosts = VirtualHost::where('name','like',"%$request->cod%")->get();
                $view = View::make('virtualizations.tableSnap',compact('hosts'));
                $sections = $view->renderSections();
                return response()->json($sections['contentPanel']);
            }
        }else return $view;
    }
    public function snapshotStore(Request $request)
    {
        $this->validate($request, [
            'case' => 'required',
            'description' => 'required',
            'vHost' => 'required',
            'memory' => 'required',
        ]);
        //dd($request->vHost);
        $idTemplate = 102;
        $log = $this->getLog(1,12,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 2;
        $vHosts = $request->vHost;
        $hosts = "";
        //dd($vHosts);
        foreach($vHosts as $host){
            if ($host === end($vHosts)) {
                $hosts = $hosts.$host;
            }else{
                $hosts = $hosts.$host."*";
            }

        }
        $variables = array("extra_vars" => array("IDASGARD" => (string)$id_asgard,"IDSERVICEMANAGER" => $request->case, "DESCRIPTION" => $request->description,
        "VMIDS" => $hosts, "MEMORY" => (int)$request->memory));
        //dd($variables);

        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'result' => $id_asgard.'_SNAP.html',
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function snapDelete(Request $request)
    {
        $view =  view('virtualizations.snapDelete');
        if($request->ajax()){
            if ($request->has("cod")){
                $hosts = Snapshot::where('vm_name','like',"%$request->cod%")->get();
                $view = View::make('virtualizations.tableSnapDel',compact('hosts'));
                $sections = $view->renderSections();
                return response()->json($sections['contentPanel']);
            }
        }else return $view;
    }
    public function snapDeleteStore(Request $request)
    {
        $this->validate($request, [
            'vHost' => 'required',
            'case' => 'required',
        ]);
        $idTemplate = 103;
        $log = $this->getLog(1,12,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 2;
        $vHosts = $request->vHost;
        $hosts = "";
        //dd($vHosts);
        foreach($vHosts as $host){
            if ($host === end($vHosts)) {
                $hosts = $hosts.$host;
            }else{
                $hosts = $hosts.$host."*";
            }

        }
        $variables = array("extra_vars" => array("IDASGARD" => (string)$id_asgard,"IDSERVICEMANAGER" => $request->case, "VMIDS" => $hosts));
        //dd($variables);

        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'result' => $id_asgard.'_SNAP.html',
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function snapRevert(Request $request)
    {
        $view =  view('virtualizations.snapRevert');
        if($request->ajax()){
            if ($request->has("cod")){
                $hosts = Snapshot::where('vm_name','like',"%$request->cod%")->get();
                $view = View::make('virtualizations.tableSnapDel',compact('hosts'));
                $sections = $view->renderSections();
                return response()->json($sections['contentPanel']);
            }
        }else return $view;
    }
    public function snapRevertStore(Request $request)
    {
        $this->validate($request, [
            'vHost' => 'required',
            'case' => 'required',
        ]);
        $idTemplate = 104;
        $log = $this->getLog(1,12,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 2;
        $vHosts = $request->vHost;
        $hosts = "";
        //dd($vHosts);
        foreach($vHosts as $host){
            if ($host === end($vHosts)) {
                $hosts = $hosts.$host;
            }else{
                $hosts = $hosts.$host."*";
            }

        }
        $variables = array("extra_vars" => array("IDASGARD" => (string)$id_asgard,"IDSERVICEMANAGER" => $request->case, "VMIDS" => $hosts));
        //dd($variables);

        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'result' => $id_asgard.'_SNAP.html',
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function operationStep(Request $request)
    {
        $view =  view('virtualizations.operationStep');
        if($request->ajax()){
            if ($request->has("cod")){
                $hosts = VirtualHost::where('name','like',"%$request->cod%")->get();
                $view = View::make('virtualizations.tableSnap',compact('hosts'));
                $sections = $view->renderSections();
                return response()->json($sections['contentPanel']);
            }
        }else return $view;
    }
    public function operationStepStore(Request $request)
    {
        $this->validate($request, [
            'vHost' => 'required',
        ]);
        $idTemplate = 107;
        $log = $this->getLog(1,12,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 2;
        $vHosts = $request->vHost;
        $hosts = "";
        //dd($vHosts);
        foreach($vHosts as $host){
            if ($host === end($vHosts)) {
                $hosts = $hosts.$host;
            }else{
                $hosts = $hosts.$host."*";
            }

        }
        $variables = array("extra_vars" => array("IDASGARD" => (string)$id_asgard, "VMIDS" => $hosts));
        //dd($variables);

        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'result' => $id_asgard.'_CHECK.html',
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function inventory()
    {
        return view('virtualizations.inventory');
    }
    public function tagMV(Request $request)
    {
        $view =  view('virtualizations.tagMV');
        if($request->ajax()){
            if ($request->has("cod")){
                $hosts = VirtualHost::where('name','like',"%$request->cod%")->get();
                $view = View::make('virtualizations.tableSnap',compact('hosts'));
                $sections = $view->renderSections();
                return response()->json($sections['contentPanel']);
            }
        }else return $view;
    }
    public function tagMVStore(Request $request)
    {
        $this->validate($request, [
            'vHost' => 'required',
            'tag' => 'required',
        ]);
        $idTemplate = 192;
        $log = $this->getLog(1,12,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1000;
        $vHosts = $request->vHost;
        $hosts = "";
        //dd($vHosts);
        foreach($vHosts as $host){
            if ($host === end($vHosts)) {
                $hosts = $hosts.$host;
            }else{
                $hosts = $hosts.$host."*";
            }
        }
        $variables = array("extra_vars" => array("IDASGARD" => (string)$id_asgard, "VMIDS" => $hosts, "TAG" => (string)$request->input('tag') ));
        //dd($variables);
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
            'result' => $id_asgard.'_TAG.html',
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function snapshotSchedule(Request $request)
    {
        $view =  view('virtualizations.snapshotSchedule');
        if($request->ajax()){
            if ($request->has("cod")){
                $hosts = VirtualHost::where('name','like',"%$request->cod%")->get();
                $view = View::make('virtualizations.tableSnap',compact('hosts'));
                $sections = $view->renderSections();
                return response()->json($sections['contentPanel']);
            }
        }else return $view;
    }
    public function snapshotScheduleStore(Request $request)
    {
        $this->validate($request, [
            'vHost' => 'required',
            'sDate' => 'required',
            'sTime' => 'required',
            'case' => 'required',
            'description' => 'required',
            'memory' => 'required',
        ]);
        $timestamp = $request->input('sDate').' '.$request->input('sTime').':00';
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $timestamp);
        $date->setTimezone('UTC');
        //dd($date->format('Ymd\\THis\\Z'));
        $date = $date->format('Ymd\\THis\\Z');
        $idTemplate = 196;
        $scheduleLog = $this->getScheduleLog($idTemplate);
        //$scheduleLog = 356;
        $vHosts = $request->vHost;
        $hosts = "";
        //dd($vHosts);
        foreach($vHosts as $host){
            if ($host === end($vHosts)) {
                $hosts = $hosts.$host;
            }else{
                $hosts = $hosts.$host."*";
            }

        }
        $variables = array("extra_data" => array("IDASGARD" => (string)$scheduleLog->id,"IDSERVICEMANAGER" => $request->case, "DESCRIPTION" => $request->description,
        "VMIDS" => $hosts, "MEMORY" => (int)$request->memory),'name' => 'ASGARD_'.$scheduleLog->id, 'rrule' =>  "DTSTART:$date RRULE:FREQ=DAILY;INTERVAL=1;COUNT=1");
        //dd(json_encode($variables));

        $resultado = $this->jobSchedule($idTemplate,$variables,$scheduleLog);
        return redirect()->route('jobSchedules.show',$resultado);
    }
    public function cVMCustomer(Request $request)
    {
        $customers = VirtualHost::distinct('customer_name')->get('customer_name');
        $view =  view('virtualizations.cVMCustomer',compact('customers'));
        if($request->ajax()){
            if ($request->has("customer")){
                $hosts = VirtualHost::where('customer_name',$request->input('customer'))->get();
                $view = View::make('virtualizations.tableCVMCustomer',compact('hosts'));
                $sections = $view->renderSections();
                return response()->json($sections['contentPanel']);
            }
        }else return $view;
    }
    public function cVMCustomerStore(Request $request)
    {
        //dd($request);
        $idTemplate = 210;
        $log = $this->getLog(1,12,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 2;
        $vHosts = VirtualHost::distinct('vcenter')->where('customer_name',$request->input('customer'))->get('vcenter');
        //dd($vHosts);
        $vcenter = "";
        foreach($vHosts as $host){
            if ($host === end($vHosts)) {
                $vcenter = $vcenter.$host->vcenter;
            }else{
                $vcenter = $vcenter.$host->vcenter."*";
            }

        }
        $variables = array("extra_vars" => array("IDASGARD" => (string)$id_asgard,"CUSTOMER" => $request->input('customer'), "VCENTER" => $vcenter));
        //dd($variables);
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
            'result' => $id_asgard.'_CCVM.html',
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function updateVMWT(Request $request)
    {
        $view =  view('virtualizations.updateVMWT');
        if($request->ajax()){
            if ($request->has("cod")){
                $hosts = VirtualHost::where('name','like',"%$request->cod%")->get();
                $view = View::make('virtualizations.tableSnap',compact('hosts'));
                $sections = $view->renderSections();
                return response()->json($sections['contentPanel']);
            }
        }else return $view;
    }
    public function updateVMWTStore(Request $request)
    {
        $this->validate($request, [
            'vHost' => 'required',
        ]);
        //dd($request->vHost);
        $idTemplate = 228;
        $log = $this->getLog(1,12,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 2;
        $vHosts = $request->vHost;
        $hosts = "";
        //dd($vHosts);
        foreach($vHosts as $host){
            if ($host === end($vHosts)) {
                $hosts = $hosts.$host;
            }else{
                $hosts = $hosts.$host."*";
            }

        }
        $variables = array("extra_vars" => array("IDASGARD" => (string)$id_asgard,"VMIDS" => $hosts));
        //dd($variables);

        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
            'result' => $id_asgard.'_UPDATEVMWT.html',
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }

    public function resourcesUpgrade(Request $request)
    {
        $view =  view('virtualizations.resourcesUpgrade');
        if($request->ajax()){
            if ($request->has("cod")){
                $hosts = VirtualHost::where('name','like',"%$request->cod%")->get();
                $view = View::make('virtualizations.tableSnapResources',compact('hosts'));
                $sections = $view->renderSections();
                return response()->json($sections['contentPanel']);
            }
        }else return $view;
    }
    public function resourcesUpgradeStore(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'vHost' => 'required',
            'mem' => '',
            'cpu' => '',
            'case' => 'required',
            'checkMemory' => '',
            'checkVcpu' => ''
        ]);

        $memory = $request->mem;
        $cpu    = $request->cpu;
        $vHosts = $request->vHost;
        $checkmem = $request->checkMemory;
        $checkvcpu = $request->checkVcpu;
        $case = $request->case;
        $hosts  = "";

        //Tratamiento del dato enviado por la vista separado por comas
        foreach($vHosts as $host){
            $cadena = explode(',',$host);
        }

        //Variables para la carga del script
        $vmID        = $cadena[0];
        $vcenter     = $cadena[1];
        $memoriaant  = $cadena[3];
        $vcpuant     = $cadena[4];
        $valueRam    = $memory;
        $valueCpu    = $cpu;
        $string      = "";

        if ($checkmem == 1 && $checkvcpu == 2) {
            $valor_nuevomem = $valueRam;
            $id_automatizacionmem = "1";
            $valor_anteriormem = $memoriaant;

            $valor_nuevovcpu = $valueCpu;
            $id_automatizacionvcpu = "2";
            $valor_anteriorvcpu = $vcpuant;

        }else if($checkmem == 1 && $checkvcpu == null){
            $valor_nuevo = $valueRam;
            $id_automatizacion = "1";
            $valor_anterior = $memoriaant;
        }else{
            $valor_nuevo = $valueCpu;
            $id_automatizacion = "2";
            $valor_anterior = $vcpuant;
        }


        //Inicializacion  de la variable log que se usa mas adelante
        $log  = $this->getExternalToolLog('VmwareResources');

        //Ejecucion del script de powershell en asgard que llega a la maquina pivote de virtualizacion .36
        //Primeramente valido que tipo de Aumento es (1 es memoria, 2 Vcpu)
        if ($checkmem == 1 ) {
            # code...
            $valor_new = $valueRam;
        }
        else {
            # code...
            $valor_new = 0;
        }
        if ($checkvcpu == 2 ) {
            # code...
            $valor_cpu = $valueCpu;
        }
        else {
            # code...
            $valor_cpu = 0;
        }

        //dd($valor_new, $valor_cpu );
        $results = shell_exec("powershell.exe -executionpolicy bypass -NoProfile " . app_path() . "\scripts\SAN\R001-ExecutionScripts.ps1 -op 7 -params '-vmID $vmID -vcenter $vcenter -ram -valueRam $valor_new -cpu -valueCpu $valor_cpu'" . escapeshellarg($string));
        //dd($results);

        //decodificacion de los resultados enviados por el script
         $results = json_decode($results,true);
		 //dd($results);

        //Validacion  de los resultados y retorno de las vistas acorde a las validaciones
        if($results['error'] != ""){
            $log->update([
                'd_end_script' => date("Y-m-d H:i:s"),
                'status' => 12,
                'result' => 'Fallo en la ejecución del job',
            ]);
            return redirect()->route('virtualization.resourcesUpgrade')->with('error', $results['error']);

        }
        elseif ($results['error'] == "La virtual CPU fue configurada con exito. Para configurar el corespersocket debe apagar la VM"){

            $log->update([
                'd_end_script' => date("Y-m-d H:i:s"),
                'status' => 2,
                'result' => 'Ejecución realizada exitosamente',
            ]);
            return redirect()->route('virtualization.resourcesUpgrade')->with('error', $results['error']);
        }
        else{
            $log->update([
                'd_end_script' => date("Y-m-d H:i:s"),
                'status' => 2,
                'result' => 'Ejecución realizada exitosamente',
            ]);

            $id_asgard = $log->id;
			$id_template = "NULL";

            if ($checkmem == 1 && $checkvcpu == 2) {
                $history   = $this->gethistory($id_asgard,$case,$valor_anteriormem,$valor_nuevomem,$id_automatizacionmem,$id_template);
                $history   = $this->gethistory($id_asgard,$case,$valor_anteriorvcpu,$valor_nuevovcpu,$id_automatizacionvcpu,$id_template);

            }else if($checkmem == 1 && $cpu == null){
                $history   = $this->gethistory($id_asgard,$case,$valor_anterior,$valor_nuevo,$id_automatizacion,$id_template);

            }else{
                $history   = $this->gethistory($id_asgard,$case,$valor_anterior,$valor_nuevo,$id_automatizacion,$id_template);
            }

            if ($checkmem == 1 && $checkvcpu == 2) {
                return view('virtualizations.resourcesUpgradeRsAll',compact('results'));
            }
            else if ($checkmem == 1 && $checkvcpu == null) {
				return view('virtualizations.resourcesUpgradeRs',compact('results'));
			}else{
				return view('virtualizations.resourcesUpgradeRscpu',compact('results'));
			}
        }
    }
    public function resourcessnap(Request $request)
    {
        $view =  view('virtualizations.snapshotsResources');
        if($request->ajax()){
            if ($request->has("cod")){
                $hosts = VirtualHost::where('name','like',"%$request->cod%")->get();
                $sql = "SELECT created_at AS fecha
						FROM sync_logs
						WHERE id = (SELECT MAX(id)
									FROM sync_logs
									WHERE process= ?)
						AND process= ?";

						$UpdateDate = DB::select($sql,[
							(string) 'sync_inventory_vmware',
							(string) 'sync_inventory_vmware'
						]);
                $view = View::make('virtualizations.tableSnapResources',compact('hosts','UpdateDate'));
                $sections = $view->renderSections();
                return response()->json($sections['contentPanel']);
            }
        }else return $view;
    }
    public function configVM(Request $request)
    {
        $view =  view('virtualizations.configVM');
        if($request->ajax()){
            if ($request->has("cod")){
                $hosts = VirtualHost::where('name','like',"%$request->cod%")->get();
                $view = View::make('virtualizations.tableConfigVM',compact('hosts'));
                $sections = $view->renderSections();
                return response()->json($sections['contentPanel']);
            }
        }else return $view;
    }
    public function VMHostReport()
    {
        $vmHosts = VmHost::orderBy('vcenter')->get();
        $log = SyncLog::where('process','sync_vm_host')->latest()->first('created_at');
        if(!$log){
            $log = 'Nunca';
        }else{
            $log = $log->created_at;
        }
        return view('virtualizations.vmHosts', compact('vmHosts','log'));
    }
    public function VMHBAReport()
    {
        $vmHbas = VmHba::orderBy('id_vmhost')->get();
        $log = SyncLog::where('process','sync_vm_hba')->latest()->first('created_at');
        if(!$log){
            $log = 'Nunca';
        }else{
            $log = $log->created_at;
        }
        return view('virtualizations.vmHBA', compact('vmHbas','log'));
    }
    public function VMNICReport()
    {
        $vmNics = VmNic::orderBy('id_vmhost')->latest()->take(500)->get();
        $log = SyncLog::where('process','sync_vm_nic')->latest()->first('created_at');
        if(!$log){
            //dd($log);
            $log = 'Nunca';
        }else{
            $log = $log->created_at;
        }
        return view('virtualizations.vmNIC', compact('vmNics','log'));
    }
    public function VMHostShow(VmHost $vmHost)
    {
        return view('virtualizations.vmHostShow', compact('vmHost'));
    }
    public function commandExe()
    {
        $string = "";
        //dd(app_path() . "\scripts\SAN\R001-ExecutionScripts.ps1");
        $results = exec("powershell.exe -executionpolicy bypass -NoProfile ". app_path() . "\scripts\SAN\R001-ExecutionScripts.ps1 -op 5" . escapeshellarg($string));
        $vCenters = json_decode($results, true);
        $hosts = VmHost::where('power_state', 'PoweredOn')->where('connection_state', 'Connected')->orderBy('name')->get(['host_id', 'name','vcenter']);
        return view('virtualizations.commandExe', compact('vCenters','hosts'));
    }
    public function commandExeStore(Request $request)
    {
        $this->validate($request, [
            'command' => 'required|string|min:2',
        ]);
        if($request->input('type') == 'ESXi'){
            $this->validate($request, [
                'host' => 'required',
            ]);
        }else{
            $this->validate($request, [
                'vCenter' => 'required',
            ]);
        }
        $notAllowed = array('Answer', 'Apply','Attach','Connect','Detach','Disconnect','Download','Export','Import','New','Remediate','Remove','Restart','Scan','Set',
            'Shutdown','Stage','Start','Stop','Suspend','HookGetViewAutoCompleter','TabExpansion2','Update','Add','Compare','Copy','Dismount','Format','Install','Invoke',
            'Mount','Move','Open','Repair','Resume','Search','Switch','Sync','Test','Unlock','Wait');
        $test = false;
        $commands = explode('|', $request->input('command'));
        foreach ($commands as $command) {
            $words = explode(" ",$command);
            foreach($words as $word){
                foreach($notAllowed as $not){
                    if (strpos(strtoupper($word), strtoupper($not)."-") !== false) {
                        $test = true;
                    }
                }
            }
        }
        if($test === true){
            return redirect()->route('virtualization.commandExe')->with('error','No están permitidos comandos que no sean de tipo Get');
        }
        if($request->input('type') == 'ESXi'){
            $vCenter= $request->input('host');
        }else{
            $vCenter= $request->input('vCenter');
        }
        $type = $request->input('type');
        $command = str_replace("|", "#", $request->input('command'));
        $log = $this->getExternalToolLog('virtualizationCommandExec');
        $string = "";
        //dd("powershell.exe -executionpolicy bypass -NoProfile ". app_path() . "\scripts\SAN\R001-ExecutionScripts.ps1 -op 4 -params '-vcenter *$vCenter* -TypeCommand *$type* -Command *$command*'" . escapeshellarg($string));
        $results = exec("powershell.exe -executionpolicy bypass -NoProfile ". app_path() . "\scripts\SAN\R001-ExecutionScripts.ps1 -op 4 -params '-vcenter *$vCenter* -TypeCommand *$type* -Command *$command*'" . escapeshellarg($string));
        $results = json_decode($results);
        //dd($results);
        if($results === null){
            return redirect()->route('virtualization.commandExe')->with('error','Ha ocurrido un error al ejecutar el comando, por favor intente de nuevo o contacte al administrador');
        }else{
            if($request->input('type') == 'ESXi'){
                //dd($results);
                if(isset($results->Error)){
                    $log->update([
                        'd_end_script' => date("Y-m-d H:i:s"),
                        'status' => 12,
                        'result' => "Fallo en la ejecución de *$command*",
                    ]);
                    return redirect()->route('virtualization.commandExe')->with('error',$results->Error);
                }else{
                    //dd($results);
                    if(!empty($results)){
                        $log->update([
                            'd_end_script' => date("Y-m-d H:i:s"),
                            'status' => 2,
                            'result' => "Ejecución de *$command* realizada exitosamente",
                        ]);
                        return view('virtualizations.commandExeRs',compact('results','type'));
                    }else{
                        $log->update([
                            'd_end_script' => date("Y-m-d H:i:s"),
                            'status' => 12,
                            'result' => "Fallo en la ejecución de *$command*",
                        ]);
                        return redirect()->route('virtualization.commandExe')->with('error','El comando no retorno datos validos para la consulta');
                    }
                }
            }else{
                if($results[0] === true && count($results) > 1){
                    unset($results[0]);
                    //dd($results);
                    $log->update([
                        'd_end_script' => date("Y-m-d H:i:s"),
                        'status' => 2,
                        'result' => "Ejecución de *$command* realizada exitosamente",
                    ]);
                    return view('virtualizations.commandExeRs',compact('results','type'));
                }else{
                    $log->update([
                        'd_end_script' => date("Y-m-d H:i:s"),
                        'status' => 12,
                        'result' => "Fallo en la ejecución de *$command*",
                    ]);
                    return redirect()->route('virtualization.commandExe')->with('error','El comando no retorno datos validos para la consulta');
                }
            }

        }
        //dd($results);
    }
    public function checkHost(Request $request)
    {
        $view =  view('virtualizations.checkHost');
        if($request->ajax()){
            if ($request->has("cod")){
                $hosts = VmHost::where('name','like',"%$request->cod%")->get();
                $view = View::make('virtualizations.tableCheckHost',compact('hosts'));
                $sections = $view->renderSections();
                return response()->json($sections['contentPanel']);
            }
        }else return $view;
    }
    public function checkHostStore(Request $request)
    {
        $this->validate($request, [
            'vHost' => 'required',
        ]);
        $idTemplate = 286;
        $log = $this->getLog(1,12,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 2;
        $vHosts = $request->vHost;
        $hosts = "";
        //dd($vHosts);
        foreach($vHosts as $host){
            if ($host === end($vHosts)) {
                $hosts = $hosts.$host;
            }else{
                $hosts = $hosts.$host."*";
            }

        }
        $variables = array("extra_vars" => array("IDASGARD" => (string)$id_asgard, "VMIDS" => $hosts));
        //dd($variables);

        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        $log->update([
            'id_job' => $resultado,
            'result' => $id_asgard.'_CHECK_VMHOST.html',
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }

    public function clusterCapacityReport(Request $request){
        if($request->ajax()){
            if ($request->has("fecha")){
                $items = VmClusterCapacity::distinct()->whereDate('created_at', $request->input('fecha'))->get(['created_at']);
                return $items;
            }
        }else{
            $vcenters = VmClusterCapacity::distinct()->get(['vcenter']);
            $segments = VmClusterCapacity::distinct()->get(['segment']);
            return view('virtualizations.clusterCapacityReport',compact('vcenters','segments'));
        }
    }


    public function clusterCapacityReportRs(Request $request){
        $this->validate($request, [
            'fecha' => 'required|date',
            'vcenter' => 'required',
            'report' => 'required',
            //'segment' => 'required',
        ]);
        // dd($request->input('report'));
        $campos = $request->all();
        // dd($campos);
        // $item = VmClusterCapacity::paginate(10);
        // $item = VmClusterCapacity::where('created_at', $request->input('fecha'))->take(10)->get();
        $items = [];
        $fechaFiltro = [ $request->input('fecha')." 00:00:00",$request->input('fecha')." 23:59:59" ];
        if( $campos["vcenter"]  == "0" && $campos["segment"]  == "0" && $campos["report"]  == "0"){
            $items = VmClusterCapacity::whereBetween('created_at', $fechaFiltro)->get();
        }else{

            if( $campos["report"] != "0" ){
                // dd($campos["report"],$campos["fecha"]);
                $fechaFiltro = date("Y-m-d H:i:s",strtotime($campos["report"]));
                $items = VmClusterCapacity::where('created_at', $fechaFiltro )->get();
                // dd($items,"aqui");
            }

            if($request->input('vcenter') == "0"){
                // $items = VmClusterCapacity::whereBetween('created_at',[ $request->input('fecha')." 00:00:00",$request->input('fecha')." 23:59:59" ])->get();
            }else{
                $items = VmClusterCapacity::whereBetween('created_at', $fechaFiltro)->where('vcenter',$request->input('vcenter'))->get();
            }

            if($request->input('segment') == "0"){
                // $items = VmClusterCapacity::where('created_at', $request->input('fecha'))->get();
            }else{
                $items = VmClusterCapacity::whereBetween('created_at', $fechaFiltro)->where('segment',$request->input('segment'))->get();
            }
            // dd( $items );
        }
        if(is_null($items) || count($items) == 0 ){
            return redirect()->route('virtualization.clusterCapacityReport')->with('error','No existen datos para el reporte en la fecha seleccionada');
        }else{
            return view('virtualizations.clusterCapacityReportRs',compact('items'));
        }
    }
    public function checkVMRepairSearch(Request $request)
    {
        $view =  view('virtualizations.checkVMRepairSearch');
        if($request->ajax()){
            if ($request->has("cod")){
                //$hosts = VmCheckRepair::where('name','like',"%$request->cod%")->groupBy('id_asgard','name','created_at')->get(['name','id_asgard','created_at']);
                $hosts = VmCheckRepair::where('name','like',"%$request->cod%")->latest()->first();
                //dd($hosts);
                $view = View::make('virtualizations.tableCheckVM',compact('hosts'));
                $sections = $view->renderSections();
                return response()->json($sections['contentPanel']);
            }
        }else return $view;
    }
    public function checkVMRepair(Request $request, $name, $id_asgard)
    {
        $items = VmCheckRepair::where('name',$name)->where('id_asgard',$id_asgard)->get();
        $type = VmCheckRepair::where('id_asgard',$id_asgard)->first(['type']);
        //dd($items);
        return  view('virtualizations.checkVMRepair', compact('items','type','id_asgard','name'));
    }
    public function checkVMRepairStore(Request $request)
    {
        /*
            Tareas e id's trabajadas
            1. Versión Vmware Tools actualizadas e instaladas
            2. Versión Hardware Virtual actualizada	 R
            3. Hot Add Memory R
            4. Hot Add CPU R
            8. Sin Floppy
            12. Reserva de Memoria
            13. Reserva de CPU
            16. Unidad de Cd o dvd sin Isos
            17. Máquina virtual sin snapshot
            18. Solicitud de Consolidación de discos
        */
        $this->validate($request, [
            'repair' => 'required',
            'type' => 'required|string|min:1|max:10',
            'id' => 'required',
            'name' => 'required',
        ]);
        //dd($request->input('id'));
        if($request->input('type') == 'VM'){
            $idTemplate = 309;
        }elseif($request->input('type') == 'HOST'){
            $idTemplate = 337;
        }elseif($request->input('type') == 'unix'){
            $idTemplate = 344;
        }
        $log = $this->getLog(6,12,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $repairs = $request->input('repair');
        $ids = "";
        foreach($repairs as $id){
            if ($id === end($repairs)) {
                $ids .= $id;
            }else{
                $ids .= $id."*";
            }

        }
        $variables = array("extra_vars" => array("IDS" => (string)$ids, "id_asgard" => $id_asgard));
        //dd($variables);
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
            'result' => route('virtualization.checkVMRepair', [$request->input('name'),$request->input('id')] ),
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
    }
    public function diagTest(Request $request)
    {

        return view('virtualizations.diagTest');
        /*
        $view =  view('virtualizations.diagTest');
        //dd($request->has("cod"));
        if($request->ajax()){
            if ($request->has("cod")){
                $hosts = VirtualHost::where('name','like',"%$request->cod%")->get();
                //dd($hosts);
                $view = View::make('virtualizations.table',compact('hosts'));
                $sections = $view->renderSections();
                return response()->json($sections['contentPanel']);
            }
        }else return $view;*/
    }
    public function diagTestStore(Request $request)
    {
        /*$this->validate($request, [
            'vHost' => 'required',
        ]);*/
        $destinatario = "cristian.arteagac@claro.com.co";
        $copia = "jegomezg@indracompany.com";
        $asunto = "Prueba asgard";
        $cuerpo = "Prueba asgard";
        $adjunto = "";
        //dd($destinatario | $copia | $asunto | $cuerpo | $adjunto);
        //$this->sendEmail($destinatario,$copia, $asunto,$cuerpo,$adjunto);
        $string = "";
        //dd(app_path() . "\scripts\GENERAL_FUNCTIONS\R002-SendMail.ps1");
        $results = shell_exec("powershell.exe -executionpolicy bypass -NoProfile ". app_path() . "\scripts\TEST\R002-SendMail.ps1 -destinatario '$destinatario' -copia '$copia' -asunto '$asunto' -cuerpo '$cuerpo' -adjunto '$adjunto'" . escapeshellarg($string));
        //dd("powershell.exe -executionpolicy bypass -NoProfile ". app_path() . "\scripts\TEST\R002-SendMail.ps1 '-destinatario $destinatario -copia $copia -asunto $asunto -cuerpo $cuerpo -adjunto $adjunto'" . escapeshellarg($string));
        //dd($results);
        $mail = json_decode($results, true);
        dd($mail);
        /*

        $vHosts = $request->vHost;
        foreach($vHosts as $host){
            $cadena = explode(',',$host);
        }
        $vmID = $cadena[0];
        $vcenter = $cadena[1];
        $log = $this->getLog(1,12,2);
        $id_asgard = $log->id;
        $string = "";
        $results = shell_exec("powershell.exe -executionpolicy bypass -NoProfile ". app_path() . "\scripts\GENERAL_FUNCTIONS\R001-ExecutionScripts.ps1 -id_asgard $id_asgard -opcion 2 -parametros '-name $vmID -vcenter $vcenter -idasgard $id_asgard'" . escapeshellarg($string));
        //dd($results);
        $results = json_decode($results,true);
        //dd($results);
        //dd("\scripts\GENERAL_FUNCTIONS\R001-ExecutionScripts.ps1 -id_asgard $id_asgard -opcion 2 -parametros '-name $vmID -vcenter $vcenter -idasgard $id_asgard'");

        //$resultado = $resultado['job'];
        $log->update([
            'id_job' => $results,
            'result' => $id_asgard.'_'.$vmID.'.html',
        ]);*/
        return $mail;
        //return redirect()->route('executionLogs.show',$id_asgard);

    }

	public function vlanUpdate(Request $request)
    {
        $view = view('virtualizations.vlanUpdate');

        if($request->ajax()){
            if ($request->has("cod")){
                if($request->cod == 1){
                    $hosts = VirtualHost::where('name','like',"%$request->cod%")->get();
                    $view = View::make('virtualizations.tableResourcesVlan',compact('hosts'));
                    $sections = $view->renderSections();
                    return response()->json($sections['contentPanel']);
                }
                if($request->cod == 2 ){
                    $vcenter = $request->vcenter;
                    $cluster = $request->cluster;
                    $string      = "";
                    $vlans = shell_exec("powershell.exe -executionpolicy bypass -NoProfile " . app_path() . "\scripts\SAN\R001-ExecutionScripts.ps1 -op 9 -params '-vcenter $vcenter -cluster $cluster'" . escapeshellarg($string));
					//$vlans = json_decode($vlans,true);

					$json  = utf8_encode($vlans);
					$vlans = json_decode($json,true);
					//dd($vlans);
                    $countVLAN  = COUNT($vlans['vlanName']);
                    $view = View::make('virtualizations.tableVlanCluster',compact('countVLAN','vlans'));
                    $sections = $view->renderSections();
                    return response()->json($sections['contentPanel']);
                }
            }
        }else return $view;
    }

    public function vlanTablePost(Request $request)
    {
        $idVm    = $request->idVM;
        $vcenter = $request->vcenter;
        $string  = "";
        $result = shell_exec("powershell.exe -executionpolicy bypass -NoProfile " . app_path() . "\scripts\SAN\R001-ExecutionScripts.ps1 -op 8 -params '-vmID $idVm -vcenter $vcenter'" . escapeshellarg($string));
        //dd($result);
		$result = json_decode($result,true);
        return response()->json(["data" => $result]);
    }


    public function resourcesVlan(Request $request)
    {
        $view = view('virtualizations.vlanUpdate');

        if($request->ajax()){
            if ($request->has("cod")){

                $sql = "SELECT created_at AS fecha
                FROM sync_logs
                WHERE id = (SELECT MAX(id)
                            FROM sync_logs
                            WHERE process= ?)
                AND process= ?";

                $UpdateDate = DB::select($sql,[
                    (string) 'sync_inventory_vmware',
                    (string) 'sync_inventory_vmware'
                ]);


                $hosts = VirtualHost::where('name','like',"%$request->cod%")->get();
                $view = View::make('virtualizations.tableResourcesVlan',compact('hosts', 'UpdateDate'));
                $sections = $view->renderSections();
                return response()->json($sections['contentPanel']);
            }
        }else return $view;
    }




    public function vlanUpdateStore(Request $request)
    { //dd($request->all());
        $this->validate($request, [
            'vHost' => 'required',
            'case' => 'required'
        ]);
        $vHosts = $request->vHost;
        $case = $request->case;
        $networkSelect = $request->networks;
		 //dd($networkSelect);

        //Vlans Nuevos
        $vlan = $request->vlan;
        $vlan1 = $request->vlan1;
        $vlan2 = $request->vlan2;
        $vlan3 = $request->vlan3;
        $vlan5 = $request->vlan5;
        $vlan6 = $request->vlan6;
        $vlan7 = $request->vlan7;
        $vlan8 = $request->vlan8;
        $vlan9 = $request->vlan9;
        $vlan10 = $request->vlan10;
        //Vlans anteriores
        $vlanAnt  = $request->vlanAnt;
        $vlan1Ant = $request->vlan1Ant;
        $vlan2Ant = $request->vlan3Ant;
        $vlan3Ant = $request->vlan4Ant;
        $vlan5Ant = $request->vlan5Ant;
        $vlan6Ant = $request->vlan6Ant;
        $vlan7Ant = $request->vlan7Ant;
        $vlan8Ant = $request->vlan8Ant;
        $vlan9Ant = $request->vlan9Ant;
        $vlan10Ant = $request->vlan10Ant;

        $hosts  = "";
        $i = 0;
        $salidaFinal = [];

        //Tratamiento del dato enviado por la vista separado por comas
        foreach($vHosts as $host){
            $cadena = explode(',',$host);
        }

        foreach($networkSelect as $network){
            $vmID        = $cadena[0];
            $vcenter     = $cadena[1];
            $NetworkAdapternew = $network;
            $string      = "";

           // dd($NetworkAdapternew);

            if ($NetworkAdapternew == "Network adapter 1"){
                $vlanNew =  $vlan;
                $vlanAnt =  $vlanAnt;
            }
            if ($NetworkAdapternew == "Network adapter 2"){
                $vlanNew =  $vlan1;
                $vlanAnt =  $vlan1Ant;
            }
            if ($NetworkAdapternew == "Network adapter 3"){
                $vlanNew =  $vlan2;
                $vlanAnt =  $vlan2Ant;
            }
            if ($NetworkAdapternew == "Network adapter 4"){
                $vlanNew =  $vlan3;
                $vlanAnt =  $vlan3Ant;
            }
            if ($NetworkAdapternew == "Network adapter 5"){
                $vlanNew =  $vlan5;
                $vlanAnt =  $vlan5Ant;
            }
            if ($NetworkAdapternew == "Network adapter 6"){
                $vlanNew =  $vlan6;
                $vlanAnt =  $vlan6Ant;
            }
            if ($NetworkAdapternew == "Network adapter 7"){
                $vlanNew =  $vlan7;
                $vlanAnt =  $vlan7Ant;
            }
            if ($NetworkAdapternew == "Network adapter 8"){
                $vlanNew =  $vlan8;
                $vlanAnt =  $vlan8Ant;
            }
            if ($NetworkAdapternew == "Network adapter 9"){
                $vlanNew =  $vlan9;
                $vlanAnt =  $vlan9Ant;
            }
            if ($NetworkAdapternew == "Network adapter 10"){
                $vlanNew =  $vlan10;
                $vlanAnt =  $vlan10Ant;
            }

            $log  = $this->getExternalToolLog('VmwareResources');
			$results = shell_exec("powershell.exe -executionpolicy bypass -NoProfile " . app_path() . "\scripts\SAN\R001-ExecutionScripts.ps1 -op 10 -params '-vmID $vmID -vcenter $vcenter -cambiovlan -valueNetworkAdapter *$NetworkAdapternew* -ValueNetworkName *$vlanNew*'" . escapeshellarg($string));
		    //dd("powershell.exe -executionpolicy bypass -NoProfile " . app_path() . "\scripts\SAN\R001-ExecutionScripts.ps1 -op 10 -params '-vmID $vmID -vcenter $vcenter -cambiovlan -valueNetworkAdapter *$NetworkAdapternew* -ValueNetworkName *$vlanNew*'");
            //dd($results);
			$results = json_decode($results,true);
			//dd($results);

            if($results['error'] != ""){

                $log->update([
                    'd_end_script' => date("Y-m-d H:i:s"),
                    'status' => 12,
                    'result' => 'Fallo en la ejecución del job',
                ]);
                return redirect()->route('virtualization.vlanUpdate')->with('error', $results['error']);
            }else{
                $log->update([
                    'd_end_script' => date("Y-m-d H:i:s"),
                    'status' => 2,
                    'result' => 'Ejecución realizada exitosamente',
                ]);
            }
                $id_asgard = $log->id;
				$id_template = "NULL";
                $history   = $this->gethistory($id_asgard,$case,$vlanAnt,$NetworkAdapternew.','.$vlanNew,4,$id_template);

            /*  $results = '{"vmname":"mv1_RF1271014_172.27.211.75","vlan_old":"Managament_Pruebas_CiberSeguridad_2722","vlan_new":"Managament_Pruebas_CiberSeguridad_2722","net_adapter":"Network adapter 1","status":"Success","error":""}';
            $results = json_decode($results,true); */

          $salida  = array('NetworkAdapternew'=>$NetworkAdapternew,'vlanAnt'=>$vlanAnt,'vlanNew'=>$vlanNew);
          array_push($salidaFinal,$salida);
          $i++;

        }
        //dd($salidadFinal);
        return view('virtualizations.resourcesUpdateVlan',compact('salidaFinal','results'));
    }

    public function resourcesDisk(Request $request)
    {
        $view = view('virtualizations.resourcesDisk');
        if($request->ajax()){
            if ($request->has("cod")){
                if($request->cod == 1){
                    $hosts = VirtualHost::where('name','like',"%$request->cod%")->get();
                    $view = View::make('virtualizations.tableResourcesVlan',compact('hosts'));
                    $sections = $view->renderSections();
                    return response()->json($sections['contentPanel']);
                }
                if($request->cod == 2 ){
                    $vcenter = $request->vcenter;
                    $cluster = $request->cluster;
                    $string      = "";
                    $view = View::make('virtualizations.tableDiscoDuro');
                    $sections = $view->renderSections();
                    return response()->json($sections['contentPanel']);
                }
            }
        }else return $view;
    }

    public function DiskTablePost(Request $request)
    {
        $idVm    = $request->idVM;
        $vcenter = $request->vcenter;
        $string  = "";

        $result = shell_exec("powershell.exe -executionpolicy bypass -NoProfile " . app_path() . "\scripts\SAN\R001-ExecutionScripts.ps1 -op 11 -params '-vmID $idVm -vcenter $vcenter'" . escapeshellarg($string));

        $result = json_decode($result,true);



        $salida  = array("vmName" => $result["vmName"],
                        "disco" => $result["disco"],
                        "datastore" => $result["datastore"],
                        "freeSpace" => $result["freeSpace"],
                        "capacityDisk" => $result["capacityDisk"],
                        "capacityTotalDataStore" => $result["capacityTotalDataStore"],
                        "AvailableSpace" => $result["AvailableSpace"],
                        "status" => $result["status"],
                        "error" => $result["error"]);



        //array_push($salidaFinal,$salida);
        //dd($salidaFinal);

      // $pba = response()->json(["data" => $result]);
      // dd($pba);
        return response()->json(["data" => $salida]);
    }

    public function resourcesDiskStore(Request $request)
    {

        $this->validate($request, [
            'vHost' => 'required',
            'case' => 'required'
        ]);

        $vHosts = $request->vHost;
        $case = $request->case;
        $hardDiskSelect = $request->hardDisk;

        //tamanoaprov Nuevos
        $tamanoaprov  = $request->tamanoaprov;
        $tamanoaprov1 = $request->tamanoaprov1;
        $tamanoaprov2 = $request->tamanoaprov2;
        $tamanoaprov3 = $request->tamanoaprov3;
        //tamanoaprov Anterior
        $tamanoctual  = $request->tamanoctual;
        $tamanoctual1 = $request->tamanoctual1;
        $tamanoctual2 = $request->tamanoctual2;
        $tamanoctual3 = $request->tamanoctual3;

        //dd($hardDiskSelect,$tamanoaprov,$tamanoaprov1,$tamanoaprov2,$tamanoaprov3, $tamanoctual, $tamanoctual1, $tamanoctual2, $tamanoctual3);

        $hosts  = "";
        $i = 0;
        $salidaFinal = [];

        //Tratamiento del dato enviado por la vista separado por comas
        foreach($vHosts as $host){
            $cadena = explode(',',$host);
        }

        foreach($hardDiskSelect as $hardDisk){

            $vmID        = $cadena[0];
            $vcenter     = $cadena[1];
            $hardDisknew = $hardDisk;
            $string      = "";

            if ($hardDisknew == "Hard disk 1"){

                if ($tamanoaprov < $tamanoctual ){
                    $error = "El tamaño a aprovisionar no puede ser menor al actual";
                    return redirect()->route('virtualization.resourcesDisk')->with('error', $error);
                }

                if ($tamanoaprov > $request->tamanomaxdts){
                 $error = "El tamaño para aprovisionar supera el tamaño máximo del datastore, el máx permitidos es :" .$request->tamanomaxdts."GB , lo que corresponde al 80% de espacio disponible para aprovisionar";
                 return redirect()->route('virtualization.resourcesDisk')->with('error', $error);
                }
                $valueDisk =  $tamanoaprov;
                $tamAnt    = $tamanoctual;


            }
            if ($hardDisknew == "Hard disk 2"){

                if ($tamanoaprov1 < $tamanoctual1 ){
                    $error = "El tamaño a aprovisionar no puede ser menor al actual";
                    return redirect()->route('virtualization.resourcesDisk')->with('error', $error);
                }

                if ($tamanoaprov1 > $request->tamanomaxdts1){
                 $error = "El tamaño para aprovisionar supera el tamaño máximo del datastore, el máx permitidos es :" .$request->tamanomaxdts1."GB , lo que corresponde al 80% de espacio disponible para aprovisionar";
                 return redirect()->route('virtualization.resourcesDisk')->with('error', $error);
                }
                $valueDisk =  $tamanoaprov1;
                $tamAnt    = $tamanoctual1;
            }
            if ($hardDisknew == "Hard disk 3"){

                if ($tamanoaprov2 < $tamanoctual2 ){
                    $error = "El tamaño a aprovisionar no puede ser menor al actual";
                    return redirect()->route('virtualization.resourcesDisk')->with('error', $error);
                }

                if ($tamanoaprov2 > $request->tamanomaxdts2){
                 $error = "El tamaño para aprovisionar supera el tamaño máximo del datastore, el máx permitidos es :" .$request->tamanomaxdts2."GB , lo que corresponde al 80% de espacio disponible para aprovisionar";
                 return redirect()->route('virtualization.resourcesDisk')->with('error', $error);
                }
                $valueDisk =  $tamanoaprov2;
                $tamAnt    = $tamanoctual2;
            }
            if ($hardDisknew == "Hard disk 4"){

                if ($tamanoaprov3 < $tamanoctual3 ){
                    $error = "El tamaño a aprovisionar no puede ser menor al actual";
                    return redirect()->route('virtualization.resourcesDisk')->with('error', $error);
                }

                if ($tamanoaprov3 > $request->tamanomaxdts3){
                 $error = "El tamaño para aprovisionar supera el tamaño máximo del datastore, el máx permitidos es :" .$request->tamanomaxdts3."GB , lo que corresponde al 80% de espacio disponible para aprovisionar";
                 return redirect()->route('virtualization.resourcesDisk')->with('error', $error);
                }
                $valueDisk =  $tamanoaprov3;
                $tamAnt    = $tamanoctual3;
            }

            $log  = $this->getExternalToolLog('VmwareResources');
            $results = shell_exec("powershell.exe -executionpolicy bypass -NoProfile " . app_path() . "\scripts\SAN\R001-ExecutionScripts.ps1 -op 12 -params '-vmID $vmID -vcenter $vcenter -disk *$hardDisknew* -valueDisk $valueDisk'" . escapeshellarg($string));

            $results = json_decode($results,true);


            if($results['error'] != ""){
                $log->update([
                    'd_end_script' => date("Y-m-d H:i:s"),
                    'status' => 12,
                    'result' => 'Fallo en la ejecución del job',
                ]);
                return redirect()->route('virtualization.resourcesDisk')->with('error', $results['error']);
            }else{
                $log->update([
                    'd_end_script' => date("Y-m-d H:i:s"),
                    'status' => 2,
                    'result' => 'Ejecución realizada exitosamente',
                ]);

                $id_asgard = $log->id;
				$idTemplate = "NULL";
                $history   = $this->gethistory($id_asgard,$case,$tamAnt,$hardDisknew.','.$valueDisk,3,$idTemplate);
            }

          $salida  = array('hardDisknew'=>$hardDisknew,'tamAnt'=>$tamAnt,'valueDisk'=>$valueDisk);
          array_push($salidaFinal,$salida);
          $i++;

        }
        //dd($salidadFinal);
        return view('virtualizations.resourcesUpdateDisk',compact('salidaFinal','results'));
    }

//--------------------------------------ADICION DE DISCOS--------------------------------------------------------
 public function addHardDisk(Request $request)
    {
        $view = view('virtualizations.addHardDisk');
        if($request->ajax()){
            if ($request->has("cod")){
                if($request->cod == 1){
                    $hosts = VirtualHost::where('name','like',"%$request->cod%")->get();
                    $view = View::make('virtualizations.tableResourcesVlan',compact('hosts'));
                    $sections = $view->renderSections();
                    return response()->json($sections['contentPanel']);
                }
                if($request->cod == 2 ){
                    $vcenter = $request->vcenter;
                    $cluster = $request->cluster;
                    $idVm = $request->idVM;
                    $string = "";
                    $salidaFinal = [];

                    $datastoreCluster = shell_exec("powershell.exe -executionpolicy bypass -NoProfile " . app_path() . "\scripts\SAN\R001-ExecutionScripts.ps1 -op 13 -params '-vcenter $vcenter -cluster $cluster'" . escapeshellarg($string));
                    //$datastoreCluster      = '{"Name":["D_TFM2877_R6_N2_ID005_DECACORE002_4TB","Local_c-tfm4069-gax15-0212-ch121v5","I_TFM3516_R6_N1_ID003_OCTADECACORE08_2TB"],"FreeSpaceGB":[1341.5947265625,425.763671875,425.58203125],"CapacityGB":[4095.75,438.5,2047.75],"availableProvisioned":[317.6572265625,316.138671875,-86.35546875],"status":"Success","error":""}';
                    $json  = utf8_encode($datastoreCluster);
					$datastoreCluster = json_decode($json,true);
				    //dd($datastoreCluster);
                    $countDatastore  = COUNT($datastoreCluster['Name']);

                    //Obtengo los discos asociados a la Vm seleccionada
                    $resultdisk = shell_exec("powershell.exe -executionpolicy bypass -NoProfile " . app_path() . "\scripts\SAN\R001-ExecutionScripts.ps1 -op 11 -params '-vmID $idVm -vcenter $vcenter'" . escapeshellarg($string));
                    //$resultdisk ='{"vmName":"PRUEBAS_ASGARD","disco":["Hard disk 1","Hard disk 2","Hard disk 3","Hard disk 4"],"datastore":["H_TFM3814_R6_MT_ID123_OCTADECACORE08_4TB","I_TFM3516_R6_N1_ID004_OCTADECACORE08_2TB","I_TFM3516_R6_N4_ID009_OCTADECACORE08_4TB","I_TFM3516_R6_N4_ID009_OCTADECACORE08_4TB"],"freeSpace":[1787.1552734375,799.84765625,1531.27734375,1531.27734375],"capacityDisk":[125,5,10,5],"capacityTotalDataStore":[4095.75,2047.75,4095.75,4095.75],"AvailableSpace":[968.0052734375,390.29765625,712.12734375,712.12734375],"status":"Success","error":""}';
                    $json  = utf8_encode($resultdisk);
					$resultdisk = json_decode($json,true);

                    $countdisk  = COUNT($resultdisk['disco']);

                    $view = View::make('virtualizations.tableAddHardDisk',compact('countDatastore','datastoreCluster','countdisk','resultdisk'));
                    $sections = $view->renderSections();
                    return response()->json($sections['contentPanel']);
                }
            }
        }else return $view;
    }

    public function addHardDiskStore1(Request $request)
    {
		ini_set('max_execution_time', '0');
		ini_set('memory_limit','512M');

        $this->validate($request, [
            'vHost' => 'required',
            'case' => 'required'
        ]);

        $vHosts = $request->vHost;
        $case = $request->case;
        $capacidad = $request->tamanoaprov;
        $datastore = $request->datastore;
        $capacidad1 = $request->tamanoaprov1;
        $datastore1 = $request->datastore1;
        $capacidad2 = $request->tamanoaprov2;
        $datastore2 = $request->datastore2;
        $hosts  = "";
        $i = 0;
        $salidaFinal = [];

        //Tratamiento del dato enviado por la vista separado por comas
        foreach($vHosts as $host){
            $cadena = explode(',',$host);
        }
            $vmID        = $cadena[0];
            $vcenter     = $cadena[1];
            $string      = "";


        //VALIDO SI EXISTE LA PRIMERA FILA CON DATOS
        if ($capacidad != 0 && $datastore != "null" ){

            foreach($datastore as $dtsseparado){
                $cadenadts = explode(',',$dtsseparado);
            }

            $datastoredef     = $cadenadts[0];
            $vmID = $vmID;
            $vcenter =  $vcenter;
            $capacidad =  $capacidad;

            $log  = $this->getExternalToolLog('VmwareResourcesAdicionDiscos');
			$results = shell_exec("powershell.exe -executionpolicy bypass -NoProfile " . app_path() . "\scripts\SAN\R001-ExecutionScripts.ps1 -op 14 -params '-vmID $vmID -vcenter $vcenter -capacidad $capacidad -datastore *$datastoredef*'" . escapeshellarg($string));
            $results = json_decode($results,true);

            if($results['error'] != ""){
                $log->update([
                    'd_end_script' => date("Y-m-d H:i:s"),
                    'status' => 12,
                    'result' => 'Fallo en la ejecución del job',
                ]);
                return redirect()->route('virtualization.addHardDisk')->with('error', $results['error']);
            }else{
                $log->update([
                    'd_end_script' => date("Y-m-d H:i:s"),
                    'status' => 2,
                    'result' => 'Ejecución realizada exitosamente',
                ]);

				$id_asgard = $log->id;
				$idTemplate = "NULL";
                $history   = $this->gethistory($id_asgard,$case,0,$vmID  .  ' Tamaño aprovisionado:'.$capacidad,7,$idTemplate);
                $salida= "Ejecución realizada exitosamente";
            }


        }
        //VALIDO SI EXISTE LA SEGUNDA FILA CON DATOS
        if ($capacidad1 != 0 && $datastore1 != "null" ){

            foreach($datastore1 as $dtsseparado1){
                $cadenadts1 = explode(',',$dtsseparado1);
            }

            $datastoredef = $cadenadts1[0];
            $vmID = $vmID;
            $vcenter =  $vcenter;
            $capacidad =  $capacidad1;

            $log  = $this->getExternalToolLog('VmwareResourcesAdicionDiscos');
            $results = shell_exec("powershell.exe -executionpolicy bypass -NoProfile " . app_path() . "\scripts\SAN\R001-ExecutionScripts.ps1 -op 14 -params '-vmID $vmID -vcenter $vcenter -capacidad $capacidad -datastore *$datastoredef*'" . escapeshellarg($string));
            $results = json_decode($results,true);

            if($results['error'] != ""){
                $log->update([
                    'd_end_script' => date("Y-m-d H:i:s"),
                    'status' => 12,
                    'result' => 'Fallo en la ejecución del job',
                ]);
                return redirect()->route('virtualization.addHardDisk')->with('error', $results['error']);
            }else{
                $log->update([
                    'd_end_script' => date("Y-m-d H:i:s"),
                    'status' => 2,
                    'result' => 'Ejecución realizada exitosamente',
                ]);

                $id_asgard = $log->id;
                $idTemplate = "NULL";
                $history   = $this->gethistory($id_asgard,$case,0,$vmID  .  ' Tamaño aprovisionado:'.$capacidad,7,$idTemplate);
                $salida= "Ejecución realizada exitosamente";
            }


        }
        //VALIDO SI EXISTE LA TERCERA FILA CON DATOS
        if ($capacidad2 != 0 && $datastore2 != "null" ){

            foreach($datastore2 as $dtsseparado2){
                $cadenadts2 = explode(',',$dtsseparado2);
            }

            $datastoredef = $cadenadts2[0];
            $vmID = $vmID;
            $vcenter =  $vcenter;
            $capacidad =  $capacidad2;

            $log  = $this->getExternalToolLog('VmwareResourcesAdicionDiscos');
            $results = shell_exec("powershell.exe -executionpolicy bypass -NoProfile " . app_path() . "\scripts\SAN\R001-ExecutionScripts.ps1 -op 14 -params '-vmID $vmID -vcenter $vcenter -capacidad $capacidad -datastore *$datastoredef*'" . escapeshellarg($string));
            $results = json_decode($results,true);

            if($results['error'] != ""){
                $log->update([
                    'd_end_script' => date("Y-m-d H:i:s"),
                    'status' => 12,
                    'result' => 'Fallo en la ejecución del job',
                ]);
                return redirect()->route('virtualization.addHardDisk')->with('error', $results['error']);
            }else{
                $log->update([
                    'd_end_script' => date("Y-m-d H:i:s"),
                    'status' => 2,
                    'result' => 'Ejecución realizada exitosamente',
                ]);

                $id_asgard = $log->id;
                $idTemplate = "NULL";
                $history   = $this->gethistory($id_asgard,$case,0,$vmID  .  ' Tamaño aprovisionado:'.$capacidad,7,$idTemplate);
                $salida= "Ejecución realizada exitosamente";
            }


        }

        return redirect()->route('virtualization.addHardDisk')->with('success', $salida);

    }

	public function addHardDiskStore(Request $request)
    {
        $this->validate($request, [
            'vHost' => 'required',
            'case' => 'required'
        ]);

        //PREPARO LOS DATOS
            $vHosts = $request->vHost;
            $case = $request->case;
            $capacidad = $request->tamanoaprov;
            $datastore = $request->datastore;
            $capacidad1 = $request->tamanoaprov1;
            $datastore1 = $request->datastore1;
            $capacidad2 = $request->tamanoaprov2;
            $datastore2 = $request->datastore2;
            $user = Auth::user()->username;
            $hosts  = "";
            $i = 0;
            //Tratamiento del dato enviado por la vista separado por comas
            foreach($vHosts as $host){
                $cadena = explode(',',$host);
            }
            $vmID        = $cadena[0];
            $vcenter     = $cadena[1];
            $string      = "";
            $vacio = "";
        //FIN PREPARACIÓN DE DATOS

        //Obtengo datastre 1 fila
        if  ($datastore != "") {
            foreach($datastore as $dtsseparado){
                $cadenadts = explode(',',$dtsseparado);
            }
            $datastore = $cadenadts[0];
        }
        if  ($datastore1 != ""){
            //Obtengo datastre 2 fila
            foreach($datastore1 as $dtsseparado1){
                $cadenadts1 = explode(',',$dtsseparado1);
            }
            $datastore1 = $cadenadts1[0];
        }
        if  ($datastore1 != "") {
            //Obtengo datastre 3 fila
            foreach($datastore2 as $dtsseparado2){
                $cadenadts2 = explode(',',$dtsseparado2);
            }
            $datastore2 = $cadenadts2[0];
        }

        //Obtengo variables de salida al playbook
        if( ($capacidad != 0) && ($capacidad1 == 0) ){
            $datosAdicion = $capacidad."-".$datastore;
            $datosAdiciondts = $capacidad."-".$datastore."*".$vacio."-".$vacio."*".$vacio."-".$vacio;
        }
        if (($capacidad != 0) && ($capacidad1 != 0) && ($capacidad2 == 0)) {
            $datosAdicion = $capacidad."-".$datastore."*".$capacidad1."-".$datastore1;
            $datosAdiciondts = $capacidad."-".$datastore."*".$capacidad1."-".$datastore1."*".$vacio."-".$vacio;
        }
        if (($capacidad != 0) && ($capacidad1 != 0) && ($capacidad2 != 0)) {
            $datosAdicion = $capacidad."-".$datastore."*".$capacidad1."-".$datastore1."*".$capacidad2."-".$datastore2;
            $datosAdiciondts = $capacidad."-".$datastore."*".$capacidad1."-".$datastore1."*".$capacidad2."-".$datastore2;
        }
        if (($capacidad != 0) && ($capacidad1 == 0) && ($capacidad2 != 0)) {
            $datosAdicion = $capacidad."-".$datastore."*".$capacidad2."-".$datastore2;
            $datosAdiciondts = $capacidad."-".$datastore."*".$vacio."-".$vacio."*".$capacidad2."-".$datastore2;
        }

        //dd($datosAdicion);

        $idTemplate = 492;
        $log = $this->getLog(1,12,$idTemplate);
        $id_asgard = $log->id;
        $variables = array("extra_vars" => array("IDASGARD" => (string)$id_asgard,"VCENTER" => $vcenter,"VMID" => $vmID,"DATOSADICION" => $datosAdicion, "IDServiceManager" => $case, "USER" => $user));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        $resultado = $resultado['job'];

        //Si existe resultado registro en la tabla history
        if ($resultado){
            $datosv = explode('*',$datosAdiciondts);
            $v1 = "";
            $v2= "";
            $v3 = "";

            if ($datosv[0] != "-") {
                $v1 = explode('-',$datosv[0]);
                $tam1 = $v1[0];
            }
            if ($datosv[1] != "-") {
                $v2 = explode('-',$datosv[1]);
                $tam2 = $v2[0];
            }
            if ($datosv[2] != "-") {
                $v3 = explode('-',$datosv[2]);
                $tam3 = $v3[0];
            }

            if($v1 != ""){
                $history = $this->gethistory($id_asgard,$case,0,$vmID  .  ' Tamaño aprovisionado: '. $tam1,7,$idTemplate);
            }
            if($v2 != ""){
                $history = $this->gethistory($id_asgard,$case,0,$vmID  .  ' Tamaño aprovisionado: '. $tam2,7,$idTemplate);
            }
            if($v3 != ""){
                $history = $this->gethistory($id_asgard,$case,0,$vmID  .  ' Tamaño aprovisionado: '. $tam3,7,$idTemplate);
            }


        }
		$log->update([
                'id_job' => $resultado,
                'result' => $id_asgard.'_ADICIONDISCO.html',
        ]);

        return redirect()->route('executionLogs.show',$id_asgard);
    }
//-------------------------------------- FIN ADICION DE DISCOS --------------------------------------------------------

//-------------------------------------- CHECK PASO A OPERACION HOST IMPLEMENTACION --------------------------------------------------------
public function checkHostImple(Request $request)
{
    $view =  view('virtualizations.checkHostImple');
    if($request->ajax()){
        if ($request->has("cod")){
            $hosts = VmHost::where('name','like',"%$request->cod%")->get();
            //dd($hosts);
            $view = View::make('virtualizations.tableCheckHost',compact('hosts'));
            $sections = $view->renderSections();
            return response()->json($sections['contentPanel']);
        }
    }else return $view;
}
public function checkHostImpleStore(Request $request)
{
    $this->validate($request, [
        'vHost' => 'required',
    ]);
    $idTemplate = 503;
    $log = $this->getLog(1,12,$idTemplate);
    $id_asgard = $log->id;
    $vHosts = $request->vHost;
    $hosts = "";
    foreach($vHosts as $host){
        if ($host === end($vHosts)) {
            $hosts = $hosts.$host;
        }else{
            $hosts = $hosts.$host."*";
        }

    }
    $variables = array("extra_vars" => array("IDASGARD" => (string)$id_asgard, "VMIDS" => $hosts));
    $resultado = $this->runPlaybook($idTemplate,$variables);
    $resultado = $resultado['job'];
    $log->update([
        'id_job' => $resultado,
        'result' => $id_asgard.'_CHECK_VMCLUSTER.html',
    ]);
    return redirect()->route('executionLogs.show',$id_asgard);
}
//-------------------------------------- FIN CHECK PASO A OPERACION HOST IMPLEMENTACION --------------------------------------------------------

}
