<#
.Synopsis
   Short description
.DESCRIPTION
   Long description
.EXAMPLE
   Example of how to use this cmdlet
.EXAMPLE
   Another example of how to use this cmdlet
#>
[CmdletBinding()]
[Alias()]
[OutputType([int])]
Param
([string]$destinatario, [string]$copia, [string]$asunto, [string]$cuerpo, [string]$adjunto)

Begin
{
    [string]$IpAsgard = "172.22.1.37"
    [string]$UserAsgard = ".\vmware.powercli"
    [string]$PasswordAsgard ="Cl4r0VMw4r3*"
    $secpasswd = ConvertTo-SecureString $PasswordAsgard -AsPlainText -Force
    $Credential = New-Object System.Management.Automation.PSCredential ($UserAsgard, $secpasswd)

    function remove-attached($path){
        $silent = Remove-Item -Path $path -ErrorAction Ignore
    }
}
Process
{
    if($adjunto){
        do{
             $silent = Start-Sleep -Seconds 3
             $lecturaFile = Get-Content -Path $adjunto -ErrorAction Ignore
        }while($lecturaFile -eq $null)
        $NameFile = (($adjunto -split "\\")[-1] -split "\.")[0]
    }

     $result = Invoke-Command -ComputerName $IpAsgard -Credential $Credential -ScriptBlock{
    
        param([string]$destinatario, [string]$copia, [string]$asunto, [string]$cuerpo, [string]$lecturaFile, [string]$NameFile)

        function Send-ClaroEmail
        { 
            Param
            (
                 [string]$Subject,
                 [string[]]$ToEmails,
                 [string[]]$ToCopy,
                 [string]$BodyHtml,
                 [string[]]$Attachments
            )

            Begin
            {
                $smtpServer = "172.22.88.6" 
                #$att = new-object Net.Mail.Attachment("G:\Automation\Library\GeneralFunctions\img\LogoClaro.png")
                #$att.ContentId = "att"
                $msg = new-object Net.Mail.MailMessage
                $smtp = new-object Net.Mail.SmtpClient($smtpServer)
                #$smtp.EnableSSL = $true
                $msg.From = "virtuadatacenter.co@claro.com.co" 
            }
            Process
            {
                try{
                    $body = ""
                    foreach($ToEmail in $ToEmails){
                        $msg.To.Add($ToEmail)
                    }
                    if($ToCopy){
                        foreach($Cc in $ToCopy){
                        $msg.CC.Add($Cc)
                        }
                    }
            
                    $msg.Subject = $Subject
                    $msg.Body = $BodyHtml
                    $msg.IsBodyHTML = $BodyHtml
                    #$msg.Attachments.Add($att)
                    if($Attachments){
                        foreach($Attachment in $Attachments){
                            $aux = new-object Net.Mail.Attachment($Attachment)
                            $msg.Attachments.Add($aux) 
                        } 
                    }
            
                    $smtp.Send($msg)
                     return $true
                }catch{
                     return $false
                }
            
                #$att.Dispose()
            }
            End
            {
        
            }
        }

        $dest = $destinatario -split ","
        $cc = $copia -split ","
        if($lecturaFile){
            $path = "G:\Automation\Production\Scripts\Exports\ASGARD-MAIL\$($NameFile).csv"
            $contend = ($lecturaFile | ConvertFrom-Json).SyncRoot | Export-Csv -Path $path -Delimiter ";" -NoTypeInformation
            $response = Send-ClaroEmail -Subject $asunto -ToEmails $dest -ToCopy $cc -BodyHtml $cuerpo -Attachments $path
            $silent = Remove-Item -Path $path -ErrorAction Ignore
        }else{
            $response = Send-ClaroEmail -Subject $asunto -ToEmails $dest -ToCopy $cc -BodyHtml $cuerpo -Attachments ""
        }
        
        $result = "" | select @{n="response";e={$response}}, @{n="error";e={$Error.Exception.Message}}
        return ($result | ConvertTo-Json -Compress) 
    } -ArgumentList $destinatario,$copia,$asunto,$cuerpo,$lecturaFile,$NameFile
    $silent = remove-attached -path $adjunto
}
End
{
    return $result
}