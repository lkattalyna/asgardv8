param($op, $params)

Begin{

    function Get-InfoConnection($op){

        if($op -in ("1")){
            [string]$IpAsgard = "172.22.1.37"
            [string]$UserAsgard = ".\vmware.powercli"
            [string]$PasswordAsgard ="Cl4r0VMw4r3*"
        }       
        $secpasswd = ConvertTo-SecureString $PasswordAsgard -AsPlainText -Force
        $Credential = New-Object System.Management.Automation.PSCredential ($UserAsgard, $secpasswd)
        return $IpAsgard, $Credential
    }


}
Process{
    $localhost = $false
    switch($op){
        # Rendimiento VM
        "1"{$PathScript = "G:\Automation\Production\Scripts\ps1\ChatBot\\C001-VRT-DiagnosticoVM.ps1 '$($params)'"}
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
