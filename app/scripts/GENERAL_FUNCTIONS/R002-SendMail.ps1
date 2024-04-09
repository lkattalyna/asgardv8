
param ([string]$destinatario, [string]$copia, [string]$asunto, [string]$cuerpo, [string]$adjunto)



[string]$IpAsgard = "172.22.1.37"
[string]$UserAsgard = ".\vmware.powercli"
[string]$PasswordAsgard ="Cl4r0VMw4r3*"
$secpasswd = ConvertTo-SecureString $PasswordAsgard -AsPlainText -Force
$Credential = New-Object System.Management.Automation.PSCredential ($UserAsgard, $secpasswd)

 Invoke-Command -ComputerName $IpAsgard -Credential $Credential -ScriptBlock{
    
    param([string]$destinatario, [string]$copia, [string]$asunto, [string]$cuerpo, [string]$adjunto)

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
            $body = "<img src='cid:att' width='60' height='60'/>"
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
            #$att.Dispose()
        }
        End
        {
        
        }
    } 
     $dest = $destinatario -split ","
     $cc = $copia -split ","
     Send-ClaroEmail -Subject $asunto -ToEmails $dest -ToCopy $cc -BodyHtml $cuerpo -Attachments $adjunto

} -ArgumentList $destinatario,$copia,$asunto,$cuerpo,$adjunto