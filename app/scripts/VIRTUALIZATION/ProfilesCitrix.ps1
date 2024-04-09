[CmdletBinding()]
param (
    [Parameter(Mandatory=$true)][string]$profile
)

$pathDevice = "\\172.18.91.10\Users\Automsft\Desktop\Compartida"
$pw = "Prueba123*"
$user = "CONTOSODC\TestCitrix"
$Date = $(Get-Date -Format "MMddyyyy_HHmm")
$filesArray = @("Desktop", "Documents", "Favorites")
# Tiempo de Validacion para Backups Recientes
$timeRecent=5
# Tiempo de Espera en la Validacion del Usuario
$timeoutVerifyProfile = 5
# Cantidad de Intentos Realizados para Verificacion de Usuario
$numberAttempts = 18

function DeleteUser {
    # Valida si Existe el Perfil Ingresado en el Directorio "DATA"
    if ( Test-Path $pathDevice\DATA\$profile ){
        # Valida si Existe el Perfil Ingresado en el Directorio "PROFILES"
        $fileBackupProfile = (ls $pathDevice\DATA\ | Where-Object { $_.LastWriteTime -gt $(Get-Date).AddMinutes(-$timeRecent) } | Sort-Object -Property LastWriteTime -Descending).name | findstr "BK_" | findstr -i $profile | Select -First 1
        if (Test-Path $pathDevice\PROFILES\$profile) {
            $nameFolderData = (ls $pathDevice\DATA\).Name | findstr /i /x $profile
            $nameFolderProfiles = (ls $pathDevice\PROFILES\).Name | findstr /i /x $profile

            if ($fileBackupProfile -eq $Null) {
                # Backup del Perfil para Restuaracion de Archivos Especificos
                Robocopy $pathDevice\DATA\$profile $pathDevice\DATA\BK_$($Date)_$($nameFolderData) * /s /NFL /NDL /NJH /NJS
                $fileBackupProfile = "BK_$($Date)_$($nameFolderData)"
            }

            # Validacion de que se recree automaticamente la carpeta del perfil
            $counter = 0
            $existProfile = $false
            $existProfileData = $false
            
            # Verifica si el usuario fue creado recientemente en PROFILES y DATA
            $verifyProfileFolderPROFILE = ((ls $pathDevice\PROFILES\ | Where-Object { $_.LastWriteTime -gt $(Get-Date).AddMinutes(-$timeRecent) } | Sort-Object -Property LastWriteTime -Descending).name | findstr /i /x $profile | Measure-Object).Count
            $verifyProfileFolderDATA = ((ls $pathDevice\DATA\ | Where-Object { $_.LastWriteTime -gt $(Get-Date).AddMinutes(-$timeRecent) } | Sort-Object -Property LastWriteTime -Descending).name | findstr /i /x $profile | Measure-Object).Count
            if ( $verifyProfileFolderPROFILE -eq 1 -And $verifyProfileFolderDATA -eq 1) {
                #Write-Host "Usuario $profile fue creado recientemente"
                $existProfile = $true
                $existProfileData = $true
            } else {
                # Eliminacion de los Directorios que hacen parte del perfil
                Remove-Item -Recurse -Force -ErrorAction SilentlyContinue $pathDevice\PROFILES\$profile
                Remove-Item -Recurse -Force -ErrorAction SilentlyContinue $pathDevice\DATA\$profile

                do {
                    $counter++
                    if ( ($existProfileData -eq $false -And $existProfile -eq $false) -or ($existProfileData -eq $false -And $existProfile -eq $true) -or ($existProfileData -eq $true -And $existProfile -eq $false) ) {
                        if (!(Test-Path $pathDevice\PROFILES\$profile)) {
                            Start-Sleep -Seconds $timeoutVerifyProfile
                        } else {
                            $existProfile = $true
                        }
                        if (!(Test-Path $pathDevice\DATA\$profile)) {
                            Start-Sleep -Seconds $timeoutVerifyProfile
                        } else {
                            $existProfileData = $true
                        }
                    } else {
                        break
                    }
                } while ($counter -le $numberAttempts)
            }
            
            if ($existProfile) {
                if ($existProfileData) {
                    # Restauracion de Archivos Especificos
                    foreach ($file in $filesArray){
                        Robocopy $pathDevice\DATA\$fileBackupProfile\$file $pathDevice\DATA\$nameFolderData\$file /s /NFL /NDL /NJH /NJS 
                        # Eliminacion de Directorios sobre el Backup
                        Remove-Item -Recurse -Force -ErrorAction SilentlyContinue $pathDevice\DATA\$fileBackupProfile\$file            
                    }
                    #Write-Host "Tarea finalizada exitosamente."
                    @{OK="Tarea finalizada"} | ConvertTo-Json
                } else {
                    # Restauracion de Todos los Archivos
                    Robocopy $pathDevice\DATA\$fileBackupProfile $pathDevice\DATA\$nameFolderData * /s /NFL /NDL /NJH /NJS
                    #throw "No recreo el perfil: $profile en la ruta: $pathDevice\PROFILES"
                    @{Error="No recreo el perfil: $profile en la ruta: $pathDevice\DATA"} | ConvertTo-Json
                }
            } else {
                # Restauracion de Todos los Archivos
                Robocopy $pathDevice\DATA\$fileBackupProfile $pathDevice\DATA\$nameFolderData * /s /NFL /NDL /NJH /NJS
                #throw "No recreo el perfil: $profile en la ruta: $pathDevice\PROFILES"
                @{Error="No recreo el perfil: $profile en la ruta: $pathDevice\PROFILES"} | ConvertTo-Json
            }

            # Eliminacion de Backup
            Remove-Item -Recurse -Force -ErrorAction SilentlyContinue $pathDevice\DATA\$fileBackupProfile
        } else {
            #throw "No existe el perfil: $profile en la ruta: $pathDevice\PROFILES"
            #@{Error="No existe el perfil: $profile en la ruta: $pathDevice\PROFILES"} | ConvertTo-Json
            
            # Validacion de que se recree automaticamente la carpeta del perfil
            $counter = 0
            $existProfile = $false
            $existProfileData = $false
            if ($fileBackupProfile -eq $Null) {
                # Backup del Perfil para Restuaracion de Archivos Especificos
                Robocopy $pathDevice\DATA\$profile $pathDevice\DATA\BK_$($Date)_$($nameFolderData) * /s /NFL /NDL /NJH /NJS
                $fileBackupProfile = "BK_$($Date)_$($nameFolderData)"
            }
            do {
                $counter++
                #Write-Host "validacion N: $counter, con valor Perfil: $existProfile y Data: $existProfileData"
                if ( ($existProfileData -eq $false -And $existProfile -eq $false) -or ($existProfileData -eq $false -And $existProfile -eq $true) -or ($existProfileData -eq $true -And $existProfile -eq $false) ) {
                    if (!(Test-Path $pathDevice\PROFILES\$profile)) {
                        Start-Sleep -Seconds $timeoutVerifyProfile
                    } else {
                        $existProfile = $true
                    }
                    if (!(Test-Path $pathDevice\DATA\$profile)) {
                        Start-Sleep -Seconds $timeoutVerifyProfile
                    } else {
                        $existProfileData = $true
                    }
                } else {
                    break
                }
            } while ($counter -le $numberAttempts)

            if ($existProfile) {
                if ($existProfileData) {
                    # Restauracion de Archivos Especificos
                    foreach ($file in $filesArray){
                        Robocopy $pathDevice\DATA\$fileBackupProfile\$file $pathDevice\DATA\$nameFolderData\$file /s /NFL /NDL /NJH /NJS 
                        # Eliminacion de Directorios sobre el Backup
                        #Write-Host "Eliminando: $file"
                        Remove-Item -Recurse -Force -ErrorAction SilentlyContinue $pathDevice\DATA\$fileBackupProfile\$file            
                    }
                    #Write-Host "Tarea finalizada exitosamente."
                    @{OK="Tarea finalizada"} | ConvertTo-Json
                } else {
                    # Restauracion de Todos los Archivos
                    Robocopy $pathDevice\DATA\$fileBackupProfile $pathDevice\DATA\$nameFolderData * /s /NFL /NDL /NJH /NJS
                    #throw "No recreo el perfil: $profile en la ruta: $pathDevice\PROFILES"
                    @{Error="No recreo el perfil: $profile en la ruta: $pathDevice\DATA"} | ConvertTo-Json
                }
            } else {
                # Restauracion de Todos los Archivos
                Robocopy $pathDevice\DATA\$fileBackupProfile $pathDevice\DATA\$nameFolderData * /s /NFL /NDL /NJH /NJS
                #throw "No recreo el perfil: $profile en la ruta: $pathDevice\PROFILES"
                @{Error="No recreo el perfil: $profile en la ruta: $pathDevice\PROFILES"} | ConvertTo-Json
            }
        }
    } else {
        $fileBackupProfile = (ls $pathDevice\DATA\ | Where-Object { $_.LastWriteTime -gt $(Get-Date).AddMinutes(-$timeRecent) } | Sort-Object -Property LastWriteTime -Descending).name | findstr "BK_" | findstr -i $profile | Select -First 1
        if ($fileBackupProfile -eq $Null) {
            @{Error="No existe un backup reciente del perfil: $profile en la ruta: $pathDevice\DATA\"} | ConvertTo-Json
        } else {
            #@{OK="Existe un backup reciente del perfil: $profile en la ruta: $pathDevice\DATA\ que es: $fileBackupProfile"} | ConvertTo-Json
            # Validacion de que se recree automaticamente la carpeta del perfil
            $counter = 0
            $existProfile = $false
            $existProfileData = $false

            # Verifica si el usuario fue creado recientemente en PROFILES y DATA
            $verifyProfileFolderPROFILE = ((ls $pathDevice\PROFILES\ | Where-Object { $_.LastWriteTime -gt $(Get-Date).AddMinutes(-$timeRecent) } | Sort-Object -Property LastWriteTime -Descending).name | findstr /i /x $profile | Measure-Object).Count
            if ( $verifyProfileFolderPROFILE -eq 1) {
                $existProfile = $true
                $existProfileData = $true
            } else {
                # Eliminacion de los Directorios que hacen parte del perfil
                Remove-Item -Recurse -Force -ErrorAction SilentlyContinue $pathDevice\PROFILES\$profile
                Remove-Item -Recurse -Force -ErrorAction SilentlyContinue $pathDevice\DATA\$profile

                do {
                    $counter++
                    if ( ($existProfileData -eq $false -And $existProfile -eq $false) -or ($existProfileData -eq $false -And $existProfile -eq $true) -or ($existProfileData -eq $true -And $existProfile -eq $false) ) {
                        if (!(Test-Path $pathDevice\PROFILES\$profile)) {
                            Start-Sleep -Seconds $timeoutVerifyProfile
                        } else {
                            $existProfile = $true
                        }
                        if (!(Test-Path $pathDevice\DATA\$profile)) {
                            Start-Sleep -Seconds $timeoutVerifyProfile
                        } else {
                            $existProfileData = $true
                        }
                    } else {
                        break
                    }
                } while ($counter -le $numberAttempts)
            }
            
            if ($existProfile) {
                if ($existProfileData) {
                    # Restauracion de Archivos Especificos
                    foreach ($file in $filesArray){
                        Robocopy $pathDevice\DATA\$fileBackupProfile\$file $pathDevice\DATA\$nameFolderData\$file /s /NFL /NDL /NJH /NJS 
                        # Eliminacion de Directorios sobre el Backup
                        Remove-Item -Recurse -Force -ErrorAction SilentlyContinue $pathDevice\DATA\$fileBackupProfile\$file            
                    }
                    #Write-Host "Tarea finalizada exitosamente."
                    @{OK="Tarea finalizada"} | ConvertTo-Json
                } else {
                    # Restauracion de Todos los Archivos
                    Robocopy $pathDevice\DATA\$fileBackupProfile $pathDevice\DATA\$nameFolderData * /s /NFL /NDL /NJH /NJS
                    #throw "No recreo el perfil: $profile en la ruta: $pathDevice\PROFILES"
                    @{Error="No recreo el perfil: $profile en la ruta: $pathDevice\DATA"} | ConvertTo-Json
                }
            } else {
                # Restauracion de Todos los Archivos
                Robocopy $pathDevice\DATA\$fileBackupProfile $pathDevice\DATA\$nameFolderData * /s /NFL /NDL /NJH /NJS
                #throw "No recreo el perfil: $profile en la ruta: $pathDevice\PROFILES"
                @{Error="No recreo el perfil: $profile en la ruta: $pathDevice\PROFILES"} | ConvertTo-Json
            }

            # Eliminacion de Backup
            Remove-Item -Recurse -Force -ErrorAction SilentlyContinue $pathDevice\DATA\$fileBackupProfile
        }
    }
}

function TestConnection{
    #$device = (net use | findstr /i q: | measure-object -line).Lines
    $device = ((Get-PSDrive).Name | Findstr /X Q | Measure-Object -line).Lines
    # Verifica si ya hay una Unidad de Red con la Letra "q:"
    if ($device -eq 1) {
        DeleteUser
    } else {
        #net use q: $pathDevice $pw /user:$user
        $pw = convertto-securestring -AsPlainText -Force -String $pw
        $cred = New-Object -typename System.Management.Automation.PSCredential -argumentlist $user,$pw
        try {
            $statuDevice = (New-PSDrive -Name "Q" -Root $pathDevice  -PSProvider "FileSystem" -Credential $cred -ErrorAction Stop)
            DeleteUser
        }
        catch {
            @{Error=$_.Exception.Message} | ConvertTo-Json
            #Write-Host "Fallo"
        }
    }
}

TestConnection
