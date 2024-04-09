param($op, $params)

Begin{

    function Get-InfoConnection($op){

        if($op -in ("1","2","3","4","5")){
            [string]$IpAsgard = "172.22.1.36"
            [string]$UserAsgard = ".\vmware.powercli"
            [string]$PasswordAsgard ="Cl4r0VMw4r3*"
        }elseif($op -in ("6")){
            [string]$IpAsgard = "10.59.18.51"
            [string]$UserAsgard = "co-attla\ctxadmin"
            [string]$PasswordAsgard ="Cl4r0201410"
        }        
        $secpasswd = ConvertTo-SecureString $PasswordAsgard -AsPlainText -Force
        $Credential = New-Object System.Management.Automation.PSCredential ($UserAsgard, $secpasswd)
        return $IpAsgard, $Credential
    }


}
Process{
    $localhost = $false
    switch($op){
        #"1"{$PathScript = "G:\Automation\Production\Scripts\ps1\Asgard\\R001-SAN-QueryPortState.ps1 $($params -replace "\*","'")"}
        #"2"{$PathScript = "G:\Automation\Production\Scripts\ps1\Asgard\\R002-SAN-QueryWWN.ps1 $($params -replace "\*","'")"}
        #"3"{$PathScript = "G:\Automation\Production\Scripts\ps1\Asgard\\R003-SAN-QueryZonas.ps1 $($params -replace "\*","'")"}
        "1"{$PathScript = "G:\Automation\Production\Scripts\ps1\Asgard\\A009-SAN-ExecutionCommad.ps1 $($params -replace "\*","'")"}
        "4"{$PathScript = "G:\Automation\Production\Scripts\ps1\Asgard\\R007-VMware-ConsoleESXiPowercli $($params -replace "\*","'")"}
        "5"{$PathScript = "G:\Automation\Production\Scripts\ps1\Asgard\\R008-VMware-GetVcenter $($params -replace "\*","'")"}
        "6"{$PathScript = "C:\inetpub\wwwroot\asgard\app\scripts\VIRTUALIZATION\ListDirectoriesProfiles.ps1"
            $localhost = $true
        }
        default{}
    }
    if(!$localhost){
        $infoConnection = Get-InfoConnection -op $op
        Invoke-Command -ComputerName $infoConnection[0] -Credential $infoConnection[1] -ScriptBlock{
            param($PathScript)
            iex $PathScript
        } -ArgumentList $PathScript
    }else{
        iex $PathScript
    }
    

}
end{

}
