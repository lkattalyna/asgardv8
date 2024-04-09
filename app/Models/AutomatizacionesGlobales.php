<?php

namespace App\Models;

use Illuminate\Http\Request;
use DB;

class AutomatizacionesGlobales
{


    public static function getContextSO(){
        return collect([
            ['value' => 'unix' , 'tag' => 'UNIX'],
            ['value' => 'windows' , 'tag' => 'WINDOWS']]
        );
    }

    public static function getAllMainWindows(){
        return collect([
            [
                'value' => 'testConectividad',
                'tag' => 'Test Conectividad',
                'playbooks' => '469'
            ],
            [
                'value' => 'gestionServicios',
                'tag' => 'Gestion Servicios',
                'playbooks' => '262;473'
            ],
            [
                'value' => 'activacionLogsWin',
                'tag' => 'Activación y envio de logs',
                'playbooks' => '484;485'
            ],
            [
                'value' => 'change_WIN',
                'tag' => 'Resetear contraseña',
                'playbooks' => '72'
            ],
            [
                'value' => 'checkCPUProcess_WIN',
                'tag' => 'Reportes de performance de Sistema Operativo',
                'playbooks' => '313'
            ],
            [
                'value' => 'rutasEstaticas_WIN',
                'tag' => 'Rutas Estaticas',
                'playbooks' => '100'
            ],
            [
                'value' => 'extUptime_WIN',
                'tag' => 'ExtUptime',
                'playbooks' => '230'
            ],
            [
                'value' => 'inventario_WIN',
                'tag' => 'Inventario',
                'playbooks' => '120'
            ]

        ]);
    }

    public static function getAllMainUnix(){
        return collect([
            [
                'value' => 'testConectividad_UNIX',
                'tag' => 'Test conectividad',
                'playbooks' => '470'
            ],
            [
                'value' => 'change_UNIX',
                'tag' => 'Resetear contraseña',
                'playbooks' => '55'
            ],
            [
                'value' => 'PHcheckSOUnix',
                'tag' => 'Check Sistema Operativo',
                'playbooks' => '375'
            ],
            [
                'value' => 'gestionServiciosUnix',
                'tag' => 'Gestion de servicios',
                'playbooks' => '357;505'
                // started , stopped, restarted'
            ],
            [
                'value' => 'activacionLogsUnix',
                'tag' => 'Activacion y envio de logs',
                'playbooks' => '508;493'
            ],
            [
                'value' => 'uptimeUnix',
                'tag' => 'Uptime unix',
                'playbooks' => '160'
            ],            
            [
                'value' => 'RutasEstaticasUnix',
                'tag' => 'Rutas Estaticas unix',
                'playbooks' => '122'
            ],
            [
                'value'=> 'inventarioUnix',
                'tag' => 'Inventario unix',
                'playbooks' => '114'
            ],
        ]);
    }


}
