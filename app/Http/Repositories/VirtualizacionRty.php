<?php
namespace App\Http\Repositories;
use DB;
class VirtualizacionRty {

    public function porcentajeClusterHA($segment,$layer,$datacenter){       
     
        $sql = "SELECT  c.clusterName,d.datacenterName,c.clusterHAEnabled , 
                        (Count(c.clusterHAEnabled)* 100 / 
                                (Select Count(*) FROM central.segment s, central.vcenter v, 
                                central.datacenter d,central.cluster c 
                                WHERE s.segmentID = v.fk_segmentID 
                                and d.fk_vcenterID = v.vcenterID 
                                and c.fk_datacenterID = d.datacenterID 
                                and segmentID = ? 
                                and v.vcenterID = ? 
                                and d.datacenterID = ? )) as porcentaje
                FROM central.segment s, central.vcenter v,
                            central.datacenter d,central.cluster c 
                WHERE s.segmentID = v.fk_segmentID 
                    and d.fk_vcenterID = v.vcenterID 
                    and c.fk_datacenterID = d.datacenterID 
                    and segmentID = ? 
                    and v.vcenterID = ?
                    and d.datacenterID = ? 
                    Group By c.clusterName,d.datacenterName,c.clusterHAEnabled";

            $clusterHa = DB::select($sql,[
                        (int) $segment,
                        (int) $layer,
                        (int) $datacenter,
                        (int) $segment,
                        (int) $layer,
                        (int) $datacenter
            ]); 
            //dd($clusterHa);
            return $clusterHa;
    }

    public function UpdateDate(){       
     
        $sql = "SELECT max(s.created_at) as fecha
                    FROM asgard.sync_logs s 
                    WHERE s.process = 'sync_central_vrt'";

            $UpdateDate = DB::select($sql); 
            //dd($clusterHa);
            return $UpdateDate;
    }

    public function DataStoreState( $segment,$layer,$datacenter, $cluster){   

        $sql = "SELECT d2.datastoreState, count(*) as cantidadState
                FROM central.segment s, 
                    central.vcenter v, 
                    central.datacenter d,
                    central.cluster c, 
                    central.datastore d2 
                WHERE s.segmentID = v.fk_segmentID 
                and d.fk_vcenterID = v.vcenterID 
                and c.fk_datacenterID = d.datacenterID 
                and d2.fk_clusterID = c.clusterID 
                and segmentID = ? 
                and v.vcenterID = ? 
                and d.datacenterID = ? 
                and c.clusterID = ?
                group by d2.datastoreState"; 

        $DataStoreState = DB::select($sql,[
            (int) $segment,
            (int) $layer,
            (int) $datacenter,
            (int) $cluster
        ]); 
        //dd($DataStoreState);
        return $DataStoreState;
    }

    public function DataStoreVersion( $segment,$layer,$datacenter, $cluster){

        $sql = "SELECT d2.datastoreVersion, count(*) as Cantidad
                    FROM central.segment s, 
                        central.vcenter v, 
                        central.datacenter d,
                        central.cluster c, 
                        central.datastore d2 
                    WHERE s.segmentID = v.fk_segmentID 
                    and d.fk_vcenterID = v.vcenterID 
                    and c.fk_datacenterID = d.datacenterID 
                    and d2.fk_clusterID = c.clusterID 
                    and segmentID = ? 
                    and v.vcenterID = ?
                    and d.datacenterID = ? 
                    and c.clusterID = ?
                    and c.clusterDeleted is null
                    group by d2.datastoreVersion";
                    
        $DataStoreVersion = DB::select($sql,[
            (int) $segment,
            (int) $layer,
            (int) $datacenter,
            (int) $cluster
        ]); 
        //dd($DataStoreVersion);
        return $DataStoreVersion;
    }

    public function DataStoreTotales($segment,$layer,$datacenter, $cluster){
       
            $sql = "SELECT sum(d2.datastoreCapacityGB) as totDatastore,
                            sum(d2.datastoreCapacityGB) * 0.75 as totalEfectivo,
                            sum(d2.datastoreUsedGB) as totUsado,
                            sum(d2.datastoreProvisionedGB) as totAprovisionado,
                            sum(d2.datastoreFreeSpaceGB) as totLibre,
                            sum(d2.datastoreCapacityGB) * 0.75 - sum(d2.datastoreProvisionedGB) as libreEfectivo
                    FROM central.segment s, 
                        central.vcenter v, 
                        central.datacenter d,
                        central.cluster c, 
                        central.datastore d2 
                    WHERE s.segmentID = v.fk_segmentID 
                    and d.fk_vcenterID = v.vcenterID 
                    and c.fk_datacenterID = d.datacenterID 
                    and d2.fk_clusterID = c.clusterID 
                    and segmentID = ?
                    and v.vcenterID = ? 
                    and d.datacenterID = ? 
                    and c.clusterID = ?
                    and c.clusterDeleted is null";


            $Datasuma = DB::select($sql,[
                (int) $segment,
                (int) $layer,
                (int) $datacenter,
                (int) $cluster
            ]); 
            //dd($Datasuma);
            return $Datasuma;
    }

    public function VmVersion($segment,$layer,$datacenter, $cluster, $vmhost){
        /*hardwareVersion*/
        $sql = "SELECT v3.vmHardwareVersion, count(*) as cantidadVersion
                    FROM central.segment s, 
                    central.vcenter v, 
                    central.datacenter d,
                    central.cluster c, 
                    central.vmhost v2, central.vm v3 
                    WHERE s.segmentID = v.fk_segmentID 
                    and d.fk_vcenterID = v.vcenterID 
                    and c.fk_datacenterID = d.datacenterID 
                    and v2.fk_clusterID = c.clusterID  
                    and v3.fk_vmhostID = v2.vmhostID  
                    and segmentID = ?
                    and v.vcenterID = ?
                    and d.datacenterID = ?
                    and c.clusterID = ?
                    and v2.vmhostID = ?
                    and d.datacenterDeleted is null
                    and c.clusterDeleted is null
                    and v2.vmhostDeleted is null
                    group by v3.vmHardwareVersion";

        $VmVersion = DB::select($sql,[
            (int) $segment,
            (int) $layer,
            (int) $datacenter,
            (int) $cluster,
            (int) $vmhost
        ]); 
        //dd($VmVersion);
        return $VmVersion;
    }

    public function VmGuestFamily($segment,$layer,$datacenter, $cluster,$vmhost){
        /*guestFamily*/
       $sql = "SELECT v3.vmGuestFamily , count(*) as cantidadGuestFamily
                FROM central.segment s, 
                central.vcenter v, 
                central.datacenter d,
                central.cluster c, 
                central.vmhost v2, central.vm v3 
                WHERE s.segmentID = v.fk_segmentID 
                    and d.fk_vcenterID = v.vcenterID 
                    and c.fk_datacenterID = d.datacenterID 
                    and v2.fk_clusterID = c.clusterID  
                    and v3.fk_vmhostID = v2.vmhostID  
                    and segmentID = ?
                    and v.vcenterID = ?
                    and d.datacenterID = ?
                    and c.clusterID = ?
                    and v2.vmhostID = ?
                    and d.datacenterDeleted is null
                    and c.clusterDeleted is null
                    and v2.vmhostDeleted is null
                    group by v3.vmGuestFamily";

        $VmGuestFamily = DB::select($sql,[
            (int) $segment,
            (int) $layer,
            (int) $datacenter,
            (int) $cluster,
            (int) $vmhost
        ]); 
        //dd($VmGuestFamily);
        return $VmGuestFamily;
    }

    public function VmHot($segment,$layer,$datacenter, $cluster,$vmhost){
        /*cpuHot, cpumemory*/
        $sql = "SELECT v3.vmHotAddMemory , count(v3.vmHotAddMemory) as cantmemory,v3.vmHotAddCpu, count(v3.vmHotAddCpu) as cantCpu
                    FROM central.segment s, 
                    central.vcenter v, 
                    central.datacenter d,
                    central.cluster c, 
                    central.vmhost v2, central.vm v3 
                    WHERE s.segmentID = v.fk_segmentID 
                    and d.fk_vcenterID = v.vcenterID 
                    and c.fk_datacenterID = d.datacenterID 
                    and v2.fk_clusterID = c.clusterID  
                    and v3.fk_vmhostID = v2.vmhostID  
                    and segmentID = ? 
                    and v.vcenterID = ? 
                    and d.datacenterID = ? 
                    and c.clusterID = ? 
                    and v2.vmhostID = ? 
                    and d.datacenterDeleted is null
                    and c.clusterDeleted is null
                    and v2.vmhostDeleted is null
                    group by v3.vmHotAddMemory,v3.vmHotAddCpu";

        $VmHot = DB::select($sql,[
            (int) $segment,
            (int) $layer,
            (int) $datacenter,
            (int) $cluster,
            (int) $vmhost
        ]); 
        //dd($VmHot);
        return $VmHot;
    }

    public function VmTotales($segment,$layer,$datacenter, $cluster,$vmhost){
        /*SUMATORIAS*/
        $sql = "SELECT sum(v3.vmMemoryGB) as sumMemory, 
                        sum(v3.vmCpuCount) as sumcpu, 
                        sum(v3.vmProvisionedSpaceGB) as sumProv, 
                        sum(v3.vmUsedSpaceGB) as sumEspacio
                FROM central.segment s, 
                central.vcenter v, 
                central.datacenter d,
                central.cluster c, 
                central.vmhost v2, central.vm v3 
                WHERE s.segmentID = v.fk_segmentID 
                    and d.fk_vcenterID = v.vcenterID 
                    and c.fk_datacenterID = d.datacenterID 
                    and v2.fk_clusterID = c.clusterID  
                    and v3.fk_vmhostID = v2.vmhostID  
                    and segmentID = ? 
                    and v.vcenterID = ? 
                    and d.datacenterID = ? 
                    and c.clusterID =? 
                    and v2.vmhostID = ?
                    and d.datacenterDeleted is null
                    and c.clusterDeleted is null
                    and v2.vmhostDeleted is null";

        $VmTotales = DB::select($sql,[
            (int) $segment,
            (int) $layer,
            (int) $datacenter,
            (int) $cluster,
            (int) $vmhost
        ]); 
        //dd($VmTotales);
        return $VmTotales;
    }

    public function vmhostUptime($segment,$layer,$datacenter, $cluster){   

            $sql = "SELECT v2.vmhostName,v2.vmhostUptime
                FROM central.segment s,
                central.vcenter v,
                central.datacenter d,
                central.cluster c,
                central.vmhost v2
                WHERE s.segmentID = v.fk_segmentID
                and d.fk_vcenterID = v.vcenterID
                and c.fk_datacenterID = d.datacenterID
                and v2.fk_clusterID = c.clusterID
                and segmentID = ?
                and v.vcenterID = ?
                and d.datacenterID = ?
                and c.clusterID = ?
                and d.datacenterDeleted is null
                and c.clusterDeleted is null
                and v2.vmhostDeleted is null";

            $vmhostUptime = DB::select($sql,[
                (int) $segment,
                (int) $layer,
                (int) $datacenter,
                (int) $cluster               
            ]); 
            //dd($vmhostUptime);
            return $vmhostUptime;
    }    
    
    public function vmhostTotales($segment,$layer,$datacenter, $cluster){
            $sql = "SELECT
                    SUM(v2.vmhostTotalMemoryGb) as totMemory,
                    SUM(v2.vmhostMemoryUsageGB) as totMemoryUse,
                    SUM(v2.vmhostTotalCpuGhz) as totCpu,
                    SUM(v2.vmhostCpuUsageGhz) as totCpuUse
                    FROM central.segment s,
                    central.vcenter v,
                    central.datacenter d,
                    central.cluster c,
                    central.vmhost v2
                    WHERE s.segmentID = v.fk_segmentID
                    and d.fk_vcenterID = v.vcenterID
                    and c.fk_datacenterID = d.datacenterID
                    and v2.fk_clusterID = c.clusterID
                    and segmentID = ?
                    and v.vcenterID = ?
                    and d.datacenterID = ?
                    and c.clusterID = ?
                    and d.datacenterDeleted is null
                    and c.clusterDeleted is null
                    and v2.vmhostDeleted is null";

            $vmhostTotales = DB::select($sql,[
                (int) $segment,
                (int) $layer,
                (int) $datacenter,
                (int) $cluster               
            ]); 
            //dd($vmhostTotales);
            return $vmhostTotales;                    

    }

    public function vmhostStorage($segment,$layer,$datacenter, $cluster){
        $sql = "SELECT v2.vmhostName,
                        v2.vmhostTotalStorageGb as totStorage,
                        v2.vmhostStorageUsageGb as totStorageUse
                FROM central.segment s,
                        central.vcenter v,
                        central.datacenter d,
                        central.cluster c,
                        central.vmhost v2
                WHERE s.segmentID = v.fk_segmentID
                and d.fk_vcenterID = v.vcenterID
                and c.fk_datacenterID = d.datacenterID
                and v2.fk_clusterID = c.clusterID
                and segmentID = ?
                and v.vcenterID = ?
                and d.datacenterID = ?
                and c.clusterID = ?
                and d.datacenterDeleted is null
                and c.clusterDeleted is null
                and v2.vmhostDeleted is null";

        $vmhostStorage = DB::select($sql,[
            (int) $segment,
            (int) $layer,
            (int) $datacenter,
            (int) $cluster               
        ]); 
        //dd($vmhostStorage);
        return $vmhostStorage;                    

    }

    public function vmhostVerEsxi($segment,$layer,$datacenter, $cluster){
        $sql = "SELECT v2.vmhostEsxiBuild , v2.vmhostEsxiVersion,count(*) as cant
                FROM central.segment s,
                    central.vcenter v,
                    central.datacenter d,
                    central.cluster c,
                    central.vmhost v2
                WHERE s.segmentID = v.fk_segmentID
                    and d.fk_vcenterID = v.vcenterID
                    and c.fk_datacenterID = d.datacenterID
                    and v2.fk_clusterID = c.clusterID
                    and segmentID = ?
                    and v.vcenterID = ?
                    and d.datacenterID = ?
                    and c.clusterID = ?
                    and d.datacenterDeleted is null
                    and c.clusterDeleted is null
                    and v2.vmhostDeleted is null
                    group by v2.vmhostEsxiVersion ,v2.vmhostEsxiBuild";

        $vmhostVerEsxi = DB::select($sql,[
            (int) $segment,
            (int) $layer,
            (int) $datacenter,
            (int) $cluster               
        ]); 
        //dd($vmhostVerEsxi);
        return $vmhostVerEsxi;                    

    }

    public function vmhostConnected($segment,$layer,$datacenter, $cluster){
        $sql = "SELECT v2.vmhostName, v2.vmhostConnectionState , 
                       v2.vmhostPowerState, count(*) as cant
                        FROM central.segment s,
                        central.vcenter v,
                        central.datacenter d,
                        central.cluster c,
                        central.vmhost v2
                        WHERE s.segmentID = v.fk_segmentID
                        and d.fk_vcenterID = v.vcenterID
                        and c.fk_datacenterID = d.datacenterID
                        and v2.fk_clusterID = c.clusterID
                        and segmentID = ?
                        and v.vcenterID = ?
                        and d.datacenterID = ?
                        and c.clusterID = ?
                        and d.datacenterDeleted is null
                        and c.clusterDeleted is null
                        and v2.vmhostDeleted is null
                        group by v2.vmhostName,v2.vmhostConnectionState,v2.vmhostPowerState";

        $vmhostConnected = DB::select($sql,[
            (int) $segment,
            (int) $layer,
            (int) $datacenter,
            (int) $cluster               
        ]); 
        //dd($vmhostConnected);
        return $vmhostConnected;                    

    }

    public function vmhostVendor($segment,$layer,$datacenter, $cluster){
        $sql = "SELECT v2.vmhostVendor as fabricante, count(*) as cant
                    FROM central.segment s,
                    central.vcenter v,
                    central.datacenter d,
                    central.cluster c,
                    central.vmhost v2
                    WHERE s.segmentID = v.fk_segmentID
                    and d.fk_vcenterID = v.vcenterID
                    and c.fk_datacenterID = d.datacenterID
                    and v2.fk_clusterID = c.clusterID
                    and segmentID = ?
                    and v.vcenterID = ?
                    and d.datacenterID = ?
                    and c.clusterID = ?
                    and d.datacenterDeleted is null
                    and c.clusterDeleted is null
                    and v2.vmhostDeleted is null
                    group by v2.vmhostVendor ";

        $vmhostVendor = DB::select($sql,[
            (int) $segment,
            (int) $layer,
            (int) $datacenter,
            (int) $cluster               
        ]); 
        //dd($vmhostVendor);
        return $vmhostVendor;                    

    }

    //Obtengo cant total hostFisicos entre todos los segmentos
    public function cantTotalHost(){

        $sql = "SELECT Count(*) as cantSegm3
                    from central.segment s, 
                        central.vcenter v, 
                        central.datacenter d,
                        central.cluster c, 
                        central.vmhost v2
                    where s.segmentID = v.fk_segmentID 
                    and d.fk_vcenterID = v.vcenterID 
                    and c.fk_datacenterID = d.datacenterID 
                    and v2.fk_clusterID = c.clusterID"; 

        $cantTotalHost = DB::select($sql); 
        //dd($cantTotalHost);
        return $cantTotalHost;   

    }

   

    //Obtengo porcentaje por segemento hostFisicos
    public function porcxsegHost(){

    $sql = "SELECT s.segmentName, count(*) as cantNum,
                    (Count(v2.vmhostID) * 100 / 
                        (Select Count(*) 
                            FROM central.segment s, 
                            central.vcenter v, 
                            central.datacenter d,
                            central.cluster c, 
                            central.vmhost v2
                            WHERE s.segmentID = v.fk_segmentID 
                            and d.fk_vcenterID = v.vcenterID 
                            and c.fk_datacenterID = d.datacenterID 
                            and v2.fk_clusterID = c.clusterID  
                            and s.segmentID in (1,2,3)
                        )
                    ) as porcentaje	
            from central.segment s, 
                central.vcenter v, 
                central.datacenter d,
                central.cluster c, 
                central.vmhost v2
            where s.segmentID = v.fk_segmentID 
            and d.fk_vcenterID = v.vcenterID 
            and c.fk_datacenterID = d.datacenterID 
            and v2.fk_clusterID = c.clusterID  
            and s.segmentID in (1,2,3)
            group by s.segmentName";  

        $porcxsegHost = DB::select($sql); 
        //dd($porcxsegHost);
        return $porcxsegHost;            
    }

   //Obtengo cant total clusters entre todos los segmentos
   public function cantTotalCluster(){
    
        $sql = "SELECT count(*) as cant
        from central.segment s, 
            central.vcenter v, 
            central.datacenter d,
            central.cluster c
        where s.segmentID = v.fk_segmentID 
        and d.fk_vcenterID = v.vcenterID 
        and c.fk_datacenterID = d.datacenterID"; 

        $cantTotalCluster = DB::select($sql); 
        //dd($cantTotalCluster);
        return $cantTotalCluster;
   }
 
   //Obtengo porcentaje por segemento clusters
   public function porcxsegCluster(){
            $sql = "SELECT s.segmentName, COUNT(*) AS cantNum,
                    (Count(c.clusterID) * 100 / 
                        (Select Count(*) 
                            FROM central.segment s, 
                            central.vcenter v, 
                            central.datacenter d,
                            central.cluster c 				
                            WHERE s.segmentID = v.fk_segmentID 
                            and d.fk_vcenterID = v.vcenterID 
                            and c.fk_datacenterID = d.datacenterID 				
                            and s.segmentID in (1,2,3)
                        )
                    ) as porcentaje	
                from central.segment s, 
                central.vcenter v, 
                central.datacenter d,
                central.cluster c	
                where s.segmentID = v.fk_segmentID 
                and d.fk_vcenterID = v.vcenterID 
                and c.fk_datacenterID = d.datacenterID 
                and s.segmentID in (1,2,3)
                group by s.segmentName";

            $porcxsegCluster = DB::select($sql); 
            //dd($cantTotalCluster);
            return $porcxsegCluster;


   }


   //Obtengo cant total VMs entre todos los segmentos
   public function cantTotalvms(){

        $sql = "SELECT COUNT(*) as CANT
        from central.segment s, 
            central.vcenter v, 
            central.datacenter d,
            central.cluster c,
            central.vmhost v2,
            central.vm v3 
        where s.segmentID = v.fk_segmentID 
        and d.fk_vcenterID = v.vcenterID 
        and c.fk_datacenterID = d.datacenterID 
        and v2.fk_clusterID = c.clusterID  
        and v3.fk_vmhostID = v2.vmhostID"; 

        $cantTotalvms = DB::select($sql); 
        //dd($cantTotalvms);
        return $cantTotalvms;
   }
  
   //Obtengo porcentaje por segemento clusters
   public function porcxsegVms(){

            $sql = "SELECT s.segmentName, count(*) as cantNum,
                            (Count(v3.vmID) * 100 / 
                                (Select Count(*) 
                                    FROM central.segment s, 
                                    central.vcenter v, 
                                    central.datacenter d,
                                    central.cluster c,
                                    central.vmhost v2,
                                    central.vm v3 
                                    WHERE s.segmentID = v.fk_segmentID 
                                    and d.fk_vcenterID = v.vcenterID 
                                    and c.fk_datacenterID = d.datacenterID 
                                    and v2.fk_clusterID = c.clusterID  
                                    and v3.fk_vmhostID = v2.vmhostID 
                                    and s.segmentID in (1,2,3)
                                )
                            ) as porcentaje	
                        from central.segment s, 
                        central.vcenter v, 
                        central.datacenter d,
                        central.cluster c,
                        central.vmhost v2,
                        central.vm v3 
                        where s.segmentID = v.fk_segmentID 
                        and d.fk_vcenterID = v.vcenterID 
                        and c.fk_datacenterID = d.datacenterID 
                        and v2.fk_clusterID = c.clusterID  
                        and v3.fk_vmhostID = v2.vmhostID 
                        and s.segmentID in (1,2,3)
                        group by s.segmentName";

            $porcxsegVms = DB::select($sql); 
            //dd($porcxsegVms);
            return $porcxsegVms;

   }

   //Obtengo cant total Dts entre todos los segmentos
   public function cantTotalDts(){

        $sql = "SELECT COUNT(*) cant
        from central.segment s, 
            central.vcenter v, 
            central.datacenter d,
            central.cluster c,
            central.datastore d2 
        where s.segmentID = v.fk_segmentID 
        and d.fk_vcenterID = v.vcenterID 
        and c.fk_datacenterID = d.datacenterID
        and d2.fk_clusterID = c.clusterID "; 

        $cantTotalDts = DB::select($sql); 
        //dd($cantTotalDts);
        return $cantTotalDts;
   }
 
   //Obtengo porcentaje por segemento clusters
   public function porcxsegDts(){

    $sql = "SELECT s.segmentName,count(*) as cantNum,
                    (Count(d2.datastoreID) * 100 / 
                        (Select Count(*) 
                            FROM central.segment s, 
                            central.vcenter v, 
                            central.datacenter d,
                            central.cluster c,
                            central.datastore d2 
                            WHERE s.segmentID = v.fk_segmentID 
                            and d.fk_vcenterID = v.vcenterID 
                            and c.fk_datacenterID = d.datacenterID 
                            and d2.fk_clusterID = c.clusterID 
                            and s.segmentID in (1,2,3)
                        )
                    ) as porcentaje	
                from central.segment s, 
                central.vcenter v, 
                central.datacenter d,
                central.cluster c,
                central.datastore d2 
                where s.segmentID = v.fk_segmentID 
                and d.fk_vcenterID = v.vcenterID 
                and c.fk_datacenterID = d.datacenterID
                and d2.fk_clusterID = c.clusterID 
                and s.segmentID in (1,2,3)
                group by s.segmentName";

    $porcxsegDts = DB::select($sql); 
    //dd($porcxsegDts);
    return $porcxsegDts;

   }

   //Obtengo cant total Vms entre todos los segmentos ON
   public function cantTotalVmsOn(){ 
    

        $sql = "select Count(*) as cant
        from central.segment s, 
            central.vcenter v, 
            central.datacenter d,
            central.cluster c,
            central.vmhost v2,
            central.vm v3 
        where s.segmentID = v.fk_segmentID 
        and d.fk_vcenterID = v.vcenterID 
        and c.fk_datacenterID = d.datacenterID 
        and v2.fk_clusterID = c.clusterID  
        and v3.fk_vmhostID = v2.vmhostID 
        and v3.vmPowerState = 'PoweredOn'"; 

        $cantTotalVmsOn = DB::select($sql); 
        //dd($cantTotalVmsOn);
        return $cantTotalVmsOn;

   }
  
   //Obtengo porcentaje por segemento Vm encendidas
   public function porcxsegVmsOn(){

        $sql = "SELECT v3.vmPowerState,s.segmentName, 
                        count(*) as cantNum,
                        (Count(v3.vmID) * 100 / 
                            (Select Count(*) 
                                FROM central.segment s, 
                                central.vcenter v, 
                                central.datacenter d,
                                central.cluster c,
                                central.vmhost v2,
                                central.vm v3 
                                WHERE s.segmentID = v.fk_segmentID 
                                and d.fk_vcenterID = v.vcenterID 
                                and c.fk_datacenterID = d.datacenterID 
                                and v2.fk_clusterID = c.clusterID  
                                and v3.fk_vmhostID = v2.vmhostID 
                                and s.segmentID in (1,2,3)
                                and v3.vmPowerState = 'PoweredOn'
                            )
                        ) as porcentaje		
                    from central.segment s, 
                    central.vcenter v, 
                    central.datacenter d,
                    central.cluster c,
                    central.vmhost v2,
                    central.vm v3 
                    where s.segmentID = v.fk_segmentID 
                    and d.fk_vcenterID = v.vcenterID 
                    and c.fk_datacenterID = d.datacenterID 
                    and v2.fk_clusterID = c.clusterID  
                    and v3.fk_vmhostID = v2.vmhostID 
                    and s.segmentID in (1,2,3)
                    and v3.vmPowerState = 'PoweredOn'
                    group by v3.vmPowerState ,s.segmentName"; 

        $porcxsegVmsOn = DB::select($sql); 
        //dd($porcxsegVmsOn);
        return $porcxsegVmsOn;

   }

    //Obtengo cant total Vms entre todos los segmentos OFF
    public function cantTotalVmsOff(){    

        $sql = "select Count(*) as cant
        from central.segment s, 
            central.vcenter v, 
            central.datacenter d,
            central.cluster c,
            central.vmhost v2,
            central.vm v3 
        where s.segmentID = v.fk_segmentID 
        and d.fk_vcenterID = v.vcenterID 
        and c.fk_datacenterID = d.datacenterID 
        and v2.fk_clusterID = c.clusterID  
        and v3.fk_vmhostID = v2.vmhostID 
        and v3.vmPowerState = 'PoweredOff'"; 

        $cantTotalVmsOff = DB::select($sql); 
        //dd($cantTotalVmsOff);
        return $cantTotalVmsOff;

    }

   //Obtengo porcentaje por segemento clusters
   public function porcxsegVmsOff(){
            $sql = "SELECT v3.vmPowerState,s.segmentName, 
                            count(*) as cantNum,
                            (Count(v3.vmID) * 100 / 
                                (Select Count(*) 
                                    FROM central.segment s, 
                                    central.vcenter v, 
                                    central.datacenter d,
                                    central.cluster c,
                                    central.vmhost v2,
                                    central.vm v3 
                                    WHERE s.segmentID = v.fk_segmentID 
                                    and d.fk_vcenterID = v.vcenterID 
                                    and c.fk_datacenterID = d.datacenterID 
                                    and v2.fk_clusterID = c.clusterID  
                                    and v3.fk_vmhostID = v2.vmhostID 
                                    and s.segmentID in (1,2,3)
                                    and v3.vmPowerState = 'PoweredOff'
                                )
                            ) as porcentaje		
                        from central.segment s, 
                        central.vcenter v, 
                        central.datacenter d,
                        central.cluster c,
                        central.vmhost v2,
                        central.vm v3 
                        where s.segmentID = v.fk_segmentID 
                        and d.fk_vcenterID = v.vcenterID 
                        and c.fk_datacenterID = d.datacenterID 
                        and v2.fk_clusterID = c.clusterID  
                        and v3.fk_vmhostID = v2.vmhostID 
                        and s.segmentID in (1,2,3)
                        and v3.vmPowerState = 'PoweredOff'
                        group by v3.vmPowerState ,s.segmentName"; 

            $porcxsegVmsOff = DB::select($sql); 
            //dd($porcxsegVmsOff);
            return $porcxsegVmsOff;

   }











}
