param($id_asgard, $opcion, $parametros)

Begin{

    ######################################

    Import-Module -Name SimplySql

    ######################################

    function Get-InfoConnection($opcion){

        if($opcion -in (100)){
            [string]$IpAsgard = "172.22.1.37"
            [string]$UserAsgard = ".\vmware.powercli"
            [string]$PasswordAsgard ="Cl4r0VMw4r3*"
        }elseif($opcion -in (101)){
            [string]$IpAsgard = "10.59.18.51"
            [string]$UserAsgard = "co-attla\ctxadmin"
            [string]$PasswordAsgard ="Cl4r0201410"
        }
        
        elseif($opcion -in (1,2)){
            [string]$IpAsgard = "172.22.1.36"
            [string]$UserAsgard = ".\vmware.powercli"
            [string]$PasswordAsgard ="Cl4r0VMw4r3*"
        }        
        $secpasswd = ConvertTo-SecureString $PasswordAsgard -AsPlainText -Force
        $Credential = New-Object System.Management.Automation.PSCredential ($UserAsgard, $secpasswd)
        return $IpAsgard, $Credential
    }

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

    switch($opcion){ 
        "1"{$PathScript = "G:\Automation\Produccion\Scripts-PowerShell\ASGARD\A001-VMWare-AumentoRecursos.ps1 $($params -replace "\*","'")"}
        "2"{$PathScript = "G:\Automation\Produccion\Scripts-PowerShell\ASGARD\A002-VMWare-DiagnosticoMV.ps1 $($parametros)"}
        default{}
    }
    if(!$localhost){
        [string]$IpAsgard = "172.18.91.203"
        [string]$UserAsgard = ".\asgard"
        [string]$PasswordAsgard ="Chibchombia2021-"
        $secpasswd = ConvertTo-SecureString $PasswordAsgard -AsPlainText -Force
        $Credential = New-Object System.Management.Automation.PSCredential ($UserAsgard, $secpasswd)
        $infoConnection = Get-InfoConnection -opcion $opcion
        $job = Start-Job -ScriptBlock{
            $silent = Invoke-Command -ComputerName $using:infoConnection[0] -Credential $using:infoConnection[1] -ScriptBlock{
                param($PathScript)
                iex $PathScript
            } -ArgumentList $using:PathScript
        } -Credential $Credential
        
    }else{
        iex $PathScript
    }
    

}
end{ 
    return $new_id
}
