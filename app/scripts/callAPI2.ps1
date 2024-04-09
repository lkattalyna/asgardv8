Param($idjob, $id_asgard)

begin{

    ###################################################################

    Import-Module -Name SimplySql
    $date_ini = Get-Date -Format ('yyyy-MM-dd HH:MM:ss')

    function Update-LogMysql($query){
            $connect = Open-MySqlConnection -Server "localhost" -Port 3306 -Database asgard -UserName root -Password asgard -ErrorAction Stop 
            Invoke-SqlQuery -Query $query -ErrorAction Stop
        
    }

    function get-statusawx($idjob){
        try {
            $webrequest = [System.Net.WebRequest]::Create("http://172.22.1.178/api/v2/jobs/$($idJob)/");
            $webrequest.Method = "GET"
            $webrequest.PreAuthenticate = $true
            $webrequest.Headers.Add("Authorization", "Basic " + "Y3Jpc3RpYW4uYXJ0ZWFnYTo0dXQwbWF0MXo0Ki4=")
            $webrequest.ContentType = "text/html; charset=utf-8"
            $response = $webrequest.GetResponse()

            $GetResponseStream = $response.GetResponseStream()
            $read = new-object System.IO.StreamReader $GetResponseStream
            $result = $read.ReadToEnd() | ConvertFrom-Json
            return $result.status
        }
        catch [System.Net.WebException] {
            $Request = $_.Exception
            $return = "failed"
        }
    }

    function get-awxresult($idjob){
        try {
            $webrequest = [System.Net.WebRequest]::Create("http://172.22.1.178/api/v2/jobs/$($idJob)/stdout/?format=html");
            $webrequest.Method = "GET"
            $webrequest.PreAuthenticate = $true
            $webrequest.Headers.Add("Authorization", "Basic " + "Y3Jpc3RpYW4uYXJ0ZWFnYTo0dXQwbWF0MXo0Ki4=")
            $webrequest.ContentType = "text/html; charset=utf-8"
            $response = $webrequest.GetResponse()

            $GetResponseStream = $response.GetResponseStream()
            $read = new-object System.IO.StreamReader $GetResponseStream
            $read.ReadToEnd() >> C:\laragon\www\asgard\public\scriptRs\$($idJob)_AWX.html
            return "$($idJob)_AWX.html"
        }
        catch [System.Net.WebException] {
            $Request = $_.Exception
            return "failed"
        }
    }

    
    ###################################################################
}

Process{

    ###################################################################

    try{
        $date_fin = Get-Date -Format ('yyyy-MM-dd HH:MM:ss')
        
        do{
            Start-Sleep -Seconds 30
            $status= get-statusawx
        }while($status -eq "running")
        if($status -eq "failed"){
            $estadoasgard = 1
        }else{
            $estadoasgard = 1
        }
        $result =  get-awxresult -idjob $idjob
        $date_fin = Get-Date -Format ('yyyy-MM-dd HH:MM:ss')
        $query = "UPDATE execution_logs set  f_ini_script='$($date_ini)', f_fin_script='$($date_fin)',estado=1, resultado='$($result)' where id = $($id_asgard)"
        Update-LogMysql -query $query 
    }catch{
        $date_fin = Get-Date -Format ('yyyy-MM-dd HH:MM:ss') 
        $_.Exception.Message >> G:\Automation\lol.txt
        $query = "UPDATE execution_logs set f_ini_script='$($date_ini)', f_fin_script='$($date_fin)',estado=2, resultado='Error' where id = $($id_asgard)"
        Update-LogMysql -query $query
    }
   
    ###################################################################
    
}

end{
    return $null
}