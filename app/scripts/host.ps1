param($group)

$headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
$headers.Add("Authorization", "Basic Y3Jpc3RpYW4uYXJ0ZWFnYTo0dXQwbWF0MXo0Ki4=")
$headers.Add("Cookie", "csrftoken=90aGBnQg5S42bkKZV3UHyYceohQ2bMkvbL8KKtsUeYeTTYn9mRWjPQNMhLyUAVYd")

$response = Invoke-RestMethod 'http://172.22.1.178/api/v2/inventories/2/hosts/' -Method 'GET' -Headers $headers -Body $body

if($group)
{
    $response = $response.results | ?{$_.summary_fields.groups.results.name -eq $group}
}
else
{
    $response = $response.results
}

$response.name | ConvertTo-Json

