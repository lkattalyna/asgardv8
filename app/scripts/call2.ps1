Param($id_task, $command, $id_asgard)

begin{

    ###################################################################

    Import-Module -Name SimplySql
    $date_ini = Get-Date -Format ('yyyy-MM-dd HH:MM:ss')
    $ServerPathScripts = "G:\Automation\Production\Scripts\ps1\Asgard\"
    $secpasswd = ConvertTo-SecureString "Cl4r0VMw4r3*" -AsPlainText -Force
    $mycreds = New-Object System.Management.Automation.PSCredential (".\vmware.powercli", $secpasswd)
    switch($id_task){
        "1"{$NameScript = "A001-VMware-AdvancedReportByVm.ps1"}
        "2"{$NameScript = "A002-VMWare-PerformanceVM"}
        default{$NameScript = $null}
    }

    function Update-LogMysql($query){
            $connect = Open-MySqlConnection -Server "localhost" -Port 3306 -Database asgard -UserName root -Password asgard -ErrorAction Stop 
            Invoke-SqlQuery -Query $query -ErrorAction Stop
        
    }

    
    ###################################################################
}

Process{

    ###################################################################

    try{
        if(!$NameScript){ throw "No Existe el Script"}
        $path = $ServerPathScripts + $NameScript +' '+ $command
        $date_fin = Get-Date -Format ('yyyy-MM-dd HH:MM:ss')
        $result = Invoke-Command -ComputerName 172.22.1.37 -Credential  $mycreds -ScriptBlock {
            param($path)
                iex $path
        } -ArgumentList $path -ErrorAction Stop
        $date_fin = Get-Date -Format ('yyyy-MM-dd HH:MM:ss')
        $query = "UPDATE execution_logs set id_job = 0, f_ini_script='$($date_ini)', f_fin_script='$($date_fin)',estado=1, resultado='$($result)' where id = $($id_asgard)"
        Update-LogMysql -query $query 
    }catch{
        $date_fin = Get-Date -Format ('yyyy-MM-dd HH:MM:ss') 
        $_.Exception.Message >> G:\Automation\lol.txt
        $query = "UPDATE execution_logs set id_job = 0, f_ini_script='$($date_ini)', f_fin_script='$($date_fin)',estado=2, resultado='Error' where id = $($id_asgard)"
        Update-LogMysql -query $query
    }
   
    ###################################################################
    
}

end{
    return $null
}