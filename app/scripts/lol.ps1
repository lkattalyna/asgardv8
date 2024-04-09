$headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
$headers.Add("Authorization", "Basic Y3Jpc3RpYW4uYXJ0ZWFnYTo0dXQwbWF0MXo0Ki4=")

$response = Invoke-RestMethod 'http://172.22.1.178/api/v2/job_templates/' -Method 'GET' -Headers $headers -Body $body
$response | ConvertTo-Json