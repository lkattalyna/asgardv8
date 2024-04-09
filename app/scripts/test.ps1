param($idJob, $idasgard)

try {
    $webrequest = [System.Net.WebRequest]::Create("http://172.22.1.178/api/v2/jobs/$($idJob)/stdout/?format=html");
    $webrequest.Method = "GET"
    $webrequest.PreAuthenticate = $true
    $webrequest.Headers.Add("Authorization", "Basic " + "Y3Jpc3RpYW4uYXJ0ZWFnYTo0dXQwbWF0MXo0Ki4=")
    $webrequest.ContentType = "text/html; charset=utf-8"
    $response = $webrequest.GetResponse()

    $GetResponseStream = $response.GetResponseStream()
    $read = new-object System.IO.StreamReader $GetResponseStream
    $read.ReadToEnd() >> G:\lol3.html

}
catch [System.Net.WebException] {
    $Request = $_.Exception
    Write-host "Exception caught: $Request"
}