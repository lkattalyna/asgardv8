<?php

namespace App\Providers;

use App\Menus;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        Schema::defaultStringLength(191);
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {

            $menusDB = Menus::getMenus();
            // dump($menusDB);
           foreach( $menusDB as $menu ){
                $event->menu->add($menu);
            }


            // $event->menu->add([
            //     'text' => 'ADMINISTRACIÓN',
            //     'icon' => 'fas fa-key',
            //     'can' => 'administration-menu',
            //     'submenu' => array([
            //         'text' => 'Roles',
            //         'icon' => 'fas fa-lock',
            //         'can' => 'rol-admin',
            //         'url'  => 'roles/',
            //     ], [
            //         'text' => 'Permisos',
            //         'icon' => 'fas fa-lock',
            //         'can' => 'permission-admin',
            //         'url'  => 'permissions/',
            //     ],[
            //         'text' => 'Usuarios',
            //         'icon' => 'fas fa-users',
            //         'can' => 'user-admin',
            //         'url'  => 'users/',
            //     ],[
            //         'text' => 'Automatizaciones',
            //         'icon' => 'fas fa-robot',
            //         'can' => 'regImprovement-menu',
            //         'submenu' => array([
            //             'text' => 'Capas de servicio',
            //             'icon' => 'fas fa-layer-group',
            //             'can' => 'regServiceLayer-admin',
            //             'url'  => 'RegServiceLayers',
            //         ],[
            //             'text' => 'Niveles de cliente',
            //             'icon' => 'fas fa-layer-group',
            //             'can' => 'regCustomerLevel-admin',
            //             'url'  => 'RegCustomerLevels',
            //         ],[
            //             'text' => 'Periodos',
            //             'icon' => 'fas fa-calendar-alt',
            //             'can' => 'regQuarter-admin',
            //             'url'  => 'RegQuarters',
            //         ],[
            //             'text' => 'Segmentos de servicio',
            //             'icon' => 'fas fa-layer-group',
            //             'can' => 'regServiceSegment-admin',
            //             'url'  => 'RegServiceSegments',
            //         ],[
            //             'text' => 'Servicios consumidos',
            //             'icon' => 'fas fa-layer-group',
            //             'can' => 'regConsumedService-admin',
            //             'url'  => 'RegConsumedServices',
            //         ]),
            //     ],[
            //         'text' => 'Desarrollo',
            //         'icon' => 'fas fa-code',
            //         'can' => 'devRequest-menu',
            //         'submenu' => array([
            //             'text' => 'Estados',
            //             'icon' => 'fas fa-traffic-light',
            //             'can' => 'devState-admin',
            //             'url'  => 'dev/devStates',
            //         ],[
            //             'text' => 'Requerimientos',
            //             'icon' => 'fas fa-ticket-alt',
            //             'can' => 'devRequest-admin',
            //             'url'  => 'dev/devRequests/admin',
            //         ],[
            //             'text' => 'Tareas',
            //             'icon' => 'fas fa-tasks',
            //             'can' => 'devTask-admin',
            //             'url'  => 'dev/devTasks',
            //         ]),
            //     ],[
            //         'text' => 'Logs de login',
            //         'icon' => 'fas fa-clipboard-check',
            //         'can' => 'loginLog-admin',
            //         'url'  => 'loginLogs/',
            //     ],[
            //         'text' => 'Logs de sincronización',
            //         'icon' => 'fas fa-clipboard-check',
            //         'can' => 'syncLog-admin',
            //         'url'  => 'syncLogs/',
            //     ]),
            // ]);
            // $event->menu->add([
            //     'text' => 'GESTION',
            //     'icon' => 'fas fa-tools',
            //     'can' => 'gestion-menu',
            //     'submenu' => array([
            //         'text' => 'Automatizaciones',
            //         'icon' => 'fas fa-robot',
            //         'can' => 'regImprovement-user',
            //         'url'  => 'improvements',
            //     ],/*[
            //         'text' => 'Automatizaciones 2021',
            //         'icon' => 'fas fa-robot',
            //         'can' => 'regImprovement-user',
            //         'url'  => 'regImprovementMin',
            //     ],*/[
            //         'text' => 'Documentación',
            //         'icon' => 'fas fa-book',
            //         'can' => 'documentation-menu',
            //         'url'  => 'documentations/',
            //     ],[
            //         'text' => 'Grupos SO',
            //         'icon' => 'fas fa-sitemap',
            //         'can' => 'OsGroup-admin',
            //         'url'  => 'osGroups/',
            //     ],[
            //         'text' => 'Inventarios',
            //         'icon' => 'fas fa-clipboard-list',
            //         'can' => 'inventory-menu',
            //         'url'  => 'inventories/',
            //     ],[
            //         'text' => 'Mis requerimientos',
            //         'icon' => 'fas fa-ticket-alt',
            //         'can' => 'devRequest-user',
            //         'url'  => 'dev/devRequests',
            //     ],[
            //         'text' => 'Templates AWX',
            //         'icon' => 'fas fa-clipboard',
            //         'can' => 'awxTemplate-admin',
            //         'url'  => 'awxTemplates/',
            //     ],[
            //         'text' => 'Vcenters',
            //         'icon' => 'fas fa-cloud-meatball',
            //         'can' => 'awxTemplate-admin',
            //         'url'  => 'vcenters/',
            //     ]),
            // ]);
            // $event->menu->add('SOPORTE DC');
            // $event->menu->add([
            //     'text' => 'SOPORTE E&N',
            //     'icon' => 'far fa-circle',
            //     'can' => 'supportEN-menu',
            //     'submenu' => array([
            //         'text' => 'AMT',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'supportEN-menu',
            //         'url'  => '#',
            //     ],[
            //         'text' => 'Balanceadores',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'supportEN-menu',
            //         'url'  => '#',
            //     ],[
            //         'text' => 'Oracle',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'supportEN-menu',
            //         'url'  => '#',
            //     ],[
            //         'text' => 'Unix',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'supportEN-menu',
            //         'url'  => '#',
            //     ],[
            //         'text' => 'Sql',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'supportEN-menu',
            //         'url'  => '#',
            //     ],[
            //         'text' => 'Windows',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'supportEN-menu',
            //         'submenu' => array([
            //             'text' => 'Check AD',
            //             'icon' => 'fas fa-check-double',
            //             'can' =>  'supportEN-menu',
            //             'url'  => 'supportEN/windows/checkAD',
            //         ],[
            //             'text' => 'Check procesos CPU',
            //             'icon' => 'fas fa-check-double',
            //             'can' =>  'supportEN-menu',
            //             'url'  => 'supportEN/windows/checkCPUProcess',
            //         ],[
            //             'text' => 'Check Sistema Operativo',
            //             'icon' => 'fas fa-check-double',
            //             'can'  => 'supportEN-menu',
            //             'url'  => 'supportEN/windows/checkSO',
            //         ],[
            //             'text' => 'Check S.O',
            //             'icon' => 'fas fa-shoe-prints',
            //             'can' => 'supportEN-menu',
            //             'submenu' => array([
            //                 'text' => 'Pre-Ventana',
            //                 'icon' => 'fas fa-step-backward',
            //                 'can' => 'supportEN-menu',
            //                 'url'  => 'supportEN/windows/preVentana',
            //             ],[
            //                 'text' => 'Post-Ventana',
            //                 'icon' => 'fas fa-step-forward',
            //                 'can' => 'supportEN-menu',
            //                 'url'  => 'supportEN/windows/postVentana',
            //             ]),
            //         ],[
            //             'text' => 'Depuración de memoria',
            //             'icon' => 'fas fa-memory',
            //             'can'  => 'supportEN-menu',
            //             'url'  => 'supportEN/windows/freeMemory',
            //         ],[
            //             'text' => 'Depuración de discos',
            //             'icon' => 'fas fa-hdd',
            //             'can'  => 'supportEN-menu',
            //             'url'  => 'supportEN/windows/debuggingDisks',
            //         ],[
            //             'text' => 'PLK - 7 Pasos - Windows',
            //             'icon' => 'fas fa-shoe-prints',
            //             'can' => 'supportEN-menu',
            //             'url'  => 'supportEN/windows/sevenSteps',
            //         ],[
            //             'text' => 'Gestión de servicios',
            //             'icon' => 'fas fa-check-double',
            //             'can' =>  'supportEN-menu',
            //             'url'  => 'pass/windows/services',
            //         ],[
            //             'text' => 'Gestión de usuarios',
            //             'icon' => 'fas fa-user',
            //             'can' => 'supportEN-menu',
            //             'submenu' => array([
            //                 'text' => 'Crear usuarios',
            //                 'icon' => 'fas fa-user-plus',
            //                 'can' => 'supportEN-menu',
            //                 'url'  => 'supportEN/windows/createUser',
            //             ],[
            //                 'text' => 'Cambiar password',
            //                 'icon' => 'fas fa-user-edit',
            //                 'can' => 'supportEN-menu',
            //                 'url'  => 'supportEN/windows/changeUser',
            //             ],[
            //                 'text' => 'Deshabilitar usuario',
            //                 'icon' => 'fas fa-user-slash',
            //                 'can' => 'supportEN-menu',
            //                 'url'  => 'supportEN/windows/disableUser',
            //             ],[
            //                 'text' => 'Eliminar usuario',
            //                 'icon' => 'fas fa-user-times',
            //                 'can' => 'supportEN-menu',
            //                 'url'  => 'supportEN/windows/deleteUser',
            //             ],[
            //                 'text' => 'Modificar usuario',
            //                 'icon' => 'fas fa-user-edit',
            //                 'can' => 'supportEN-menu',
            //                 'url'  => 'supportEN/windows/editUser',
            //             ]),
            //         ],[
            //             'text' => 'Extracción de Parches',
            //             'icon' => 'fas fa-external-link-alt',
            //             'can' => 'supportEN-menu',
            //             'url'  => 'supportEN/windows/extParches',
            //         ],[
            //             'text' => 'Extracción de uptime',
            //             'icon' => 'fas fa-external-link-alt',
            //             'can' => 'supportEN-menu',
            //             'url'  => 'supportEN/windows/extUptime',
            //         ],[
            //             'text' => 'Inventario Windows',
            //             'icon' => 'fas fa-list',
            //             'can' => 'supportEN-menu',
            //             'url'  => 'supportEN/windows/inventario',
            //         ],[
            //             'text' => 'Rutas Estáticas',
            //             'icon' => 'fas fa-route',
            //             'can' => 'supportEN-menu',
            //             'url'  => 'supportEN/windows/rutasEstaticas',
            //         ]),
            //     ]),

            //     ],[
            //     'text' => 'SOPORTE P&H',
            //     'icon' => 'far fa-circle',
            //     'can' => 'supportPH-menu',
            //     'submenu' => array([
            //         'text' => 'AMT',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'supportPH-menu',
            //         'url'  => '#',
            //     ],[
            //         'text' => 'Balanceadores',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'supportPH-menu',
            //         'url'  => '#',
            //     ],[
            //         'text' => 'Oracle',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'supportPH-menu',
            //         'url'  => '#',
            //     ],[
            //         'text' => 'Unix',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'supportPH-menu',
            //         'url'  => '#',
            //         'submenu' => array([
            //             'text' => 'Check Sistema Operativo',
            //             'icon' => 'fas fa-shoe-prints',
            //             'can' =>  'supportPH-menu',
            //             'url'  => 'supportPH/linux/checkUnixPH',
            //         ]),
            //     ],[
            //         'text' => 'Sql',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'supportPH-menu',
            //         'url'  => '#',
            //     ],[
            //         'text' => 'Windows',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'supportPH-menu',
            //         'submenu' => array([
            //             'text' => 'Check Sistema Operativo',
            //             'icon' => 'fas fa-shoe-prints',
            //             'can' =>  'supportPH-menu',
            //             'url'  => 'supportPH/windows/checkWindowsPH',
            //         ]/*,[
            //             'text' => 'Check AD',
            //             'icon' => 'fas fa-check-double',
            //             'can' =>  'supportDC-menu',
            //             'url'  => 'supportPH/windows/checkAD',
            //         ]*/),

            //     ]),
            // ]);
            // $event->menu->add('CAPAS DE APLICACIÓN');
            // $event->menu->add([
            //     'text' => 'POLIEDRO',
            //     'icon' => 'far fa-circle',
            //     'can' => 'poliedro-menu',
            //     'submenu' => array([
            //         'text' => 'Grupo de Servicio NS',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'balancer-mixed',
            //         'url'  => 'balancers/grupoServicioNS',
            //     ],[
            //         'text' => 'Nodo NS',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'balancer-mixed',
            //         'url'  => 'balancers/nodoNS',
            //     ],[
            //         'text' => 'Reinicio IIS Com',
            //         'icon' => 'fas fa-power-off',
            //         'can' => 'windowsPH-mixed',
            //         'url'  => 'windowsPH/restartIISCom',
            //     ],[
            //         'text' => 'Reinicio Pool Com',
            //         'icon' => 'fas fa-power-off',
            //         'can' => 'windowsPH-mixed',
            //         'url'  => 'windowsPH/restartPoolCom',
            //     ]),
            // ]);
            // $event->menu->add('CAPAS DE SERVICIO');
            // $event->menu->add([
            //     'text' => 'AMT',
            //     'icon' => 'far fa-circle',
            //     'can' => 'amt-menu',
            //     'submenu' => array([
            //         'text' => 'AMT E&N',
            //         'icon' => 'far fa-circle',
            //         'can' => 'amt-menu',
            //         'submenu' => array(
            //             [
            //                 'text' => 'App Tomcat Unix',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amt-mixed',
            //                 'url'  => 'amt/appTomcatUnix',
            //             ],[
            //                 'text' => 'App Tomcat Unix PCCAAS',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amt-mixed',
            //                 'url'  => 'amt/appTomcatUnixPCCAAS',
            //             ],[
            //                 'text' => 'App Tomcat Windows',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amt-user',
            //                 'url'  => 'amt/appTomcatWindows',
            //             ],[
            //                 'text' => 'Backup Formas',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amt-mixed',
            //                 'url'  => 'amt/backupFormas',
            //             ],[
            //                 'text' => 'Check P.O. Tomcat',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amt-mixed',
            //                 'url'  => 'amt/checkPasoTomcat',
            //             ],[
            //                 'text' => 'Check P.O. WebLogic',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amt-mixed',
            //                 'url'  => 'amt/checkPOWebLogic',
            //             ],/*[
            //                 ///Sin uso
            //                 'text' => 'Check Sanidad Weblogic',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amt-mixed',
            //                 'url'  => 'amt/checkSanidad',
            //             ],*/[
            //                 'text' => 'Connect DB',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amt-user',
            //                 'url'  => 'amt/connectDB',
            //             ],[
            //                 'text' => 'Health Check AMT',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amt-user',
            //                 'url'  => 'amt/healthCheck',
            //             ],[
            //                 'text' => 'Movimiento Formas',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amt-mixed',
            //                 'url'  => 'amt/movimientoFormas',
            //             ],[
            //                 'text' => 'Parche Weblogic',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amt-user',
            //                 'url'  => 'amt/parcheWeblogic',
            //             ],[
            //                 'text' => 'Reinicio FUSE',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amt-user',
            //                 'url'  => 'amt/fuse',
            //             ],[
            //                 'text' => 'Reinicio SOA',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amt-user',
            //                 'url'  => 'amt/soa',
            //             ],[
            //                 'text' => 'Reporte Weblogic',
            //                 'icon' => 'fas fa-file-word',
            //                 'can' => 'amt-user',
            //                 'url'  => 'amt/webReports',
            //             ]),
            //     ],[
            //         'text' => 'AMT P&H',
            //         'icon' => 'far fa-circle',
            //         'can' => 'amtPH-menu',
            //         'submenu' => array(
            //             [
            //                 'text' => 'Alarma_stuck FulESB',
            //                 'icon' => 'fas fa-bell',
            //                 'can' => 'amtPH-admin',
            //                 'url'  => 'amtPH/ESBAlarm',
            //             ],
            //             [
            //                 'text' => 'Bajada de dominio',
            //                 'icon' => 'fas fa-arrow-alt-circle-down',
            //                 'can' => 'amtPH-admin',
            //                 'url'  => 'amtPH/bajadaDominio',
            //             ],[
            //                 'text' => 'Depurar F5 Logs Glasfish',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amtPHIT-admin',
            //                 'url'  => 'amtPHIT/depFileSystem',
            //             ],[
            //                 'text' => 'Depurar F5 WebService',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amtPHIT-admin',
            //                 'url'  => 'amtPHIT/depFileWebService',
            //             ],[
            //                 'text' => 'Depurar Logs Glasfish Unix',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amtPHIT-admin',
            //                 'url'  => 'amtPHIT/depLogsGlasfish',
            //             ],[
            //                 'text' => 'Despliegue Agendamiento',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amtPHIT-admin',
            //                 'url'  => 'amtPHIT/papAgendamiento',
            //             ],[
            //                 'text' => 'Despliegue 89 MC',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amtPHIT-admin',
            //                 'url'  => 'amtPHIT/despliegueMC',
            //             ],[
            //                 'text' => 'Desp. Call Center Cluster',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amtPHIT-admin',
            //                 'url'  => 'amtPHIT/despCallCenter',
            //             ],[
            //                 'text' => 'Revisión memoria y cpu',
            //                 'icon' => 'fas fa-microchip',
            //                 'can' => 'amtPH-admin',
            //                 'url'  => 'amtPHIT/diagnosticMC',
            //             ],[
            //                 'text' => 'Despliegue Venta Cluster',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amtPHIT-admin',
            //                 'url'  => 'amtPHIT/despliegueVentas',
            //             ],[
            //                 'text' => 'Despliegue PCML Cluster',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amtPHIT-admin',
            //                 'url'  => 'amtPHIT/desplieguePCML',
            //             ],[
            //                 'text' => 'DesplieguePostVentaCluster',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amtPHIT-admin',
            //                 'url'  => 'amtPHIT/desplieguePostVenta',
            //             ],[
            //                 'text' => 'Desp. Venta Técnica Cluster',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amtPHIT-admin',
            //                 'url'  => 'amtPHIT/ventaTecnica',
            //             ],[
            //                 'text' => 'Desp. WoService Cluster',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amtPHIT-admin',
            //                 'url'  => 'amtPHIT/woService',
            //             ],[
            //                 'text' => 'Estadística de los datasource',
            //                 'icon' => 'fas fa-chart-bar',
            //                 'can' => 'amtPH-admin',
            //                 'url'  => 'amtPH/estDataSource',
            //             ],[
            //                 'text' => 'Estado Itel Venecia',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amtPH-admin',
            //                 'url'  => 'amtPH/ITELState',
            //             ],[
            //                 'text' => 'Itel',
            //                 'icon' => 'fas fa-server',
            //                 'can' => 'amtPH-admin',
            //                 'submenu' => array([
            //                     'text' => 'Venecia',
            //                     'icon' => 'fas fa-industry',
            //                     'can' => 'amtPH-admin',
            //                     'submenu' => array([
            //                         'text' => 'OSB',
            //                         'icon' => 'fas fa-list',
            //                         'can' => 'amtPH-admin',
            //                         'submenu' => array([
            //                             'text' => 'Bajada',
            //                             'icon' => 'fas fa-arrow-circle-down',
            //                             'can' => 'amtPH-admin',
            //                             'url'  => 'amtPH/ITELVeneciaDown',
            //                         ],[
            //                             'text' => 'Subida',
            //                             'icon' => 'fas fa-arrow-circle-up',
            //                             'can' => 'amtPH-admin',
            //                             'url'  => 'amtPH/ITELVeneciaUp',
            //                         ]),
            //                         ],[
            //                             'text' => 'SOA',
            //                             'icon' => 'fas fa-list',
            //                             'can' => 'amtPH-admin',
            //                             'submenu' => array([
            //                                 'text' => 'Bajada',
            //                                 'icon' => 'fas fa-arrow-circle-down',
            //                                 'can' => 'amtPH-admin',
            //                                 'url'  => 'amtPH/ITELVeneciaSoaDown',
            //                             ],[
            //                                 'text' => 'Subida',
            //                                 'icon' => 'fas fa-arrow-circle-up',
            //                                 'can' => 'amtPH-admin',
            //                                 'url'  => 'amtPH/ITELVeneciaSoaUp',
            //                         ]),
            //                         ],[
            //                             'text' => 'PCA',
            //                             'icon' => 'fas fa-list',
            //                             'can' => 'amtPH-admin',
            //                             'submenu' => array([
            //                                 'text' => 'Bajada',
            //                                 'icon' => 'fas fa-arrow-circle-down',
            //                                 'can' => 'amtPH-admin',
            //                                 'url'  => '#',
            //                         ]),
            //                         ],[
            //                             'text' => 'BRE',
            //                             'icon' => 'fas fa-list',
            //                             'can' => 'amtPH-admin',
            //                             'submenu' => array([
            //                                 'text' => 'Bajada',
            //                                 'icon' => 'fas fa-arrow-circle-down',
            //                                 'can' => 'amtPH-admin',
            //                                 'url'  => '#',
            //                         ]),
            //                         ],[
            //                             'text' => 'FINEQ',
            //                             'icon' => 'fas fa-list',
            //                             'can' => 'amtPH-admin',
            //                             'submenu' => array([
            //                                 'text' => 'Bajada',
            //                                 'icon' => 'fas fa-arrow-circle-down',
            //                                 'can' => 'amtPH-admin',
            //                                 'url'  => '#',
            //                         ]),
            //                         ],[
            //                             'text' => 'APROV',
            //                             'icon' => 'fas fa-list',
            //                             'can' => 'amtPH-admin',
            //                             'submenu' => array([
            //                                 'text' => 'Bajada',
            //                                 'icon' => 'fas fa-arrow-circle-down',
            //                                 'can' => 'amtPH-admin',
            //                                 'url'  => '#',
            //                             ]),
            //                         ],[
            //                             'text' => 'PROCESOS CLOUD',
            //                             'icon' => 'fas fa-list',
            //                             'can' => 'amtPH-admin',
            //                             'submenu' => array([
            //                                 'text' => 'Bajada',
            //                                 'icon' => 'fas fa-arrow-circle-down',
            //                                 'can' => 'amtPH-admin',
            //                                 'url'  => 'amtPH/downCloudVenecia',
            //                             ],[
            //                                 'text' => 'Subida',
            //                                 'icon' => 'fas fa-arrow-circle-up',
            //                                 'can' => 'amtPH-admin',
            //                                 'url'  => 'amtPH/upCloudVenecia',
            //                             ]),

            //                         ]),


            //                 ],[
            //                     'text' => 'Triara',
            //                     'icon' => 'fas fa-industry',
            //                     'can' => 'amtPH-admin',
            //                     'submenu' => array([
            //                         'text' => 'OSB',
            //                         'icon' => 'fas fa-list',
            //                         'can' => 'amtPH-admin',
            //                         'submenu' => array([
            //                             'text' => 'Bajada',
            //                             'icon' => 'fas fa-arrow-circle-down',
            //                             'can'  => 'amtPH-admin',
            //                             'url'  => 'amtPH/ITELTriaraDown',
            //                             ],[
            //                             'text' => 'Subida',
            //                             'icon' => 'fas fa-arrow-circle-up',
            //                             'can' => 'amtPH-admin',
            //                             'url'  => 'amtPH/ITELTriaraUp',
            //                         ]),
            //                         ],[
            //                             'text' => 'SOA',
            //                             'icon' => 'fas fa-list',
            //                             'can' => 'amtPH-admin',
            //                             'submenu' => array([
            //                                 'text' => 'Bajada',
            //                                 'icon' => 'fas fa-arrow-circle-down',
            //                                 'can' => 'amtPH-admin',
            //                                 'url'  => 'amtPH/downSoaTriara',
            //                             ],[
            //                                 'text' => 'Subida',
            //                                 'icon' => 'fas fa-arrow-circle-up',
            //                                 'can'  => 'amtPH-admin',
            //                                 'url'  => 'amtPH/ITELTriaraSoaUp',
            //                         ]),
            //                         ],[
            //                             'text' => 'PCA',
            //                             'icon' => 'fas fa-list',
            //                             'can' => 'amtPH-admin',
            //                             'submenu' => array([
            //                                 'text' => 'Bajada',
            //                                 'icon' => 'fas fa-arrow-circle-down',
            //                                 'can' => 'amtPH-admin',
            //                                 'url'  => '#',
            //                         ]),
            //                         ],[
            //                             'text' => 'BRE',
            //                             'icon' => 'fas fa-list',
            //                             'can' => 'amtPH-admin',
            //                             'submenu' => array([
            //                                 'text' => 'Bajada',
            //                                 'icon' => 'fas fa-arrow-circle-down',
            //                                 'can' => 'amtPH-admin',
            //                                 'url'  => '#',
            //                         ]),
            //                         ],[
            //                             'text' => 'FINEQ',
            //                             'icon' => 'fas fa-list',
            //                             'can' => 'amtPH-admin',
            //                             'submenu' => array([
            //                                 'text' => 'Bajada',
            //                                 'icon' => 'fas fa-arrow-circle-down',
            //                                 'can' => 'amtPH-admin',
            //                                 'url'  => '#',
            //                         ]),
            //                         ],[
            //                             'text' => 'APROV',
            //                             'icon' => 'fas fa-list',
            //                             'can' => 'amtPH-admin',
            //                             'submenu' => array([
            //                                 'text' => 'Bajada',
            //                                 'icon' => 'fas fa-arrow-circle-down',
            //                                 'can' => 'amtPH-admin',
            //                                 'url'  => 'amtPH/ITELTriaraAprovDown',
            //                             ],[
            //                                 'text' => 'Subida',
            //                                 'icon' => 'fas fa-arrow-circle-up',
            //                                 'can' => 'amtPH-admin',
            //                                 'url'  => 'amtPH/ITELTriaraAprovUp',
            //                         ]),
            //                         ],[
            //                             'text' => 'PROCESOS CLOUD',
            //                             'icon' => 'fas fa-list',
            //                             'can' => 'amtPH-admin',
            //                             'submenu' => array([
            //                                 'text' => 'Bajada',
            //                                 'icon' => 'fas fa-arrow-circle-down',
            //                                 'can' => 'amtPH-admin',
            //                                 'url'  => 'amtPH/downCloudTriara',
            //                             ],[
            //                                 'text' => 'Subida',
            //                                 'icon' => 'fas fa-arrow-circle-up',
            //                                 'can' => 'amtPH-admin',
            //                                 'url'  => 'amtPH/upCloudTriara',
            //                         ]),
            //                     ]),
            //                 ]),
            //             ],[
            //                 'text' => 'Purgue Colas AssurIn',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amtPH-admin',
            //                 'url'  => 'amtPH/jobPurge',
            //             ],[
            //                 'text' => 'ReinicioApacheAgendamiento',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amtPHIT-admin',
            //                 'url'  => 'amtPHIT/reinicioAgendamiento',
            //             ],[
            //                 'text' => 'Reinicio Cluster EAP',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amtPH-admin',
            //                 'url'  => 'amtPH/reinicioClusterEAP',
            //             ],[
            //                 'text' => 'Reinicio Datos Comp',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amtPH-admin',
            //                 'url'  => 'amtPH/reinicioDatosComp',
            //             ],[
            //                 'text' => 'Reinicio Dom. Trafico',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amtPH-admin',
            //                 'url'  => 'amtPH/reinicioDomTrafico',
            //             ],[
            //                 'text' => 'Reinicio Escalonado',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amtPH-mixed',
            //                 'url'  => 'amtPH/reinicioEscalonado',
            //             ],[
            //                 'text' => 'Reinicio Itel Osb Venecia',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amtPH-admin',
            //                 'url'  => 'amtPH/ITELRestart',
            //             ],[
            //                 'text' => 'Reinicio Visor',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amtPHIT-admin',
            //                 'url'  => 'amtPHIT/reinicioVisor',
            //             ],[
            //                 'text' => 'Reinicio WebService',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amtPHIT-admin',
            //                 'url'  => 'amtPHIT/reinicioWebService',
            //             ],[
            //                 'text' => 'Subida de dominio',
            //                 'icon' => 'fas fa-arrow-alt-circle-up',
            //                 'can' => 'amtPH-admin',
            //                 'url'  => 'amtPH/subidaDominio',
            //             ],[
            //                 'text' => 'Reinicio Itel Osb Triara',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amtPH-admin',
            //                 'url'  => 'amtPH/ITELOsbTriara',
            //             ],[
            //                 'text' => 'Consulta Nodo Manager EAP',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amtPH-admin',
            //                 'url'  => 'amtPH/stateEAP',
            //             ],[
            //                 'text' => 'Diagnóstico Dominios EAP',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amtPH-admin',
            //                 'url'  => 'amtPH/errorEAP',
            //             ],[
            //                 'text' => 'Diagnóstico Datasource BSCS',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'amtPH-admin',
            //                 'url'  => 'amtPH/diagEapBSCS',
            //             ],/*[
            //                 'text' => 'Bajada Soa Triara',
            //                 'icon' => 'fas fa-arrow-alt-circle-down',
            //                 'can' => 'amtPH-admin',
            //                 'url'  => 'amtPH/downSoaTriara',
            //             ],*/

            //         )
            //     ]),
            // ]);
            // $event->menu->add([
            //     'text' => 'BACKUP',
            //     'icon' => 'far fa-circle',
            //     'can' => 'backup-menu',
            //     /// Sin uso
            //     /*'text' => 'Check 1N Unix',
            //     'icon' => 'fas fa-check-double',
            //     'can' => 'backup-mixed',
            //     'url'  => 'backup/checkPUnix',*/

            //     'submenu' => array([
            //         'text' => 'Check 1N Win',
            //         'icon' => 'fas fa-check-double',
            //         'can' => 'backup-mixed',
            //         'url'  => 'backup/checkPWindows',
            //     ],[
            //         'text' => 'Maestro de fallas',
            //         'icon' => 'fas fa-check-double',
            //         'can' => 'backup-user',
            //         'url'  => 'backup/failedMaster',
            //     ],[
            //         'text' => 'Ping desde CS02-CAP-TRIARA',
            //         'icon' => 'fas fa-project-diagram',
            //         'can' => 'backup-mixed',
            //         'url'  => 'backup/pingCS02',
            //     ],[
            //         'text' => 'Revisión ventana',
            //         'icon' => 'fas fa-check-double',
            //         'can' => 'backup-user',
            //         'url'  => 'backup/backupTask',
            //     ],[
            //         'text' => 'Schedule de la Movil',
            //         'icon' => 'fas fa-check-double',
            //         'can' => 'backup-user',
            //         'url'  => 'backup/scheduleMovil',
            //     ],[
            //         'text' => 'Transporte VADP',
            //         'icon' => 'fas fa-check-double',
            //         'can' => 'backup-user',
            //         'url'  => 'backup/vadp',
            //     ],[
            //         'text' => 'Jobs Commvault',
            //         'icon' => 'fas fa-cog',
            //         'can' => 'backup-user',
            //         'url'  => 'backup/jobs',
            //     ]),
            // ]);
            // $event->menu->add([
            //     'text' => 'BALANCEADORES',
            //     'icon' => 'far fa-circle',
            //     'can' => 'balancer-menu',
            //     'submenu' => array([
            //         'text' => 'Adición de servidor NS',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'balancer-user',
            //         'url'  => 'balancers/addServerNS',
            //     ],[
            //         'text' => 'Adición Member_Service NS',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'balancer-user',
            //         'url'  => 'balancers/addServiceMemberNS',
            //     ],[
            //         'text' => 'Reporte Member_Service LB-VS NS',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'balancer-user',
            //         'url'  => 'balancers/reportMemberLB',
            //     ],[
            //         'text' => 'Reporte Inventario LB-VS',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'balancer-user',
            //         'url'  => 'balancers/reportInventoryLB',
            //     ],[
            //         'text' => 'Creación VS F5',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'balancer-user',
            //         'url'  => 'balancers/addVSF5',
            //     ],[
            //         'text' => 'Creación VS NS',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'balancer-user',
            //         'url'  => 'balancers/addVSNS',
            //     ],[
            //         'text' => 'Creación Vlan y Selfip F5',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'balancer-user',
            //         'url'  => 'balancers/addVlanSelfipF5',
            //     ],[
            //         'text' => 'Gestión zonas GTM F5',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'balancer-user',
            //         'url'  => 'balancers/nodosGTMF5',
            //     ],[
            //         'text' => 'Grupo de Servicio NS',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'balancer-mixed',
            //         'url'  => 'balancers/grupoServicioNS',
            //     ],[
            //         'text' => 'Health Check NS',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'balancer-user',
            //         'url'  => 'balancers/healthCheckNS',
            //     ],[
            //         'text' => 'Health Check F5',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'balancer-user',
            //         'url'  => 'balancers/healthCheckF5',
            //     ],[
            //         'text' => 'Nodo F5',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'balancer-user',
            //         'url'  => 'balancers/nodoF5',
            //     ],[
            //         'text' => 'Nodo NS',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'balancer-mixed',
            //         'url'  => 'balancers/nodoNS',
            //     ],[
            //         'text' => 'Perfil SSL F5',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'balancer-user',
            //         'url'  => 'balancers/perfilSSLF5',
            //     ],[
            //         'text' => 'Puertos F5',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'balancer-user',
            //         'url'  => 'balancers/adminPuertosF5',
            //     ],[
            //         'text' => 'Request F5',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'balancer-user',
            //         'url'  => 'balancers/requestF5',
            //     ],[
            //         'text' => 'Request_CSR NS',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'balancer-user',
            //         'url'  => 'balancers/requestNS',
            //     ],[
            //         'text' => 'Servicio NS',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'balancer-user',
            //         'url'  => 'balancers/servicioNS',
            //     ],[
            //         'text' => 'Upload_CER NS',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'balancer-user',
            //         'url'  => 'balancers/sslCertNS',
            //     ],/*[
            //         //No uso
            //         'text' => 'Uptime F5',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'balancer-user',
            //         'url'  => 'balancers/uptimeF5',
            //     ],*/[
            //         'text' => 'Información VisorMobile',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'balancer-user',
            //         'url'  => 'balancers/visorMobile',
            //     ],[
            //         'text' => 'Reporte Visor Único NS',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'balancer-user',
            //         'url'  => 'balancers/visorUnique',
            //     ],[
            //         'text' => 'Creación SNIP NS',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'balancer-user',
            //         'url'  => 'balancers/addSnipNS',
            //     ],[
            //         'text' => 'Creación VLAN NS',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'balancer-user',
            //         'url'  => 'balancers/addVlanCitrix',
            //     ],[
            //         'text' => 'Servicio Tennis_NOW_8083 NS',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'balancer-user',
            //         'url'  => 'balancers/stateTennis',
            //     ],[
            //         'text' => 'Servidor FIDUOCCIDENTE NS',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'balancer-user',
            //         'url'  => 'balancers/servFiduoccNS',
            //     ]),
            // ]);
            // $event->menu->add([
            //     'text' => 'CHECK PASO OPERACIÓN',
            //     'icon' => 'far fa-circle',
            //     'can' => 'pasosOP-menu',
            //     'submenu' => array(/*[
            //         'text' => 'UNIX',
            //         'icon' => 'far fa-circle',
            //         'can' => 'executionLog-menu',
            //         'url'  => '#',
            //     ],*/[
            //         'text' => 'VIRTUALIZACIÓN',
            //         'icon' => 'fas fa-arrow-circle-right',
            //         'can' => 'executionLog-menu',
            //         'submenu' => array([
            //             'text' => 'Paso a operación VM',
            //             'icon' => 'fas fa-thumbs-up',
            //             'can' => 'pasosOP-admin',
            //             'url'  => 'virtualizations/operationStep',
            //         ],[
            //             'text' => 'Paso a operación Host',
            //             'icon' => 'fas fa-thumbs-up',
            //             'can' => 'pasosOP-admin',
            //             'url'  => 'virtualizations/checkHost',
            //         ]),
            //     ]/*,[
            //         'text' => 'WINDOWS',
            //         'icon' => 'far fa-circle',
            //         'can' => 'executionLog-menu',
            //         'submenu' => array(
            //             [
            //                 'text' => 'E&N',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'executionLog-menu',
            //                 'url'  => '#',
            //             ],[
            //                 'text' => 'P&H',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'executionLog-menu',
            //                 'url'  => '#',
            //         ]),
            //     ]*/),
            // ]);

            // $event->menu->add([
            //     'text' => 'CLOUD',
            //     'icon' => 'far fa-circle',
            //     'can' => 'cloud-menu',
            //     'submenu' => array([
            //         'text' => 'API Agregar cuentas',
            //         'icon' => 'fas fa-user-plus',
            //         'can' => 'cloud-user',
            //         'url'  => 'cloud/accountAdd',
            //     ]/*,[
            //         //No uso
            //         'text' => 'Reinicio de servicios',
            //         'icon' => 'fas fa-sync',
            //         'can' => 'cloud-user',
            //         'url'  => 'cloud/serviceRestart',
            //     ]*/),
            // ]);
            // $event->menu->add([
            //     'text' => 'DESPLIEGUE IaaS',
            //     'icon' => 'far fa-circle',
            //     'can' => 'implementation-menu',
            //     'submenu' => array([
            //         'text' => 'Windows',
            //         'icon' => 'fas fa-arrow-right',
            //         'can' => 'implementation-menu',
            //         'submenu' => array(/*[
            //             //No uso
            //             'text' => 'Antivirus',
            //             'icon' => 'fas fa-shield-alt',
            //             'can' => 'implementation-user',
            //             'url'  => 'implementations/antivirusW',
            //         ],*/[
            //             'text' => 'Check paso a operación V2',
            //             'icon' => 'fas fa-check-double',
            //             'can' => 'implementation-user',
            //             'url'  => 'implementations/checkPasoWin',
            //         ],[
            //             'text' => 'Hardening',
            //             'icon' => 'fas fa-tasks',
            //             'can' => 'implementation-user',
            //             'url'  => 'implementations/hardeningW',
            //         ],[
            //             'text' => 'Instalación Cisco Tetration',
            //             'icon' => 'fas fa-download',
            //             'can' => 'implementation-user',
            //             'url'  => 'implementations/tetrationW',
            //         ],[
            //             'text' => 'Licenciamiento',
            //             'icon' => 'fas fa-id-badge',
            //             'can' => 'implementation-user',
            //             'url'  => 'implementations/licenciamientoW',
            //         ],[
            //             'text' => 'Normalización',
            //             'icon' => 'fas fa-check-square',
            //             'can' => 'implementation-user',
            //             'url'  => 'implementations/normalizacionW',
            //         ]),
            //     ],[
            //         'text' => 'Linux',
            //         'icon' => 'fas fa-arrow-right',
            //         'can' => 'implementation-menu',
            //         'submenu' => array([
            //             'text' => 'Check paso a operación',
            //             'icon' => 'fas fa-check-double',
            //             'can' => 'implementation-user',
            //             'url'  => 'implementations/checkPasoUnix',
            //         ]),
            //     ],[
            //         'text' => 'Virtualización',
            //         'icon' => 'fas fa-arrow-right',
            //         'can' => 'implementation-menu',
            //         'submenu' => array([
            //             'text' => 'Reporte Cluster Capacity ',
            //             'icon' => 'fas fa-file-invoice',
            //             'can' => 'implementation-user',
            //             'url'  => 'virtualizations/clusterCapacityReport',
            //         ],[
			// 			'text' => 'Aumento de recursos',
			// 			'icon' => 'fas fa-chalkboard-teacher',
			// 			'can' => 'implementation-user',
			// 			'url'  => 'virtualizations/resourcesUpgrade',
			// 		  ],[
            //             'text' => 'Cambio de Vlan',
            //             'icon' => 'fas fa-chalkboard-teacher',
            //             'can' => 'implementation-user',
            //             'url'  => 'virtualizations/vlanUpdate',
            //         ],[
            //             'text' => 'Snapshots',
            //             'icon' => 'fas fa-camera',
            //             'can' => 'implementation-user',
            //             'submenu' => array([
            //                 'text' => 'Toma de snapshot',
            //                 'icon' => 'fas fa-plus-square',
            //                 'can' => 'implementation-user',
            //                 'url'  => 'virtualizations/snapshots/create',
            //             ],[
            //                 'text' => 'Programar snapshot',
            //                 'icon' => 'fas fa-plus-square',
            //                 'can' => 'implementation-user',
            //                 'url'  => 'virtualizations/snapshots/schedule',
            //             ],[
            //                 'text' => 'Borrado de snapshot',
            //                 'icon' => 'fas fa-minus-square',
            //                 'can' => 'implementation-user',
            //                 'url'  => 'virtualizations/snapshots/delete',
            //             ],[
            //                 'text' => 'Revertir snapshot',
            //                 'icon' => 'fas fa-fast-backward',
            //                 'can' => 'implementation-user',
            //                 'url'  => 'virtualizations/snapshots/revert',
            //             ]),
            //         ]),
            //     ]),
            // ]);
            // $event->menu->add([
            //     'text' => 'OPERADORES',
            //     'icon' => 'far fa-circle',
            //     'can' => 'operator-menu',
            //     'submenu' => array([
            //         'text' => 'UNIX',
            //         'icon' => 'fas fa-arrow-circle-right',
            //         'can' => 'operator-menu',
            //         'submenu' => array([
            //             'text' => 'Informe operadores',
            //             'icon' => 'fas fa-file-contract',
            //             'can' => 'operator-mixed',
            //             'url'  => 'operators/opeReport',
            //         ]),
            //     ]/*,[
            //         'text' => 'VIRTUALIZACIÓN',
            //         'icon' => 'fas fa-arrow-circle-right',
            //         'can' => 'executionLog-menu',
            //         'submenu' => array([
            //             'text' => 'Paso a operación VM',
            //             'icon' => 'fas fa-thumbs-up',
            //             'can' => 'pasosOP-admin',
            //             'url'  => 'virtualizations/operationStep',
            //         ],[
            //             'text' => 'Paso a operación Host',
            //             'icon' => 'fas fa-thumbs-up',
            //             'can' => 'pasosOP-admin',
            //             'url'  => 'virtualizations/checkHost',
            //         ]),
            //     ],[
            //         'text' => 'WINDOWS',
            //         'icon' => 'far fa-circle',
            //         'can' => 'executionLog-menu',
            //         'submenu' => array(
            //             [
            //                 'text' => 'E&N',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'executionLog-menu',
            //                 'url'  => '#',
            //             ],[
            //                 'text' => 'P&H',
            //                 'icon' => 'fas fa-spinner',
            //                 'can' => 'executionLog-menu',
            //                 'url'  => '#',
            //         ]),
            //     ]*/),
            // ]);
            // $event->menu->add([
            //     'text' => 'REDES',
            //     'icon' => 'far fa-circle',
            //     'can' => 'networking-menu',
            //     'submenu' => array([
            //         'text' => 'Check Inventario',
            //         'icon' => 'fas fa-check-double',
            //         'can' => 'networking-user',
            //         'url'  => 'networking/checkInventario',
            //     ],[
            //         'text' => 'MAC_Search Plaza Claro',
            //         'icon' => 'fas fa-search',
            //         'can' => 'networking-user',
            //         'url'  => 'networking/macSearchPC',
            //     ],[
            //         'text' => 'Revisión Uptime',
            //         'icon' => 'fas fa-stopwatch',
            //         'can' => 'networking-user',
            //         'url'  => 'networking/valUptime',
            //     ],[
            //         'text' => 'T-Shoot CAVs',
            //         'icon' => 'fas fa-list',
            //         'can' => 'networking-user',
            //         'url'  => 'networking/tShootCAV',
            //     ]),
            // ]);
            // $event->menu->add([
            //     'text' => 'REDES PYMES',
            //     'icon' => 'far fa-circle',
            //     'can' => 'networking-pymes-menu',
            //     'submenu' => array([
            //         'text' => 'Reinicio FW Gaoke',
            //         'icon' => 'fas fa-power-off',
            //         'can' => 'networking-pymes-run',
            //         'url'  => 'networkingPymes/restartGaoke',
            //     ],[
            //         'text' => 'Actualizacion FW Gaoke',
            //         'icon' => 'fas fa-wrench',
            //         'can' => 'networking-pymes-run',
            //         'url'  => 'networkingPymes/updateGaoke',
            //     ]),
            // ]);
            // $event->menu->add([
            //     'text' => 'SAN',
            //     'icon' => 'far fa-circle',
            //     'can' => 'san-menu',
            //     'submenu' => array(
            //     [
            //         'text' => 'Administración',
            //         'icon' => 'fas fa-user-shield',
            //         'can' => 'san-admin',
            //         'submenu' => array([
            //             'text' => 'Comandos Fabric',
            //             'icon' => 'fas fa-network-wired',
            //             'can' => 'san-admin',
            //             'url'  => 'san/admin/fabric',
            //         ],[
            //             'text' => 'SAN Extendida',
            //             'icon' => 'fas fa-network-wired',
            //             'can' => 'san-admin',
            //             'url'  => 'san/admin/sanExtend',
            //         ],[
            //             'text' => 'Reporte de puertos',
            //             'icon' => 'fas fa-file-invoice',
            //             'can' => 'san-admin',
            //             'url'  => 'san/admin/portsReport',
            //         ],[
            //             'text' => 'Umbrales reporte de puertos',
            //             'icon' => 'fas fa-file-contract',
            //             'can' => 'san-admin',
            //             'url'  => 'san/admin/configPortReport',
            //         ]),
            //     ],
            //     [
            //         'text' => 'Consultas',
            //         'icon' => 'fas fa-search',
            //         'can' => 'san-user',
            //         'submenu' => array([
            //             'text' => 'Puertos',
            //             'icon' => 'fas fa-network-wired',
            //             'can' => 'san-user',
            //             'url'  => 'san/queries/portState',
            //         ],[
            //             'text' => 'WWN',
            //             'icon' => 'fas fa-hdd',
            //             'can' => 'san-user',
            //             'url'  => 'san/queries/WWNSearch',
            //         ],[
            //             'text' => 'WWN/NAA Discos',
            //             'icon' => 'fas fa-hdd',
            //             'can' => 'san-user',
            //             'url'  => 'san/queries/wwnNaa',
            //         ],[
            //             'text' => 'Zonas',
            //             'icon' => 'fas fa-network-wired',
            //             'can' => 'san-user',
            //             'url'  => 'san/queries/ZoneSearch',
            //         ]),
            //     ],[
            //         'text' => 'Inventarios',
            //         'icon' => 'fas fa-search',
            //         'can' => 'san-user',
            //         'submenu' => array([
            //             'text' => 'NAS',
            //             'icon' => 'fas fa-hdd',
            //             'can' => 'sanNas-user',
            //             'url'  => 'san/inventories/sanNas',
            //             ],[
            //                 'text' => 'Links',
            //                 'icon' => 'fas fa-link',
            //                 'can' => 'sanLink-user',
            //                 'url'  => 'san/inventories/sanLink',
            //             ],[
            //                 'text' => 'LUN',
            //                 'icon' => 'fas fa-hdd',
            //                 'can' => 'sanLun-user',
            //                 'url'  => 'san/inventories/sanLun',
            //             ],[
            //                 'text' => 'Puertos',
            //                 'icon' => 'fas fa-network-wired',
            //                 'can' => 'sanPort-user',
            //                 'url'  => 'san/inventories/sanPorts',
            //             ],[
            //                 'text' => 'Servidores',
            //                 'icon' => 'fas fa-server',
            //                 'can' => 'sanServer-user',
            //                 'url'  => 'san/inventories/sanServer',
            //             ],[
            //                 'text' => 'Switch',
            //                 'icon' => 'fas fa-network-wired',
            //                 'can' => 'sanSwitch-user',
            //                 'url'  => 'san/inventories/sanSwitch',
            //             ],[
            //                 'text' => 'Storage',
            //                 'icon' => 'fas fa-hdd',
            //                 'can' => 'sanStorage-user',
            //                 'url'  => 'san/inventories/sanStorage',
            //             ]),
            //         ]),
            // ]);
            // $event->menu->add([
            //     'text' => 'SEGURIDAD DC',
            //     'icon' => 'far fa-circle',
            //     'can' => 'ManagedSecurity-menu',
            //     'submenu' => array([
            //         'text' => 'Instalación AV DS Unix',
            //         'icon' => 'fas fa-download',
            //         'can' => 'ManagedSecurity-user',
            //         'url'  => 'managedSecurity/instAVDSUnix',
            //     ],[
            //         'text' => 'Instalación AV DS Win',
            //         'icon' => 'fas fa-download',
            //         'can' => 'ManagedSecurity-user',
            //         'url'  => 'managedSecurity/instAVDSWin',
            //     ],[
            //         'text' => 'BlackList Firewall SIN_VDOM',
            //         'icon' => 'fas fa-fire',
            //         'can' => 'ManagedSecurity-user',
            //         'url'  => 'managedSecurity/blacklistNotVdom',
            //     ],[
            //         'text' => 'BlackList Firewall CON_VDOM',
            //         'icon' => 'fas fa-fire',
            //         'can' => 'ManagedSecurity-user',
            //         'url'  => 'managedSecurity/blacklistVdom',
            //     ]),
            // ]);
            // $event->menu->add([
            //     'text' => 'TELEFONÍA',
            //     'icon' => 'far fa-circle',
            //     'can' => 'telephony-menu',
            //     'submenu' => array([
            //         'text' => 'Reporte usuarios Avaya',
            //         'icon' => 'fas fa-user',
            //         'can' => 'telephony-user',
            //         'url'  => 'telephony/logUserAvaya',
            //     ]),
            // ]);
            // $event->menu->add([
            //     'text' => 'UNIX',
            //     'icon' => 'far fa-circle',
            //     'can' => 'unix-menu',
            //     'submenu' => array([
            //         'text' => 'UNIX E&N',
            //         'icon' => 'fas fa-arrow-right',
            //         'can' => 'unixEN-menu',
            //         'submenu' => array([
            //             'text' => 'Asignación de permisos',
            //             'icon' => 'fas fa-check-double',
            //             'can' => 'unixEN-user',
            //             'url'  => 'unix/folderPermission',
            //         ],[
            //             'text' => 'Check Paso a Operación ',
            //             'icon' => 'fas fa-check-double',
            //             'can' => 'unixEN-user',
            //             'url'  => 'unix/checkPaso',
            //         ],[
            //             'text' => 'Depuración filesystem',
            //             'icon' => 'fas fa-trash',
            //             'can' => 'unixEN-mixed',
            //             'url'  => 'unix/cleanFileSystem',
            //         ],[
            //             'text' => 'Configuración LVM',
            //             'icon' => 'fas fa-hdd',
            //             'can' => 'unixEN-mixed',
            //             'url'  => 'unix/configLvm',
            //         ],[
            //             'text' => 'Gestión de discos',
            //             'icon' => 'fas fa-save',
            //             'can' => 'unixEN-user',
            //             'url'  => 'unix/diskManagement',
            //         ],[
            //             'text' => 'Gestión de usuarios',
            //             'icon' => 'fas fa-user',
            //             'can' => 'unixEN-menu',
            //             'submenu' => array([
            //                 'text' => 'Crear usuarios',
            //                 'icon' => 'fas fa-user-plus',
            //                 'can' => 'unixEN-mixed',
            //                 'url'  => 'unix/create',
            //             ],[
            //                 'text' => 'Crear usuarios Admin',
            //                 'icon' => 'fas fa-user-plus',
            //                 'can' => 'unixEN-admin',
            //                 'url'  => 'unix/createAdm',
            //             ],[
            //                 'text' => 'Cambio password',
            //                 'icon' => 'fas fa-user-edit',
            //                 'can' => 'unixEN-mixed',
            //                 'url'  => 'unix/change',
            //             ],[
            //                 'text' => 'Cambio password AD',
            //                 'icon' => 'fas fa-user-edit',
            //                 'can' => 'unixEN-user',
            //                 'url'  => 'unix/resetUserByAD',
            //             ],[
            //                 'text' => 'Deshabiltar usuario',
            //                 'icon' => 'fas fa-user-times',
            //                 'can' => 'unixEN-mixed',
            //                 'url'  => 'unix/disable',
            //             ],[
            //                 'text' => 'Eliminar usuario',
            //                 'icon' => 'fas fa-user-times',
            //                 'can' => 'unixEN-mixed',
            //                 'url'  => 'unix/delete',
            //             ]),
            //         ],[
            //             'text' => 'Logrotate',
            //             'icon' => 'fas fa-file-code',
            //             'can' => 'unixEN-user',
            //             'url'  => 'unix/logrotate',
            //         ],[
            //             'text' => 'Inventario',
            //             'icon' => 'fas fa-list',
            //             'can' => 'unixEN-mixed',
            //             'url'  => 'unix/inventario',
            //         ],[
            //             'text' => 'Liberación de memoria',
            //             'icon' => 'fas fa-memory',
            //             'can' => 'unixEN-mixed',
            //             'url'  => 'unix/freeMemory',
            //         ],[
            //             'text' => 'Listado de puertos',
            //             'icon' => 'fas fa-list',
            //             'can' => 'unixEN-mixed',
            //             'url'  => 'unix/portListen',
            //         ],[
            //             'text' => 'Check S.O',
            //             'icon' => 'fas fa-shoe-prints',
            //             'can' => 'unixEN-mixed',
            //             'submenu' => array([
            //                 'text' => 'Pre-Ventana',
            //                 'icon' => 'fas fa-step-backward',
            //                 'can' => 'unixEN-mixed',
            //                 'url'  => 'unix/pasoPrevio',
            //             ],[
            //                 'text' => 'Post-Ventana',
            //                 'icon' => 'fas fa-step-forward',
            //                 'can' => 'unixEN-mixed',
            //                 'url'  => 'unix/pasoPosterior',
            //             ]),
            //         ],[
            //             'text' => 'PLK - 7 Pasos - Unix',
            //             'icon' => 'fas fa-shoe-prints',
            //             'can' => 'unixEN-mixed',
            //             'url'  => 'unix/sevenSteps',
            //         ],[
            //             'text' => 'Reinicio de servicios',
            //             'icon' => 'fas fa-spinner',
            //             'can' => 'unixEN-mixed',
            //             'url'  => 'unix/restartServices',
            //         ],[
            //             'text' => 'Rutas Estáticas',
            //             'icon' => 'fas fa-route',
            //             'can' => 'unixEN-mixed',
            //             'url'  => 'unix/rutasEstaticas',
            //         ],[
            //             'text' => 'Simpana',
            //             'icon' => 'fas fa-route',
            //             'can' => 'unixEN-mixed',
            //             'url'  => 'unix/simpana',
            //         ],[
            //             'text' => 'Snapshot Solaris',
            //             'icon' => 'fas fa-camera-retro',
            //             'can' => 'unixEN-mixed',
            //             'submenu' => array([
            //                 'text' => 'Listar información',
            //                 'icon' => 'fas fa-clipboard-list',
            //                 'can' => 'unixEN-mixed',
            //                 'url'  => 'unix/snapSList',
            //             ],[
            //                 'text' => 'Gestión de snapshot',
            //                 'icon' => 'fas fa-camera-retro',
            //                 'can' => 'unixEN-mixed',
            //                 'url'  => 'unix/snapSolaris',
            //             ]),
            //         ],[
            //             'text' => 'Uptime',
            //             'icon' => 'fas fa-stopwatch',
            //             'can' => 'unixEN-mixed',
            //             'url'  => 'unix/uptime',
            //         ]),
            //     ],[
            //         'text' => 'UNIX P&H',
            //         'icon' => 'fas fa-arrow-right',
            //         'can' => 'unixPH-menu',
            //         'submenu' => array([
            //             'text' => 'Check de plataformas',
            //             'icon' => 'fas fa-network-wired',
            //             'can' => 'unixPH-user',
            //             'url'  => 'unixPH/checkPlatforms',
            //         ],[
            //             'text' => 'Check paso a operación',
            //             'icon' => 'fas fa-check-double',
            //             'can' => 'unixPH-user',
            //             'url'  => 'unixPH/checkPasoUnix',
            //         ],[
            //             'text' => 'Gestión de usuarios',
            //             'icon' => 'fas fa-user',
            //             'can' => 'unixPH-user',
            //             'submenu' => array([
            //                 'text' => 'Crear usuarios',
            //                 'icon' => 'fas fa-user-plus',
            //                 'can' => 'unixPH-user',
            //                 'url'  => 'unixPH/create',
            //             ],[
            //                 'text' => 'Desbloqueo de usuario',
            //                 'icon' => 'fas fa-user-lock',
            //                 'can' => 'unixPH-user',
            //                 'url'  => 'unixPH/unlock',
            //             ],[
            //                 'text' => 'Eliminar usuario',
            //                 'icon' => 'fas fa-user-times',
            //                 'can' => 'unixPH-user',
            //                 'url'  => 'unixPH/delete',
            //             ],[
            //                 'text' => 'Modificar usuario',
            //                 'icon' => 'fas fa-user-edit',
            //                 'can' => 'unixPH-user',
            //                 'url'  => 'unixPH/change',
            //             ]),
            //         ],[
            //             'text' => 'Gestión DNS',
            //             'icon' => 'fas fa-network-wired',
            //             'can' => 'unixPH-user',
            //             'url'  => 'unixPH/dnsclaro',
            //         ],[
            //             'text' => 'PAM vs Release',
            //             'icon' => 'fas fa-network-wired',
            //             'can' => 'unixPH-user',
            //             'url'  => 'unixPH/uptimeRelease',
            //         ],[
            //             'text' => 'Reinicio Unix',
            //             'icon' => 'fas fa-power-off',
            //             'can' => 'unixPH-user',
            //             'submenu' => array([
            //                 'text' => 'Prevalidación Reinicio',
            //                 'icon' => 'fas fa-hand-point-right',
            //                 'can' => 'unixPH-user',
            //                 'url'  => 'unixPH/prevalidation',
            //             ],[
            //                 'text' => 'Proceso Reinicio',
            //                 'icon' => 'fas fa-hand-point-right',
            //                 'can' => 'unixPH-user',
            //                 'url'  => 'unixPH/restart',
            //             ],[
            //                 'text' => 'Proceso Validación',
            //                 'icon' => 'fas fa-hand-point-right',
            //                 'can' => 'unixPH-user',
            //                 'url'  => 'unixPH/validation',
            //             ],[
            //                 'text' => 'Proceso subida BD',
            //                 'icon' => 'fas fa-hand-point-right',
            //                 'can' => 'unixPH-user',
            //                 'url'  => 'unixPH/uploadDb',
            //             ]),
            //         ],[
            //             'text' => 'Uptime',
            //             'icon' => 'fas fa-network-wired',
            //             'can' => 'unixPH-user',
            //             'url'  => 'unixPH/uptime',
            //         ],[
            //             'text' => 'Siete Pasos',
            //             'icon' => 'fas fa-shoe-prints',
            //             'can' => 'unixPH-user',
            //             'url'  => 'unixPH/sevenStepsPH',
            //         ],[
            //             'text' => 'Validación NFS Venecia',
            //             'icon' => 'fas fa-server',
            //             'can' => 'unixPH-user',
            //             'url'  => 'unixPH/validationNFSVenecia',
            //         ]),
            //     ]),
            // ]);
            // $event->menu->add([
            //     'text' => 'WINDOWS',
            //     'icon' => 'far fa-circle',
            //     'can' => 'windows-menu',
            //     'submenu' => array([
            //         'text' => 'WINDOWS E&N',
            //         'icon' => 'fas fa-arrow-right',
            //         'can' => 'windowsEN-menu',
            //         'submenu' => array([
            //             'text' => 'Check AD',
            //             'icon' => 'fas fa-check-double',
            //             'can' => 'windowsEN-user',
            //             'url'  => 'windows/checkAD',
            //         ],/*[
            //             'text' => 'Check Cluster',
            //             'icon' => 'fas fa-check-double',
            //             'can' => 'windowsEN-user',
            //             'url'  => 'windows/checkCluster',
            //         ],[
            //             'text' => 'Check Discos Duros',
            //             'icon' => 'fas fa-check-double',
            //             'can' => 'windowsEN-user',
            //             'url'  => 'windows/diskCheck',
            //         ],*/[
            //             'text' => 'Check Paso a Operación',
            //             'icon' => 'fas fa-check-double',
            //             'can' => 'windowsEN-user',
            //             'url'  => 'windows/checkPaso',
            //         ],[
            //             'text' => 'Check procesos CPU',
            //             'icon' => 'fas fa-check-double',
            //             'can' => 'windowsEN-user',
            //             'url'  => 'windows/checkCPUProcess',
            //         ],[
            //             'text' => 'Check S.O',
            //             'icon' => 'fas fa-shoe-prints',
            //             'can' => 'windowsEN-mixed',
            //             'submenu' => array([
            //                 'text' => 'Pre-Ventana',
            //                 'icon' => 'fas fa-step-backward',
            //                 'can' => 'windowsEN-mixed',
            //                 'url'  => 'windows/preVentana',
            //             ],[
            //                 'text' => 'Post-Ventana',
            //                 'icon' => 'fas fa-step-forward',
            //                 'can' => 'windowsEN-mixed',
            //                 'url'  => 'windows/postVentana',
            //             ]),
            //         ],[
            //             'text' => 'Check Sistema Operativo',
            //             'icon' => 'fas fa-check-double',
            //             'can' => 'windowsEN-mixed',
            //             'url'  => 'windows/checkSO',
            //         ],[
            //             'text' => 'Gestión de servicios',
            //             'icon' => 'fas fa-power-off',
            //             'can' => 'windowsEN-mixed',
            //             'url'  => 'windows/serviceManagement',
            //         ],[
            //             'text' => 'Gestión WConsultas',
            //             'icon' => 'fas fa-power-off',
            //             'can' => 'windowsEN-admin',
            //             'url'  => 'windows/manageWConsultas',
            //         ],[
            //             'text' => 'Gestión WCompensar',
            //             'icon' => 'fas fa-power-off',
            //             'can' => 'windowsEN-admin',
            //             'url'  => 'windows/manageWCompensar',
            //         ],[
            //             'text' => 'Gestión de usuarios',
            //             'icon' => 'fas fa-user',
            //             'can' => 'windowsEN-menu',
            //             'submenu' => array([
            //                 'text' => 'Crear usuarios',
            //                 'icon' => 'fas fa-user-plus',
            //                 'can' => 'windowsEN-mixed',
            //                 'url'  => 'windows/create',
            //             ],[
            //                 'text' => 'Cambiar password',
            //                 'icon' => 'fas fa-user-edit',
            //                 'can' => 'windowsEN-mixed',
            //                 'url'  => 'windows/change',
            //             ],[
            //                 'text' => 'Deshabilitar usuario',
            //                 'icon' => 'fas fa-user-slash',
            //                 'can' => 'windowsEN-mixed',
            //                 'url'  => 'windows/disable',
            //             ],[
            //                 'text' => 'Eliminar usuario',
            //                 'icon' => 'fas fa-user-times',
            //                 'can' => 'windowsEN-mixed',
            //                 'url'  => 'windows/delete',
            //             ],[
            //                 'text' => 'Modificar usuario',
            //                 'icon' => 'fas fa-user-edit',
            //                 'can' => 'windowsEN-mixed',
            //                 'url'  => 'windows/edit',
            //             ]),
            //         ],[
            //             'text' => 'Depuración de memoria',
            //             'icon' => 'fas fa-memory',
            //             'can' => 'windowsEN-mixed',
            //             'url'  => 'windows/freeMemory',
            //         ],[
            //             'text' => 'Depuración de discos',
            //             'icon' => 'fas fa-hdd',
            //             'can' => 'windowsEN-mixed',
            //             'url'  => 'windows/debuggingDisks',
            //         ],[
            //             'text' => 'Extracción de Parches',
            //             'icon' => 'fas fa-external-link-alt',
            //             'can' => 'windowsEN-mixed',
            //             'url'  => 'windows/extParches',
            //         ],[
            //             'text' => 'Extracción de uptime',
            //             'icon' => 'fas fa-external-link-alt',
            //             'can' => 'windowsEN-user',
            //             'url'  => 'windows/extUptime',
            //         ],[
            //             'text' => 'Inventario Windows',
            //             'icon' => 'fas fa-list',
            //             'can' => 'windowsEN-mixed',
            //             'url'  => 'windows/inventario',
            //         ],[
            //             'text' => 'Rutas Estáticas',
            //             'icon' => 'fas fa-route',
            //             'can' => 'windowsEN-mixed',
            //             'url'  => 'windows/rutasEstaticas',
            //         ],[
            //             'text' => 'PLK - 7 Pasos - Windows',
            //             'icon' => 'fas fa-shoe-prints',
            //             'can' => 'windowsEN-mixed',
            //             'url'  => 'windows/sevenSteps',
            //         ],[
            //             'text' => 'Update SO',
            //             'icon' => 'fas fa-cog',
            //             'can' => 'windowsEN-user',
            //             'url'  => 'windows/updateSO',
            //         ]),
            //     ],[
            //         'text' => 'WINDOWS P&H',
            //         'icon' => 'fas fa-arrow-right',
            //         'can' => 'windowsPH-menu',
            //         'submenu' => array([
            //             'text' => 'Actualización Atr. Users AD',
            //             'icon' => 'fas fa-user',
            //             'can' => 'windowsPH-user',
            //             'url'  => 'windowsPH/updateAtUserAD',
            //         ],[
            //             'text' => 'Carpetas compartidas',
            //             'icon' => 'fas fa-folder-open',
            //             'can' => 'winShareFolder-menu',
            //             'url'  => 'windowsPH/winShareFolder',
            //         ],[
            //             'text' => 'Check estado S.O.',
            //             'icon' => 'fas fa-check-double',
            //             'can' => 'windowsPH-user',
            //             'url'  => 'windowsPH/checkSO',
            //         ],[
            //             'text' => 'Check estado S.O. Rep',
            //             'icon' => 'fas fa-search',
            //             'can' => 'windowsPH-user',
            //             'url'  => 'windowsPH/getCheckSO',
            //         ],[
            //             'text' => 'Consulta updates (KB)',
            //             'icon' => 'fas fa-download',
            //             'can' => 'windowsPH-user',
            //             'url'  => 'windowsPH/queryKb',
            //         ],[
            //             'text' => 'Permisos carpeta compartida',
            //             'icon' => 'fas fa-folder',
            //             'can' => 'windowsPH-user',
            //             'url'  => 'windowsPH/sharedFolderPer',
            //         ],[
            //             'text' => 'Reinicio IIS Com',
            //             'icon' => 'fas fa-power-off',
            //             'can' => 'windowsPH-mixed',
            //             'url'  => 'windowsPH/restartIISCom',
            //         ],[
            //             'text' => 'Reinicio Pool Com',
            //             'icon' => 'fas fa-power-off',
            //             'can' => 'windowsPH-mixed',
            //             'url'  => 'windowsPH/restartPoolCom',
            //         ],[
            //             'text' => 'Reinicio Servicios Com',
            //             'icon' => 'fas fa-power-off',
            //             'can' => 'windowsPH-user',
            //             'url'  => 'windowsPH/restartServicesCom',
            //         ],[
            //             'text' => 'Rep. Sitios Web y AppPools',
            //             'icon' => 'fas fa-file-contract',
            //             'can' => 'windowsPH-user',
            //             'url'  => 'windowsPH/reportSWP',
            //         ],[
            //             'text' => 'Rep. usuarios locales',
            //             'icon' => 'fas fa-file-contract',
            //             'can' => 'windowsPH-user',
            //             'url'  => 'windowsPH/localUsersReport',
            //         ])
            //     ]),
            // ]);
            // $event->menu->add([
            //     'text' => 'VIRTUALIZACIÓN',
            //     'icon' => 'far fa-circle',
            //     'can' => 'virtualization-menu',
            //     'submenu' => array([
            //         'text' => 'Diagnostico MV',
            //         'icon' => 'fas fa-diagnoses',
            //         'can' => 'virtualization-mixed',
            //         'url'  => 'virtualizations/diagnostic',
            //     ],[
            //         'text' => 'Consumos MV',
            //         'icon' => 'fas fa-chart-bar',
            //         'can' => 'virtualization-mixed',
            //         'url'  => 'virtualizations/consumption',
            //     ],[
            //         'text' => 'Consola VmWare',
            //         'icon' => 'fas fa-terminal',
            //         'can' => 'virtualization-admin',
            //         'url'  => 'virtualizations/commandExe',
            //     ],[
            //         'text' => 'Consumo cliente MVs',
            //         'icon' => 'fas fa-chart-bar',
            //         'can' => 'virtualization-mixed',
            //         'url'  => 'virtualizations/cVMCustomer',
            //     ],[
            //         'text' => 'Corrección check PO',
            //         'icon' => 'fas fa-thumbs-up',
            //         'can' => 'virtualization-user',
            //         'url'  => 'virtualizations/checkVMRepairSearch',
            //     ],[
            //         'text' => 'Inventario de plataformas',
            //         'icon' => 'fas fa-list',
            //         'can' => 'virtualization-user',
            //         'url'  => 'virtualizations/inventory',
            //     ],[
            //         'text' => 'Paso a operación Host',
            //         'icon' => 'fas fa-thumbs-up',
            //         'can' => 'virtualization-mixed',
            //         'url'  => 'virtualizations/checkHost',
            //     ],[
            //         'text' => 'Paso a operación VM',
            //         'icon' => 'fas fa-thumbs-up',
            //         'can' => 'virtualization-user',
            //         'url'  => 'virtualizations/operationStep',
            //     ],[
            //         'text' => 'Reportes',
            //         'icon' => 'fas fa-file-invoice',
            //         'can' => 'virtualization-user',
            //         'url'  => 'virtualizations/reports',
            //     ],[
            //         'text' => 'Reporte Cluster Capacity ',
            //         'icon' => 'fas fa-file-invoice',
            //         'can' => 'virtualization-user',
            //         'url'  => 'virtualizations/clusterCapacityReport',
            //     ],[
            //         'text' => 'Reporte VMHosts',
            //         'icon' => 'fas fa-file-invoice',
            //         'can' => 'virtualization-user',
            //         'url'  => 'virtualizations/VMHostReport',
            //     ],[
            //         'text' => 'Reporte VMHost HBA',
            //         'icon' => 'fas fa-file-invoice',
            //         'can' => 'virtualization-user',
            //         'url'  => 'virtualizations/VMHBAReport',
            //     ],[
            //         'text' => 'Reporte VMHost NIC',
            //         'icon' => 'fas fa-file-invoice',
            //         'can' => 'virtualization-user',
            //         'url'  => 'virtualizations/VMNICReport',
            //     ],[
            //         'text' => 'Snapshots',
            //         'icon' => 'fas fa-camera',
            //         'can' => 'virtualization-mixed',
            //         'submenu' => array([
            //             'text' => 'Toma de snapshot',
            //             'icon' => 'fas fa-plus-square',
            //             'can' => 'virtualization-mixed',
            //             'url'  => 'virtualizations/snapshots/create',
            //         ],[
            //             'text' => 'Programar snapshot',
            //             'icon' => 'fas fa-plus-square',
            //             'can' => 'virtualization-mixed',
            //             'url'  => 'virtualizations/snapshots/schedule',
            //         ],[
            //             'text' => 'Borrado de snapshot',
            //             'icon' => 'fas fa-minus-square',
            //             'can' => 'virtualization-mixed',
            //             'url'  => 'virtualizations/snapshots/delete',
            //         ],[
            //             'text' => 'Revertir snapshot',
            //             'icon' => 'fas fa-fast-backward',
            //             'can' => 'virtualization-mixed',
            //             'url'  => 'virtualizations/snapshots/revert',
            //         ]),
            //     ],[
            //         'text' => 'Tag MV',
            //         'icon' => 'fas fa-tag',
            //         'can' => 'virtualization-user',
            //         'url'  => 'virtualizations/tagMV',
            //     ],[
            //         'text' => 'Update VMWare Tools',
            //         'icon' => 'fas fa-spinner',
            //         'can' => 'virtualization-admin',
            //         'url'  => 'virtualizations/updateVMWT',
            //     ],[
            //         'text' => 'Aumento de recursos',
            //         'icon' => 'fas fa-chalkboard-teacher',
            //         'can' => 'virtualization-admin',
            //         'url'  => 'virtualizations/resourcesUpgrade',
            //     ],[
			// 		'text' => 'Cambio de Vlan',
			// 		'icon' => 'fas fa-chalkboard-teacher',
			// 		'can' => 'virtualization-admin',
			// 		'url'  => 'virtualizations/vlanUpdate',
			// 	],[
            //         'text' => 'Aumento de Disco Duro',
            //         'icon' => 'fas fa-chalkboard-teacher',
            //         'can' => 'virtualization-admin',
            //         'url'  => 'virtualizations/resourcesDisk',
            //     ]),
            // ]);

            // $event->menu->add([
            //     'text' => 'RECURSOS',
            //     'icon' => 'far fa-circle',
            //     'can' => 'recursos-menu',
            //     'submenu' => array([
            //         'text' => 'COMPONENTES',
            //         'icon' => 'fas fa-fw fa-database',
            //         'can' => 'recursos-menu',
            //         'submenu' => array([
            //             'text'  => 'Clientes',
            //             'url'   => 'infrastructure/server/components/clientes',
            //             'icon'  => 'fas fa-fw fa-user-md',
            //             'can'  => 'recursos-menu',
            //         ],[
            //             'text'  => 'Marcas',
            //             'url'   => 'infrastructure/server/server/marcas',
            //             'icon'  => 'fas fa-fw fa-bars',
            //             'can'  => 'recursos-menu',
            //         ],[
            //             'text'  => 'Modelos',
            //             'url'   => 'infrastructure/server/server/modelos',
            //             'icon'  => 'fas fa-fw fa-barcode',
            //             'can'  => 'recursos-menu',
            //         ],[
            //             'text'  => 'Controladoras',
            //             'url'   => 'infrastructure/server/components/controladoras',
            //             'icon'  => 'fas fa-fw fa-random',
            //             'can'  => 'recursos-menu',
            //         ],[
            //             'text'  => 'CPU Marcas',
            //             'url'   => 'infrastructure/server/components/cpuMarcas',
            //             'icon'  => 'fas fa-fw fa-list-ol',
            //             'can'  => 'recursos-menu',
            //         ],[
            //             'text'  => 'CPU Modelos',
            //             'url'   => 'infrastructure/server/components/cpuModelos',
            //             'icon'  => 'fas fa-fw fa-list-ol',
            //             'can'  => 'recursos-menu',
            //         ],[
            //             'text'  => 'Data Centers',
            //             'url'   => 'infrastructure/server/components/dataCenter',
            //             'icon'  => 'fas fa-fw fa-globe',
            //             'can'  => 'recursos-menu',
            //         ],[
            //             'text'  => 'Disco Marcas',
            //             'url'   => 'infrastructure/server/components/discoMarcas',
            //             'icon'  => 'fas fa-fw fa-list-ol',
            //             'can'  => 'recursos-menu',
            //         ],[
            //             'text'  => 'Estados Servidor',
            //             'url'   => 'infrastructure/server/components/serverEstados',
            //             'icon'  => 'fas fa-fw fa-list-ol',
            //             'can'  => 'recursos-menu',
            //         ],[
            //             'text'  => 'Nic Referencias',
            //             'url'   => 'infrastructure/server/components/nicReferencias',
            //             'icon'  => 'fas fa-fw fa-list-ol',
            //             'can'  => 'recursos-menu',
            //         ],[
            //             'text'  => 'Propietarios',
            //             'url'   => 'infrastructure/server/components/propietarios',
            //             'icon'  => 'fas fa-fw fa-user',
            //             'can'  => 'recursos-menu',
            //         ],[
            //             'text'  => 'Raids',
            //             'url'   => 'infrastructure/server/components/raids',
            //             'icon'  => 'fas fa-fw fa-align-justify',
            //             'can'  => 'recursos-menu',
            //         ],[
            //             'text'  => 'Responsables',
            //             'url'   => 'infrastructure/server/components/responsables',
            //             'icon'  => 'fas fa-fw fa-user-plus',
            //             'can'  => 'recursos-menu',
            //         ],[
            //             'text'  => 'Sistema Operativo',
            //             'url'   => 'infrastructure/server/components/sistemaOperativo',
            //             'icon'  => 'fas fa-fw fa-registered',
            //             'can'  => 'recursos-menu',
            //         ],[
            //             'text'  => 'Tipo de Cliente',
            //             'url'   => 'infrastructure/server/components/tiposCliente',
            //             'icon'  => 'fas fa-fw fa-list-ol',
            //             'can'  => 'recursos-menu',
            //         ],[
            //             'text'  => 'Tipo de Hardware',
            //             'url'   => 'infrastructure/server/components/tiposHardware',
            //             'icon'  => 'fas fa-fw fa-list-ol',
            //             'can'  => 'recursos-menu',
            //         ],[
            //             'text'  => 'Tipo de memoria',
            //             'url'   => 'infrastructure/server/components/tipoMemorias',
            //             'icon'  => 'fas fa-fw fa-list-ol',
            //             'can'  => 'recursos-menu',
            //         ],[
            //             'text'  => 'Tipo de Rack',
            //             'url'   => 'infrastructure/server/components/tiposRack',
            //             'icon'  => 'fas fa-fw fa-list-ol',
            //             'can'  => 'recursos-menu',
            //         ],[
            //             'text'  => 'Tipo de Servicio',
            //             'url'   => 'infrastructure/server/components/tiposServicio',
            //             'icon'  => 'fas fa-fw fa-list-ol',
            //             'can'  => 'recursos-menu',
            //         ]),
            //         ],[
            //             'text' => 'HARDWARE',
            //             'icon' => 'fas fa-fw fa-server',
            //             //'can'  => 'user-list',
            //             'can'  => 'recursos-menu',
            //             'submenu' => array([
            //                 'text'  => 'Búsqueda de Servidor',
            //                 'url'   => 'infrastructure/server/server/servers/search',
            //                 'icon'  => 'fas fa-fw fa-search',
            //                 //'can'  => 'user-list',
            //                 'can'  => 'recursos-menu',
            //             ],[
            //                 'text'  => 'Logs de actualización',
            //                 'url'   => 'infrastructure/server/server/updateLogs',
            //                 'icon'  => 'fas fa-fw fa-sync',
            //                 'can'  => 'recursos-menu',
            //             ],[
            //                 'text'  => 'Paquetes de actualización',
            //                 'url'   => 'infrastructure/server/server/updatePacks',
            //                 'icon'  => 'fas fa-fw fa-sync',
            //                 'can'  => 'recursos-menu',
            //             ],[
            //                 'text'  => 'Actualizar FW',
            //                 'url'   => 'infrastructure/server/server/updatePacks/search',
            //                 'icon'  => 'fas fa-fw fa-sync',
            //                 'can'  => 'recursos-menu',
            //             ],[
            //                 'text'  => 'Servidores',
            //                 'url'   => 'infrastructure/server/server/servers',
            //                 'icon'  => 'fas fa-fw fa-server',
            //                 'can'  => 'recursos-menu',
            //             ]),
            //     ]),
            // ]);
            // $event->menu->add('UTILIDADES');
            // $event->menu->add([
            //     'text' => 'HERRAMIENTAS EXTERNAS',
            //     'icon' => 'far fa-circle',
            //     'can' => 'externalToolLog-menu',
            //     'url' => 'externalToolLogs/'
            // ]);
            // $event->menu->add([
            //     'text' => 'LOGS',
            //     'icon' => 'far fa-circle',
            //     'can' => 'executionLog-menu',
            //     'url' => 'executionLogs/'
            // ]);
            // $event->menu->add([
            //     'text' => 'REPORTES',
            //     'icon' => 'far fa-circle',
            //     'can' => 'report-menu',
            //     'submenu' => array([
            //         'text' => 'Automatizaciones',
            //         'icon' => 'fas fa-robot',
            //         'can' => 'report-user',
            //         'url'  => 'reports/automation',
            //     ],[
            //         'text' => 'RDR',
            //         'icon' => 'fas fa-robot',
            //         'can' => 'report-user',
            //         'url'  => 'reports/rdr',
            //     ],[
            //         'text' => 'Tareas ejecutadas',
            //         'icon' => 'fas fa-list',
            //         'can' => 'report-user',
            //         'url'  => 'reports/taskLogs',
            //     ]),
            // ]);
        });
    }
}
