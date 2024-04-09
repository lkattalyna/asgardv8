[CmdletBinding()]
[Alias()]
[OutputType([int])]
Param
([string]$adjunto)

Begin
{
    function remove-attached($path){
        $silent = Remove-Item -Path $path -ErrorAction Ignor
    }
}
Process
{

    if($adjunto){
        do{
             $silent = Start-Sleep -Seconds 3
             $lecturaFile = Get-Content -Path $adjunto -ErrorAction Ignore
        }while($lecturaFile -eq $null)
        $response = remove-attached -path $adjunto
    }
}
End
{

}