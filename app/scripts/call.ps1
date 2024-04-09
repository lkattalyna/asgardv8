Param($id_task, $command, $id_asgard)

begin{

}

Process{
    Start-Process -FilePath 'powershell.exe' -ArgumentList "C:\laragon\www\asgard\app\scripts\call2.ps1 $id_task '$command' $id_asgard"

}

end{

}