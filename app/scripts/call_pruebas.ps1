param($id_task, $command, $id_asgard)

begin{

}
Process{
    Start-Sleep -Seconds 2
	$texto = "Tarea: " + $id_task + " Comando:" + $command + " ID_ASGARD: " + $id_asgard
}

end{
    return $texto
}