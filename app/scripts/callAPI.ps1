param([string]$json, $id_asgard, $Id_JobTemplate, $IpAWX)

Import-Module -Name SimplySql

if(!$IpAWX){ $IpAWX = "172.22.1.178" }

function Update-LogMysql($query){
            $connect = Open-MySqlConnection -Server "localhost" -Port 3306 -Database asgard -UserName root -Password asgard -ErrorAction Stop -WarningAction SilentlyContinue
            Invoke-SqlQuery -Query $query -ErrorAction Stop -WarningAction SilentlyContinue
        
    }

$headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
$headers.Add("Authorization", "Basic Y3Jpc3RpYW4uYXJ0ZWFnYTo0dXQwbWF0MXo0Ki4=")
$headers.Add("Content-Type", "application/json")

$json = $json -replace "\*",'"'
$response = Invoke-RestMethod "http://$($IpAWX)/api/v2/job_templates/$($Id_JobTemplate)/launch/" -Method 'POST' -Headers $headers -Body $json

$query = "UPDATE execution_logs set id_job = $($response.id) where id = $($id_asgard)"
Update-LogMysql -query $query 

Start-Process -FilePath 'powershell.exe' -ArgumentList "C:\laragon\www\asgard\app\scripts\callAPI2.ps1 $($response.id) $id_asgard"


return $response.id | ConvertTo-Json