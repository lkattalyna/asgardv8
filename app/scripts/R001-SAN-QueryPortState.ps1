param($IpSwitch, $Port)

[string]$IpAsgard = "172.22.1.37"
[string]$UserAsgard = ".\vmware.powercli"
[string]$PasswordAsgard ="Cl4r0VMw4r3*"
$secpasswd = ConvertTo-SecureString $PasswordAsgard -AsPlainText -Force
$Credential = New-Object System.Management.Automation.PSCredential ($UserAsgard, $secpasswd)
Invoke-Command -ComputerName $IpAsgard -Credential $Credential -ScriptBlock{
    param($IpSwitch, $Port)
    G:\Automation\Production\Scripts\ps1\Asgard\\R001-SAN-QueryPortState.ps1 -Port "$Port" -IpSwitch "$IpSwitch"
} -ArgumentList $IpSwitch,$Port