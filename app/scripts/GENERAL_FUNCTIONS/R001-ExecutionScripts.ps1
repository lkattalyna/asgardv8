param($id_asgard, $opcion, $parametros)

Begin{

    ######################################

    Import-Module -Name SimplySql 

    ######################################

    function New-IdAsgard(){
        $query = "select id from execution_logs where id >= 100000000"
        $connect = Open-MySqlConnection -Server "localhost" -Port 3306 -Database asgard -UserName root -Password asgard -ErrorAction Stop -WarningAction SilentlyContinue
        $ids = (Invoke-SqlQuery -Query $query -ErrorAction Stop -WarningAction SilentlyContinue).id
        do{
            $random = Get-Random -Minimum 100000000 -Maximum 200000000
        }while($random -in $ids) 
        return $random
    }

}
Process{
    $localhost = $false
    $new_id = New-IdAsgard

    $action = New-ScheduledTaskAction -Execute 'powershell.exe' -Argument "E:\ScriptProduccion\run_scripts.ps1 -id_asgard $id_asgard -opcion $opcion -parametros '$parametros'" 
    
    $task = Register-ScheduledTask -Action $action -TaskPath "\jobs_asgard" -TaskName "$id_asgard" -Description "$new_id" -User "\asgard" -Password "Chibchombia2021-"

    $sielnt = $task | Start-ScheduledTask -AsJob 
     

}
end{ 
    $sielnt= $error >> E:\ScriptProduccion\txt.txt
    return $new_id
}
