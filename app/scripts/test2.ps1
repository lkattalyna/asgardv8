try {
    $webrequest = [System.Net.WebRequest]::Create("http://172.22.1.178/api/v2/jobs/3022/stdout/")   #/?format=html");
    $webrequest.Method = "GET"
    $webrequest.PreAuthenticate = $true
    $webrequest.Headers.Add("Authorization", "Basic " + "Y3Jpc3RpYW4uYXJ0ZWFnYTo0dXQwbWF0MXo0Ki4=")
    $webrequest.ContentType = "text/html; charset=utf-8"
    $response = $webrequest.GetResponse()

    #$sr = New-Object System.IO.StreamReader($response)

    #$sr
}
catch [System.Net.WebException] {
    $Request = $_.Exception
    Write-host "Exception caught: $Request"
}


var client = new RestClient("http://172.22.1.178/api/v2/jobs/3022/stdout/?format=html");
client.Timeout = -1;
var request = new RestRequest(Method.GET);
request.AddHeader("Authorization", "Basic Y3Jpc3RpYW4uYXJ0ZWFnYTo0dXQwbWF0MXo0Ki4=");
request.AddHeader("Cookie", "csrftoken=dE8EWcdpA9jq9e0HAqrgVEUKwdl7upKLKDZVEOBb11jyiKK1oxgQvXn6NclT2tb4");
request.AddParameter("text/plain", "",  ParameterType.RequestBody);
IRestResponse response = client.Execute(request);
Console.WriteLine(response.Content);

