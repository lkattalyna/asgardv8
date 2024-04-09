<?php

namespace App\Models;
use DB;
class ReportesMaquinasBu
{
    public static function clients($client){
        $sqlClients = "SELECT distinct report_dep.Client FROM master master_dep
                        join (select distinct Client from report ) report_dep on master_dep.Maquina =report_dep.Client
                        join smriass s on s.ID_Incidente =master_dep.Caso
                        where report_dep.client like '%$client%'
                        UNION
                        SELECT distinct vadp_dep.Machine_Name FROM master master_dep
                        join (select distinct Machine_Name from vadp)vadp_dep on master_dep.Maquina = vadp_dep.Machine_Name
                        join smriass s on s.ID_Incidente =master_dep.Caso
                        where vadp_dep.Machine_Name LIKE '%$client%'";

        $clients = DB::select($sqlClients);
        if($clients){
            return $clients;
        }else{
                return array(
                    [
                        "Data"=>"No se encontró resultado para la búsqueda solicitada",
                ]);
            }
    }

    public static function reportsClient($nameClient){
        //Obtengo los datos de la máquina virtual
        $sqlClient="SELECT report_dep.Client ,s.ID_Incidente ,s.Estado ,s.Fecha_hora_de_apertura
        FROM master master_dep
        join (select distinct Client from report ) report_dep on master_dep.Maquina =report_dep.Client
        join smriass s on s.ID_Incidente =master_dep.Caso
        where report_dep.client = '$nameClient'";

        $sqlVADP="SELECT vadp_dep.Machine_Name ,s.ID_Incidente ,s.Estado ,s.Fecha_hora_de_apertura
            FROM master master_dep
            join (select distinct Machine_Name from vadp)vadp_dep on master_dep.Maquina = vadp_dep.Machine_Name
            join smriass s on s.ID_Incidente =master_dep.Caso
            where vadp_dep.Machine_Name = '$nameClient'";

        $Client = DB::select($sqlClient);
        $VADP = DB::select($sqlVADP);

        if ($Client){
        return $Client;
        }else if($VADP){
        return $VADP;
        }else{
        return array([
            "Data"=>"No se encontró resultado para la búsqueda solicitada",
        ]);
        }
    }
}
