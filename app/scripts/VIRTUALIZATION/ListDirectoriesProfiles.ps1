param()

Begin{
    [string]$UserAsgard = "co-attla\ctxadmin"
    [string]$PasswordAsgard ="Cl4r0201410"
    $secpasswd = ConvertTo-SecureString $PasswordAsgard -AsPlainText -Force
    $Credential = New-Object System.Management.Automation.PSCredential ($UserAsgard, $secpasswd)
}
Process{
    $result = Invoke-Command -ComputerName "10.59.18.51" -Credential $Credential -ScriptBlock{
        $jsonBase = @{}
        $list = New-Object System.Collections.ArrayList
        $PATHPROFILES = "C:\"
        Get-ChildItem -Path $PATHPROFILES -Attributes !Archive | foreach  {
            [void]$list.Add($_.Name)
        }
        $jsonBase.Add("Directories",$list) 
        return $jsonBase | ConvertTo-Json -Compress
    }
}
end{
    Return $result
}
