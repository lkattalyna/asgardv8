param($id_task, $command, $id_asgard)

begin{
    Import-Module -Name SimplySql
    $id_asgard = 2;
    #$path = "G:\Automation\Developer\PS1"
    $date_ini = Get-Date -Format ('yyyy-MM-dd HH:MM:ss')
}

Process{
    Start-Sleep -Seconds 2
    $date_fin = Get-Date -Format ('yyyy-MM-dd HH:MM:ss')
    $connect = Open-MySqlConnection -Server "localhost" -Port 3306 -Database asgardv3 -UserName asgardadm -Password asgard

    Invoke-SqlQuery -Query "UPDATE execution_logs set id_job=0, f_ini_script='$($date_ini)', f_fin_script='$($date_fin)',estado=1, resultado='shadgshgdsh'
                            where id = $id_asgard"
}

end{
    return $null
}