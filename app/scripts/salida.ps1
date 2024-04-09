$headers = New-Object "System.Collections.Generic.Dictionary[[String],[String]]"
$headers.Add("Authorization", "Basic Y3Jpc3RpYW4uYXJ0ZWFnYTo0dXQwbWF0MXo0Ki4=")
$headers.Add("Cookie", "csrftoken=90aGBnQg5S42bkKZV3UHyYceohQ2bMkvbL8KKtsUeYeTTYn9mRWjPQNMhLyUAVYd")

$response = Invoke-RestMethod 'http://172.22.1.178/api/v2/jobs/3022/stdout/?format=txt' -Method 'GET' -Headers $headers -Body $body
$response 