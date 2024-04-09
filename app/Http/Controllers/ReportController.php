<?php

namespace App\Http\Controllers;

use App\User;
use App\RegQuarter;
use App\ExecutionLog;
use App\RegImprovement;
use App\RegServiceLayer;
use App\RegServiceSegment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Traits\ImprovementProgressTrait;
use App\Vcenter;
use App\Datacenter;
use App\Segment;
use App\Cluster;
use App\ClusterDatastore;
use App\Vmhostr;
use App\Http\Repositories\VirtualizacionRty;
use App\Vm;
use DB;

class ReportController extends Controller
{
    use ImprovementProgressTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function getlayers($id)
    {
        $layers = RegServiceLayer::where('segment_id', $id)->get(['id','name']);
        return $layers;
    }
    public function automation()
    {
        return view('reports.automation');
    }
    public function rdr()
    {
        $segments = RegServiceSegment::orderBy('name')->get(['id','name']);
        $terms = RegQuarter::orderBy('start_date')->get(['id','name']);
        return view('reports.rdr',compact('terms','segments'));
    }
    public function getRdrReport(Request $request){
        if($request->input('report') == 1){
            $error = 0;
            $message = array();
            if($request->input('segment') == 0){
                $segment = '!=';
            }else{
                $segment = '=';
            }
            if($request->input('layer') == 0){
                $layer = '!=';
            }else{
                $layer = '=';
            }
            if($request->input('term') == '0'){
                $start = $request->input('d_start');
                $end = $request->input('d_end');
            }elseif($request->input('term') == 'all'){
                $start = '2019-01-01';
                $end = date('Y-m-d');
            }
            //$terms = RegQuarter::whereBetween('start_date',[$request->input('d_start'),$request->input('d_end')])->get('id');
            //dd($start .'      '.$end);
            $totalImp = RegImprovement::where('segment_id',$segment,$request->input('segment'))->where('layer_id',$layer,$request->input('layer'))
                ->whereBetween('end_date',[$start, $end])->count();
            $totalTimeB = RegImprovement::where('segment_id',$segment,$request->input('segment'))->where('layer_id',$layer,$request->input('layer'))
                ->whereBetween('end_date',[$start, $end])->sum('minutes_before');
            $totalTimeA = RegImprovement::where('segment_id',$segment,$request->input('segment'))->where('layer_id',$layer,$request->input('layer'))
                ->whereBetween('end_date',[$start, $end])->sum('minutes_after');
            $totalTimeO = RegImprovement::where('segment_id',$segment,$request->input('segment'))->where('layer_id',$layer,$request->input('layer'))
                ->whereBetween('end_date',[$start, $end])->sum('minutes_total');
            $improvements = RegImprovement::where('segment_id',$segment,$request->input('segment'))->where('layer_id',$layer,$request->input('layer'))
                ->whereBetween('end_date',[$start, $end])->get();
            $totalTimeB = number_format($totalTimeB,0,'','.');
            $totalTimeA = number_format($totalTimeA,0,'','.');
            $totalTimeO = number_format($totalTimeO,0,'','.');
            foreach ($improvements as $improvement){
                $progress = $this->getProgress($improvement);
            }
            $improvements = RegImprovement::where('segment_id',$segment,$request->input('segment'))->where('layer_id',$layer,$request->input('layer'))
                ->whereBetween('end_date',[$start, $end])->get();
            $totalImpFinish = RegImprovement::where('segment_id',$segment,$request->input('segment'))->where('layer_id',$layer,$request->input('layer'))
                ->whereBetween('end_date',[$start, $end])->where('total_progress',100)->count();
            //dd($improvements);
            $view = View::make('reports.rdrReport1', compact('improvements','error','message','totalImp','totalTimeB','totalTimeA','totalTimeO','totalImpFinish'));
            $sections = $view->renderSections();
            return response()->json($sections['contentPanel']);
        }
    }
    public function taskLogs()
    {
        $playbooks = ExecutionLog::select('playbook')->distinct()->orderBy('playbook')->get();
        $groups = ExecutionLog::select('user_group')->distinct()->orderBy('user_group')->get();
        $users  = User::orderBy('name')->get(['name', 'username']);
        return view('reports.taskLogs',compact('playbooks','groups','users'));
    }
    public function getTaskLogsReport(Request $request){

        $error = 0;
        $message = array();
        if($request->input('playbook') == '0'){
            $playbook = '!=';
        }else{
            $playbook = '=';
        }
        //dd($request->input('group'));
        if($request->input('group') == '0'){
            $group = '!=';
        }else{
            $group = '=';
        }
        if($request->input('user') == '0'){
            $user = '!=';
        }else{
            $user = '=';
        }
        if($request->input('term') == '0'){
            $start = $request->input('d_start');
            $end = $request->input('d_end');
        }elseif($request->input('term') == 'all'){
            $start = '2019-01-01';
            $end = date('Y-m-d');
        }
        $tasks = ExecutionLog::where('playbook',$playbook,$request->input('playbook'))->where('user_group',$group,$request->input('group'))
            ->where('user',$user,$request->input('user'))->whereBetween('created_at',[$start, $end])
            ->get(['id_job', 'playbook', 'user','user_group','status','created_at', 'd_ini_script', 'd_end_script']);
        //dd($improvements);
        $view = View::make('reports.taskLogsReport', compact('tasks'));
        $sections = $view->renderSections();
        return response()->json($sections['contentPanel']);
    }

     //DASHBOARD VIRTUALIZACION

     public function getReportsVirtualization()
     {
         $vcenters   = Vcenter::count();
         $datacenter = Datacenter::count();
         //$totales = vw_virtualizacion::count();
         //$dateHrs = date('d-m-Y');
          // variable para llamar a la clase de repositorio de consultas
          $virtualizacionRty = new VirtualizacionRty;
 
         $UpdateDate = $virtualizacionRty->UpdateDate(); 
 
         return view('reports.chartsVirtualizations',compact('vcenters', 'datacenter', 'UpdateDate'));
     }
 
     public function getRepFilterVirtualization()
     {
         $segments = Segment::orderBy('segmentName')->get(['segmentID','segmentName']);
 
         return view('reports.reportVirtualization',compact('segments'));
     }
 
     public function getVcenter($id)
     {
         $vcenters = Vcenter::where('fk_segmentID', $id)->get(['vcenterID','vcenterAlias']);         
         return $vcenters;
     }
 
     public function getDatacenter($id)
     {   
         $datacenter = Datacenter::where('fk_vcenterID', $id)->get(['datacenterID','datacenterName']);   
         return $datacenter;
     }
 
     public function getCluster($id)
     {   
         $cluster = Cluster::where('fk_datacenterID', $id)->get(['clusterID','clusterName']);      
 
         return $cluster;
     }
 
     public function getdatastore($id)
     {   
         $datastore = ClusterDatastore::where('fk_clusterID', $id)->get(['datastoreID','datastoreName']);      
         return $datastore;
     }
 
     public function getvmhost($id)
     {   
         $Vmhost = Vmhostr::where('fk_clusterID', $id)->get(['vmhostID','vmhostName']);      
         return $Vmhost;
     }
 
     public function getvm($id)
     {   
         $vm = Vm::where('fk_vmhostID', $id)->get(['vmID','vmName']);  
        
         return $vm;
     }
 
 
     public function getGenerateReportVirt(Request $request){      
 
         if($request->input('report') == 1){
             $error = 0;
             $message = array();
             if($request->input('segment') == 0){
                 $segment = '!=';
             }else{
                 $segment = '=';
             }
             if($request->input('layer') == 0){
                 $layer = '!=';
             }else{
                 $layer = '=';
             }
             if($request->input('datacenter') == 0){ 
                 $datacenter = '!=';
             }else{ 
                 $datacenter = '=';
             }
             if($request->input('cluster') == 0){
                 $cluster = '!=';
             }else{
                 $cluster = '=';
             }   
             if($request->input('datastore') == 0){
                 $datastore = '!=';
             }else{
                 $datastore = '=';
             }
             if($request->input('vmhost') == 0){
                 $vmhost = '!=';
             }else{
                 $vmhost = '=';
             }
             if($request->input('vm') == 0){
                 $vm = '!=';
             }else{
                 $vm = '=';
             }    
             if($request->input('term') == '0'){
                 $start = $request->input('d_start');
                 $end = $request->input('d_end');
             }elseif($request->input('term') == 'all'){
                 $start = '2019-01-01';
                 $end = date('Y-m-d');
             }
              //MUESTRO INFORMACION SI SELECCIONO DATASTORE O VMHOST
             $selec = $request->input('seleccion');
 
             // variable para llamar a la clase de repositorio de consultas
             $virtualizacionRty = new VirtualizacionRty;
 
             $UpdateDate = $virtualizacionRty->UpdateDate(); 
            
              //INFORMACION VCENTER
             if ($segment == "=" && $layer == "!=" && $datacenter == "!="  && $cluster == "!=" && $datastore == "!=" && $vmhost == "!=" && $vm == "!=" ){ 
                 $fields = "v.vcenterAlias,v.vcenterIp,v.vcenterStatus";
                 $tables = 'central.segment s, central.vcenter v';
                 $where = "s.segmentID = v.fk_segmentID and segmentID = ".$request->input('segment');
 
                 //Total vcenter por segmento 
                 $totalVcenterXSegmento = Vcenter::where('fk_segmentID',$segment,$request->input('segment'))->count(); 
                 //Total vcenter por segmento encendidos
                 $totalVcenterOn = Vcenter::where('fk_segmentID',$segment,$request->input('segment'))
                 ->where("vcenterStatus","=",1)
                 ->count(); 
                 //Total vcenter por segmento encendidos
                 $totalVcenterOff = Vcenter::where('fk_segmentID',$segment,$request->input('segment'))
                 ->where("vcenterStatus","=",0)
                 ->count();           
             }
             //INFORMACION DATACENTER
             if ($segment == "=" && $layer == "=" && $datacenter == "!="  && $cluster == "!=" && $datastore == "!=" && $vmhost == "!=" && $vm == "!="){ 
                 $fields = "d.datacenterName,d.datacenterCluster,d.datacenterCluster,d.datacenterHost,d.datacenterVm,d.datacenterNetwork,d.datacenterDatastore";
                 $tables = 'central.segment s, central.vcenter v, central.datacenter d';
                 $where = 's.segmentID = v.fk_segmentID and d.fk_vcenterID = v.vcenterID and segmentID ='. $request->input('segment').' and v.vcenterID ='.$request->input('layer');
                //Total datacenter  
                $totalDatacenter = Segment ::join("vcenter","vcenter.fk_segmentID","=","segment.segmentID")
                ->join("datacenter","datacenter.fk_vcenterID", "=", "vcenter.vcenterID")
                ->where('fk_segmentID',$segment,$request->input('segment'))
                ->where('vcenterID',$layer,$request->input('layer'))
                ->count();                
             }
             //INFORMACION CLUSTER
             if ($segment == "=" && $layer == "=" && $datacenter == "=" && $cluster == "!=" && $datastore == "!=" && $vmhost == "!=" && $vm == "!=" && $selec != "0" && $selec != "1"){ 
                 $fields = "clusterName,clusterNumCpuCores,clusterTotalCpuGhz,clusterTotalMemoryGb,clusterTotalStorageGb,clusterStorageUsedGb,clusterTotalVm,clusterHAEnabled,clusterDrsEnabled";
                 $tables = 'central.segment s, central.vcenter v, central.datacenter d,central.cluster c';
                 $where = 's.segmentID = v.fk_segmentID and d.fk_vcenterID = v.vcenterID and c.fk_datacenterID = d.datacenterID and segmentID ='. $request->input('segment').' and v.vcenterID = '. $request->input('layer').' and d.datacenterID = '. $request->input('datacenter');
              
                 //Total cluster  
                 $totalCluster = Segment ::join("vcenter","vcenter.fk_segmentID","=","segment.segmentID")
                                         ->join("datacenter","datacenter.fk_vcenterID", "=", "vcenter.vcenterID")
                                         ->join("cluster","cluster.fk_datacenterID", "=", "datacenter.datacenterID")
                                         ->where('fk_segmentID',$segment,$request->input('segment'))
                                         ->where('vcenterID',$layer,$request->input('layer'))
                                         ->where('datacenterID',$datacenter,$request->input('datacenter'))
                                         ->count();  
 
               
                 $clusterHa = $virtualizacionRty->porcentajeClusterHA(                                        
                     $request->input('segment'),
                     $request->input('layer'),                                            
                     $request->input('datacenter')
                 );           
               
                 $arrayEnable = [];
                 $datacenterName = $clusterHa[0]->datacenterName;  
 
                 foreach ($clusterHa as $dato){
                     $enabled = $dato->clusterHAEnabled; 
                     if ( $enabled == 1){
                         $porcOperativo   =  (int) $dato->porcentaje; 
                     }else{
                         $porcInoperativo =  (int) $dato->porcentaje; 
                     }
                     array_push($arrayEnable,$enabled);                   
                 }
                 
                 $sqlDrs = "SELECT  c.clusterName,d.datacenterName ,c.clusterHAEnabled , 
                                 (Count(c.clusterHAEnabled)* 100 / (Select Count(*) FROM central.segment s, central.vcenter v, 
                                 central.datacenter d,central.cluster c 
                                 WHERE s.segmentID = v.fk_segmentID 
                                 and d.fk_vcenterID = v.vcenterID 
                                 and c.fk_datacenterID = d.datacenterID 
                                 and segmentID = ".$request->input('segment')." 
                                 and v.vcenterID = ".$request->input('layer')."
                                 and d.datacenterID = ".$request->input('datacenter')."	)) as porcentaje
                             FROM central.segment s, central.vcenter v, 
                             central.datacenter d,central.cluster c 
                             WHERE s.segmentID = v.fk_segmentID 
                             and d.fk_vcenterID = v.vcenterID 
                             and c.fk_datacenterID = d.datacenterID 
                             and segmentID =".$request->input('segment')." 
                             and v.vcenterID = ".$request->input('layer')."
                             and d.datacenterID = ".$request->input('datacenter')."	
                             Group By c.clusterName,d.datacenterName ,c.clusterHAEnabled";
 
                 $clusterDrs   = DB::select($sqlDrs);   
                
                 $arrayDrs = [];
                 $datacenterNameDrs =  $clusterDrs[0]->datacenterName;           
 
                 foreach ($clusterDrs as $dato){
                     $drs = $dato->clusterHAEnabled; 
                     if ( $drs == 1){
                         $porcOperativoDrs   =  (int) $dato->porcentaje; 
                     }else{
                         $porcInoperativoDrs =  (int) $dato->porcentaje; 
                     }
                     array_push($arrayDrs,$drs);                   
                 }
                
               //Se obtiene el total de Memoria
                $sqlTotMemCluster  = "SELECT sum(c.clusterTotalMemoryGb) as TotMemRam
                                         FROM central.segment s, central.vcenter v,central.datacenter d,central.cluster c 
                                         WHERE s.segmentID = v.fk_segmentID 
                                         and d.fk_vcenterID = v.vcenterID 
                                         and c.fk_datacenterID = d.datacenterID 
                                         and segmentID =".$request->input('segment')." 
                                         and v.vcenterID = ".$request->input('layer')."
                                         and d.datacenterID = ".$request->input('datacenter').""	;	
  
                 $TotMemCluster   = DB::select($sqlTotMemCluster);
 
                //Se obtiene el total de Memoria, Cpu, Storage, TotalVm
                $sqlTotRecursos  = "SELECT sum(c.clusterTotalMemoryGb) as TotMemRam, 
                                             sum(c.clusterTotalCpuGhz) as TotalCpu,
                                             sum(c.clusterTotalStorageGb) as Storage,
                                             sum(c.clusterTotalVm) as TotalVm     
                                     FROM central.segment s, 
                                          central.vcenter v,
                                          central.datacenter d,
                                          central.cluster c 
                                     WHERE s.segmentID = v.fk_segmentID 
                                     and d.fk_vcenterID = v.vcenterID 
                                     and c.fk_datacenterID = d.datacenterID 
                                     and segmentID =".$request->input('segment')." 
                                     and v.vcenterID = ".$request->input('layer')."
                                     and d.datacenterID = ".$request->input('datacenter').""	;	
 
                 $TotRecursos   = DB::select($sqlTotRecursos);
 
              
                 //Se obtiene Storage usado y total
                 $sqlStorageCluster  = "SELECT c.clusterName, clusterTotalStorageGb, c.clusterStorageUsedGb
                                         FROM central.segment s, central.vcenter v, 
                                         central.datacenter d,central.cluster c 
                                         WHERE s.segmentID = v.fk_segmentID 
                                         and d.fk_vcenterID = v.vcenterID 
                                         and c.fk_datacenterID = d.datacenterID 
                                         and segmentID =".$request->input('segment')." 
                                         and v.vcenterID = ".$request->input('layer')."
                                         and d.datacenterID = ".$request->input('datacenter')."
                                         and d.datacenterDeleted is null
                                         and c.clusterDeleted is null";            
 
                 $StorageCluster = DB::select($sqlStorageCluster);
 
 
               
                
             }     
 
             //INFORMACION DATASTORE
             if ($selec == 0 && $segment == "=" && $layer == "=" && $datacenter == "="  && $cluster == "=" && $datastore == "!=" && $vmhost == "!=" && $vm == "!="){ 
                 $fields = "datastoreID,datastoreName,datastoreState,datastoreNaa,datastoreCapacityGB,datastoreUsedGB,datastoreProvisionedGB,datastoreFreeSpaceGB,datastoreType,datastoreVersion,datastoreHostCount,datastoreVmCount,datastoreCreatedAt, datastoreUpdatedAt, datastoreDeleted";
                 $tables = 'central.segment s, central.vcenter v, central.datacenter d,central.cluster c, central.datastore d2';
                 $where = 's.segmentID = v.fk_segmentID and d.fk_vcenterID = v.vcenterID and c.fk_datacenterID = d.datacenterID and d2.fk_clusterID  = c.clusterID and segmentID ='. $request->input('segment').' and v.vcenterID = '. $request->input('layer').' and d.datacenterID = '. $request->input('datacenter').' and c.clusterID ='. $request->input('cluster');
             
                  //Total Datastore  
                   $totalDatastore = Segment ::join("vcenter","vcenter.fk_segmentID","=","segment.segmentID")
                  ->join("datacenter","datacenter.fk_vcenterID", "=", "vcenter.vcenterID")
                  ->join("cluster","cluster.fk_datacenterID", "=", "datacenter.datacenterID")               
                  ->join("datastore","datastore.fk_clusterID", "=", "cluster.clusterID") 
                  ->where('fk_segmentID',$segment,$request->input('segment'))
                  ->where('vcenterID',$layer,$request->input('layer'))
                  ->where('datacenterID',$datacenter,$request->input('datacenter'))
                  ->where('clusterID',$cluster,$request->input('cluster')) 
                  ->count();
 
                 //Obtengo la informacion del total disponible y no disponible del dataStore
                  $dataStoreState = $virtualizacionRty->DataStoreState(                                        
                     $request->input('segment'),
                     $request->input('layer'),                                            
                     $request->input('datacenter'),
                     $request->input('cluster')
                 );  
 
                 $arrayStateDts = [];                    
                 $stateAvailable = 0;
                 $stateUnavailable = 0;
 
                 foreach ($dataStoreState as $dato){
                     $state = $dato->datastoreState; 
                     if ( $state == "Available"){ 
                         $stateAvailable   =    (int)$dato->cantidadState;                    
                     }else{ 
                         $stateUnavailable   =  (int) $dato->cantidadState; 
                     }                
                    array_push($arrayStateDts,$state);                   
                 }                
                 
                 //Obtengo la informacion de versiones por datastore
                 $DataStoreVersion = $virtualizacionRty->DataStoreVersion(                                        
                     $request->input('segment'),
                     $request->input('layer'),                                            
                     $request->input('datacenter'),
                     $request->input('cluster')
                 ); 
                 
                 //Obtengo sumatorias totales para las tarjetas
                 $DataStoreTotales = $virtualizacionRty->DataStoreTotales(                                        
                     $request->input('segment'),
                     $request->input('layer'),                                            
                     $request->input('datacenter'),
                     $request->input('cluster')
                 );  
                
             } 
             //INFORMACION VMHOST
             if ($selec == 1 && $segment == "=" && $layer == "=" && $datacenter == "="  && $cluster == "=" && $datastore == "!=" && $vmhost == "!=" && $vm == "!=") 
             {
                 $fields = "vmhostID, v2.fk_clusterID, vmhostObjectID, vmhostName, vmhostUptime, vmhostVmCount, vmhostTotalMemoryGb, vmhostMemoryUsageGB, vmhostTotalCpuGhz, vmhostCpuUsageGhz, vmhostTotalStorageGb, vmhostStorageUsageGb, vmhostEsxiVersion, vmhostEsxiBuild, vmhostIp, vmhostManagementServerIp, vmhostConnectionState, vmhostPowerState, vmhostVendor, vmhostCreatedAt, vmhostUpdatedAt, vmhostDeleted";
                 $tables = 'central.segment s, central.vcenter v, central.datacenter d,central.cluster c, central.vmhost v2';
                 $where = 's.segmentID = v.fk_segmentID and d.fk_vcenterID = v.vcenterID and c.fk_datacenterID = d.datacenterID and v2.fk_clusterID = c.clusterID and segmentID ='. $request->input('segment').' and v.vcenterID = '. $request->input('layer').' and d.datacenterID = '. $request->input('datacenter').' and c.clusterID ='. $request->input('cluster');
             
                 //Total Vmhost  
                 $totalVmhost = Segment ::join("vcenter","vcenter.fk_segmentID","=","segment.segmentID")
                 ->join("datacenter","datacenter.fk_vcenterID", "=", "vcenter.vcenterID")
                 ->join("cluster","cluster.fk_datacenterID", "=", "datacenter.datacenterID")               
                 ->join("vmhost","vmhost.fk_clusterID", "=", "cluster.clusterID") 
                 ->where('fk_segmentID',$segment,$request->input('segment'))
                 ->where('vcenterID',$layer,$request->input('layer'))
                 ->where('datacenterID',$datacenter,$request->input('datacenter'))
                 ->where('clusterID',$cluster,$request->input('cluster')) 
                 ->count();
 
                 
                   //Obtengo info uptime
                   $vmhostUptime = $virtualizacionRty->vmhostUptime(                                        
                     $request->input('segment'),
                     $request->input('layer'),                                            
                     $request->input('datacenter'),
                     $request->input('cluster')
                 );              
               
                 
                 //Obtengo sumatorias totales para las tarjetas
                 $vmhostTotales = $virtualizacionRty->vmhostTotales(                                        
                     $request->input('segment'),
                     $request->input('layer'),                                            
                     $request->input('datacenter'),
                     $request->input('cluster')
                 ); 
 
                 //Obtengo info de Storage Total y usuado
                 $vmhostStorage = $virtualizacionRty->vmhostStorage(                                        
                     $request->input('segment'),
                     $request->input('layer'),                                            
                     $request->input('datacenter'),
                     $request->input('cluster')
                 ); 
 
                 //Obtengo info Vers.ESXi
                 $vmhostVerEsxi = $virtualizacionRty->vmhostVerEsxi(                                        
                     $request->input('segment'),
                     $request->input('layer'),                                            
                     $request->input('datacenter'),
                     $request->input('cluster')
                 );
 
                 //Obtengo info Connected/PowerState
                 $vmhostConnected = $virtualizacionRty->vmhostConnected(                                        
                     $request->input('segment'),
                     $request->input('layer'),                                            
                     $request->input('datacenter'),
                     $request->input('cluster')
                 ); 
 
                 //Obtengo info Fabricante
                 $vmhostVendor = $virtualizacionRty->vmhostVendor(                                        
                     $request->input('segment'),
                     $request->input('layer'),                                            
                     $request->input('datacenter'),
                     $request->input('cluster')
                 );               
 
             }
             //INFORMACION VM
             if ($selec == 1 && $segment == "=" && $layer == "=" && $datacenter == "=" && $cluster == "=" && $vmhost == "=" && $vm == "!="){ 
                
                 $fields = "vmID, vmObjectID, fk_vmhostID, vmName, vmPowerState, vmMemoryGB, vmCpuCount, vmResourcePool, vmHotAddMemory, vmHotAddCpu, vmHardwareVersion, vmProvisionedSpaceGB, vmUsedSpaceGB, vmGuestFamily, vmGuestFullName, vmToolsStatus, vmToolsRunningStatus, v3.vmHostName, vmIpAddress, vmCreatedAt, vmUpdatedAt, vmDeleted";
                 $tables = 'central.segment s, central.vcenter v, central.datacenter d,central.cluster c, central.vmhost v2, central.vm v3';
                 $where = 's.segmentID = v.fk_segmentID and d.fk_vcenterID = v.vcenterID and c.fk_datacenterID = d.datacenterID and v2.fk_clusterID = c.clusterID  and v3.fk_vmhostID = v2.vmhostID  and segmentID ='. $request->input('segment').' and v.vcenterID = '. $request->input('layer').' and d.datacenterID = '. $request->input('datacenter').' and c.clusterID ='. $request->input('cluster').' and v2.vmhostID = '.$request->input('vmhost');
 
                 $totalVm = Segment ::join("vcenter","vcenter.fk_segmentID","=","segment.segmentID")
                 ->join("datacenter","datacenter.fk_vcenterID", "=", "vcenter.vcenterID")
                 ->join("cluster","cluster.fk_datacenterID", "=", "datacenter.datacenterID")               
                 ->join("vmhost","vmhost.fk_clusterID", "=", "cluster.clusterID")
                 ->join("vm","vm.fk_vmhostID", "=", "vmhost.vmhostID") 
                 ->where('fk_segmentID',$segment,$request->input('segment'))
                 ->where('vcenterID',$layer,$request->input('layer'))
                 ->where('datacenterID',$datacenter,$request->input('datacenter'))
                 ->where('clusterID',$cluster,$request->input('cluster'))
                 ->where('vmhostID',$vmhost,$request->input('vmhost')) 
                 ->count();
 
                 $sqlVmToolsOn = "SELECT count(*)  as cantidad
                                 FROM central.segment s, central.vcenter v, central.datacenter d,central.cluster c, 
                                 central.vmhost v2, central.vm v3 
                                 WHERE s.segmentID = v.fk_segmentID 
                                 and d.fk_vcenterID = v.vcenterID 
                                 and c.fk_datacenterID = d.datacenterID 
                                 and v2.fk_clusterID = c.clusterID  
                                 and v3.fk_vmhostID = v2.vmhostID  
                                 and segmentID =".$request->input('segment')." 
                                 and v.vcenterID = ".$request->input('layer')." 
                                 and d.datacenterID = ".$request->input('datacenter')." 
                                 and c.clusterID =".$request->input('cluster')." 
                                 and v2.vmhostID = ".$request->input('vmhost')."
                                 and v3.vmToolsRunningStatus= 'guestToolsRunning'";
 
                 $VmToolsOn   = DB::select($sqlVmToolsOn);   
 
                 $sqlVmToolsOff = "SELECT count(*) as cantidad
                                 FROM central.segment s, central.vcenter v, central.datacenter d,central.cluster c, 
                                 central.vmhost v2, central.vm v3 
                                 WHERE s.segmentID = v.fk_segmentID 
                                 and d.fk_vcenterID = v.vcenterID 
                                 and c.fk_datacenterID = d.datacenterID 
                                 and v2.fk_clusterID = c.clusterID  
                                 and v3.fk_vmhostID = v2.vmhostID  
                                 and segmentID =".$request->input('segment')." 
                                 and v.vcenterID = ".$request->input('layer')." 
                                 and d.datacenterID = ".$request->input('datacenter')." 
                                 and c.clusterID =".$request->input('cluster')." 
                                 and v2.vmhostID = ".$request->input('vmhost')."
                                 and v3.vmToolsRunningStatus= 'guestToolsNotRunning'";
                 
                 $VmToolsOff = DB::select($sqlVmToolsOff);
                 $VmToolsOff = $VmToolsOff[0]->cantidad;
                 $VmToolsOn  = $VmToolsOn[0]->cantidad;
 
                 $sqlVmencendidas = "SELECT count(*) as cant_vm
                                     FROM central.segment s, central.vcenter v, central.datacenter d,central.cluster c, 
                                     central.vmhost v2, central.vm v3 
                                     WHERE s.segmentID = v.fk_segmentID 
                                     and d.fk_vcenterID = v.vcenterID 
                                     and c.fk_datacenterID = d.datacenterID 
                                     and v2.fk_clusterID = c.clusterID  
                                     and v3.fk_vmhostID = v2.vmhostID  
                                     and segmentID =".$request->input('segment')." 
                                     and v.vcenterID = ".$request->input('layer')." 
                                     and d.datacenterID = ".$request->input('datacenter')." 
                                     and c.clusterID =".$request->input('cluster')." 
                                     and v2.vmhostID = ".$request->input('vmhost')."
                                     and v3.vmPowerState= 'PoweredOn'";
 
                 $VmOn = DB::select($sqlVmencendidas);
                 $VmOn = $VmOn[0]->cant_vm;
 
                 $sqlVmapagadas = "SELECT count(*) as cant_vm
                 FROM central.segment s, central.vcenter v, central.datacenter d,central.cluster c, 
                 central.vmhost v2, central.vm v3 
                 WHERE s.segmentID = v.fk_segmentID 
                 and d.fk_vcenterID = v.vcenterID 
                 and c.fk_datacenterID = d.datacenterID 
                 and v2.fk_clusterID = c.clusterID  
                 and v3.fk_vmhostID = v2.vmhostID  
                 and segmentID =".$request->input('segment')." 
                 and v.vcenterID = ".$request->input('layer')." 
                 and d.datacenterID = ".$request->input('datacenter')." 
                 and c.clusterID =".$request->input('cluster')." 
                 and v2.vmhostID = ".$request->input('vmhost')."
                 and v3.vmPowerState= 'PoweredOff'";
 
                 $Vmoff = DB::select($sqlVmapagadas);
                 $Vmoff = $Vmoff[0]->cant_vm;  
                 
                 
                 //Obtengo info de versiones
                 $VmVersion = $virtualizacionRty->VmVersion(                                        
                     $request->input('segment'),
                     $request->input('layer'),                                            
                     $request->input('datacenter'),
                     $request->input('cluster'),
                     $request->input('vmhost')
                 );  
 
                  //Obtengo info de VmGuestFamily
                  $VmGuestFamily = $virtualizacionRty->VmGuestFamily(                                        
                     $request->input('segment'),
                     $request->input('layer'),                                            
                     $request->input('datacenter'),
                     $request->input('cluster'),
                     $request->input('vmhost')
                 );  
 
                  //Obtengo info de VmHot
                  $VmHot = $virtualizacionRty->VmHot(                                        
                     $request->input('segment'),
                     $request->input('layer'),                                            
                     $request->input('datacenter'),
                     $request->input('cluster'),
                     $request->input('vmhost')
                 ); 
                 
                   //Obtengo info de VmTotales
                   $VmTotales = $virtualizacionRty->VmTotales(                                        
                     $request->input('segment'),
                     $request->input('layer'),                                            
                     $request->input('datacenter'),
                     $request->input('cluster'),
                     $request->input('vmhost')
                 );
 
                
             }
             
             //EJECUCIÓN DE LAS CONSULTAS SEGUN REPORTE SOLICITADO (FILTRO)
             $super = 'SELECT '.$fields.' FROM '.$tables.' WHERE '. $where;
             $datos =  DB::select($super);
                                         
             if ($segment == "=" && $layer == "!=" && $datacenter == "!="  && $cluster == "!=" && $datastore == "!=" && $vmhost == "!=" && $vm == "!="){ 
                 $view = View::make('reports.reportVirtualization1', compact('datos','totalVcenterXSegmento','totalVcenterOn','totalVcenterOff'));
             }
             if ($segment == "=" && $layer == "=" && $datacenter == "!="  && $cluster == "!=" && $datastore == "!=" && $vmhost == "!=" && $vm == "!="){ 
                 $view = View::make('reports.reportDatacenter', compact('datos','totalDatacenter'));
             }
             if ($segment == "=" && $layer == "=" && $datacenter == "=" && $cluster == "!=" && $datastore == "!=" && $vmhost == "!=" && $vm == "!="){ 
                 $view = View::make('reports.reportCluster', compact('datos','totalCluster','porcOperativo','porcInoperativo','porcOperativoDrs','porcInoperativoDrs','datacenterName','datacenterNameDrs','TotRecursos', 'StorageCluster','UpdateDate'));
             }
             if ($selec == 0 && $segment == "=" && $layer == "=" && $datacenter == "="  && $cluster == "=" && $datastore == "!=" && $vmhost == "!=" && $vm == "!="){
             $view = View::make('reports.reportDatastore', compact('datos','totalDatastore','UpdateDate','stateAvailable','stateUnavailable','dataStoreState','DataStoreVersion','DataStoreTotales'));
             }
             if ($selec == 1 && $segment == "=" && $layer == "=" && $datacenter == "="  && $cluster == "=" && $datastore == "!=" && $vmhost == "!=" && $vm == "!="){
                 $view = View::make('reports.reportvmhost', compact('datos','totalVmhost','vmhostTotales','vmhostStorage','vmhostVerEsxi','vmhostConnected','vmhostVendor','vmhostUptime','UpdateDate'));
             } 
             if ($selec == 1 && $segment == "=" && $layer == "=" && $datacenter == "="  && $cluster == "=" && $datastore == "!=" && $vmhost == "=" && $vm == "!="){ 
                 $view = View::make('reports.reportVm', compact('datos','totalVm','VmToolsOff','VmToolsOn', 'Vmoff', 'VmOn','VmVersion','VmGuestFamily','VmHot','VmTotales','UpdateDate'));
             }        
             
             //CARGO VISTA EN EL FORMULARIO PRINCIPAL
             $sections = $view->renderSections();
             return response()->json($sections['contentPanel']);
         }
     }
 
     public function getRepGralVirtualization()
     {
 
            
          // variable para llamar a la clase de repositorio de consultas
          $virtualizacionRty = new VirtualizacionRty;
          $UpdateDate = $virtualizacionRty->UpdateDate(); 
 
             //Obtengo cant total hostFisicos entre todos los segmentos
            $cantTotalHost = $virtualizacionRty->cantTotalHost();        
            //Obtengo porcentaje por segemento hostFisicos
            $porcxsegHost = $virtualizacionRty->porcxsegHost();
 
             //Obtengo cant total clusters entre todos los segmentos
              $cantTotalCluster = $virtualizacionRty->cantTotalCluster();
             // //Obtengo porcentaje por segemento clusters
             $porcxsegCluster = $virtualizacionRty->porcxsegCluster();
 
             //Obtengo cant total VMs entre todos los segmentos
             $cantTotalvms = $virtualizacionRty->cantTotalvms();
             // //Obtengo porcentaje por segemento clusters
             $porcxsegVms = $virtualizacionRty->porcxsegVms();
 
             // //Obtengo cant total Dts entre todos los segmentos
             $cantTotalDts = $virtualizacionRty->cantTotalDts();
            
             // //Obtengo porcentaje por segemento clusters
             $porcxsegDts = $virtualizacionRty->porcxsegDts();
 
             // //Obtengo cant total Vms entre todos los segmentos ON
             $cantTotalVmsOn = $virtualizacionRty->cantTotalVmsOn();
           
             // //Obtengo porcentaje por segemento clusters
             $porcxsegVmsOn = $virtualizacionRty->porcxsegVmsOn();
 
             // //Obtengo cant total Vms entre todos los segmentos OFF
             $cantTotalVmsOff = $virtualizacionRty->cantTotalVmsOff();
 
             // //Obtengo porcentaje por segemento clusters
             $porcxsegVmsOff = $virtualizacionRty->porcxsegVmsOff();
 
             $view = View::make('reports.chartsVirtualizations', 
                       compact('cantTotalHost',                            
                             'porcxsegHost',
                             'cantTotalCluster',                           
                             'porcxsegCluster',
                             'cantTotalvms',                           
                             'porcxsegVms',
                             'cantTotalDts',                           
                             'porcxsegDts',
                             'cantTotalVmsOn',                           
                             'porcxsegVmsOn',
                             'cantTotalVmsOff',                          
                             'porcxsegVmsOff',
                             'UpdateDate')
         );
         $sections = $view->renderSections();
         return response()->json($sections['contentPanel']);
     }
 
     // FIN DASHBOARD VIRTUALIZACION

}
