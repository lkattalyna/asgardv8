<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menus;
use App\OsGroup;
use App\Inventory;
use App\Http\Traits\ConnectionTrait;
use App\Http\Traits\VistasReutilizables\WindowsTrait;
use App\Http\Traits\VistasReutilizables\UnixTrait;

class VistasReutilizablesController extends Controller
{
    //
    use ConnectionTrait,WindowsTrait,UnixTrait;
    private $method = "local";


    public function index( $cliente, $automatizacion ){
        // $groups = $this->getGroups($inventario,$this->method);

        $view = "vistasReutilizables.";
        $rutaStore = route('premium.store',["cliente" => $cliente, "automatizacion" => $automatizacion]);
        // $rutaMenu =  str_replace('/asgard/','',Request()->getRequestUri());
        $rutaMenu = "premium/".$cliente."/".$automatizacion;
        // dd($rutaMenu);
        $menu = Menus::where('url',$rutaMenu)->first();
        $dataAdicional = [];
        $backpack = [];
        $permiso = $menu->can->name;
        $inventario = $menu->menuView->inventario;
        $grupo = $menu->menuView->grupo;
        $groups = [];
        $hosts = $this->getHostByInventoryAndGroup($inventario,$grupo)->pluck('name_host')->values()->toArray();

        switch( $automatizacion ){

            // # WINDOWS AUTOMATIZACIONES

            case 'testConectividad':
                $view .= "windows.connectivity";
                break;
            case 'gestionServicios':
                $view .= "windows.serviceManagementV2";
                $template = explode(";",$menu->menuView->template_playbook);
                $dataAdicional["rutaServicios"] = route('global.get',["automatizacion" => 'getServices']);
                $dataAdicional["idTemplateServicios"] = $template[1];


                break;
            case 'activacionLogsWin':
                $view .= "windows.activacionEnvioLogs";
                $template = explode(";",$menu->menuView->template_playbook);
                $dataAdicional["rutaGetLogs"] = route('global.get',["automatizacion" => 'getLogs']);
                $dataAdicional["idTemplateGetLogs"] = $template[1];
                break;

            case 'change_WIN':
                $view .= "windows.change";
                $gruposView = OsGroup::where('flag',$inventario)->where('show_to','all')->orderBy('name')->get();
                $backpack['grupos'] = $gruposView;
                break;
            case 'checkCPUProcess_WIN':
                $view .= "windows.checkCPUProcess";
                break;

            case 'rutasEstaticas_WIN':
                $view .= "windows.rutasEstaticas";
                break;

            case 'extUptime_WIN':
                $view .= "windows.extUptime";
                break;
            case 'inventario_WIN':
                $view .= "windows.inventario";
                break;

            // # UNIX AUTOMATIZACIONES
            case 'testConectividad_UNIX':
                $view .= "unix.connectivity_UNIX";
                break;


            case 'change_UNIX':
                $view .= "unix.change_UNIX";
                break;

            case 'gestionServiciosUnix':
                $view .= "unix.serviceManagementV2Unix";
                $template = explode(";",$menu->menuView->template_playbook);
                $dataAdicional["rutaServicios"] = route('global.get',["automatizacion" => 'getServicesUnix']);
                $dataAdicional["idTemplateServicios"] = $template[1];
                break;

            case 'PHcheckSOUnix':
                $view .= "unix.checkUnixPH";
                break;

            case 'activacionLogsUnix':
                $view .= "unix.activacionEnvioLogsUnix";
                $template = explode(";",$menu->menuView->template_playbook);
                $dataAdicional["rutaGetLogs"] = route('global.get',["automatizacion" => 'getLogsUnix']);
                $dataAdicional["idTemplateGetLogs"] = $template[1];
                break;

            case 'uptimeUnix':
                $view .= "unix.uptime";
                break;

            case 'RutasEstaticasUnix':
                $view .= "unix.rutasEstaticas";
                break;

            case 'inventarioUnix':
                $view .= 'unix.inventario';
                break;    
            default:
                return redirect('home');
        }



        $backpack = [
            "permiso" => $permiso,
            "groups" => $groups,
            "hosts"    => $hosts,
            "inventario" => $inventario,
            "rutaStore" => $rutaStore,
            "dataAdicional" => $dataAdicional
        ];

        return view($view,$backpack);


    }

    public function store( Request $request,$cliente,$automatizacion ){

        // $rutaMenu =  str_replace('/asgard/','',Request()->getRequestUri());
        $rutaMenu = "premium/".$cliente."/".$automatizacion;
        $menu = Menus::where('url',$rutaMenu)->first();
        $template = explode(";",$menu->menuView->template_playbook);
        switch($automatizacion) {
            case 'testConectividad':
                return $this->testConectividadStore($request,$template[0]);
            case 'gestionServicios':
                return $this->serviceManagementStoreV2($request, $template[0]);
            case 'activacionLogsWin':
                return $this->activacionEnvioLogsStore($request, $template[0]);
            case 'change_WIN':
                return $this->changeStoreWIN($request, $template[0]);
            case 'checkCPUProcess_WIN':
                return $this->checkCPUProcessStoreWIN($request, $template[0]);
            case 'rutasEstaticas_WIN':
                return $this->rutasEstaticasWINStore($request, $template[0]);
            case 'extUptime_WIN':
                return $this->extUptimeWINStore($request, $template[0]);
            case 'inventario_WIN':
                return $this->extUptimeWINStore($request, $template[0]);
            case 'inventario_WIN':
                return $this->inventarioWINStore($request,$template[0]);


            // # UNIX LOGS
            case 'testConectividad_UNIX':
                return $this->testConectividadUnixStore($request, $template[0]);
            case 'change_UNIX':
                return $this->changeStoreUnix($request, $template[0]);
            case 'gestionServiciosUnix':
                return $this->serviceManagementV2UnixStore($request,$template[0]);
                break;
            case 'PHcheckSOUnix':
                return $this->checkSOUnixStore($request, $template[0]);
            case 'activacionLogsUnix':
                return $this->activacionEnvioLogsUnixStore($request, $template[0]);
            case 'uptimeUnix':
                return $this->unixUptimeStore($request,$template[0]);
                break;
            case 'RutasEstaticasUnix':
                return $this->rutasEstaticasStore($request,$template[0]);
                break;
            case 'inventarioUnix':
                return $this->inventarioStore($request,$template[0]);
                break;        
            default:
                return redirect("home");
        }
    }

    public function peticionAuxilar( Request $request,$automatizacion ){
        $campos = $request->all();
        // $rutaMenu =  str_replace( '/asgard/','',$campos["urlMenu"]);
        // $menu = Menus::where('url',$rutaMenu)->first();
        // $template = explode(";",$menu->menuView->template_playbook);
        switch($automatizacion) {
            case 'getGroups':
                return $this->getGroupsAlternative($campos["inventario"],$this->method);
            case 'getServices':
                return $this->getServicesByHost( $request, $campos["id_template"] );
            case 'getLogs':
                return $this->getListLogNameByHost( $request, $campos["id_template"] );
            case 'getServicesUnix':
                return $this->getServicesUnixByHost( $request, $campos["id_template"] );
            case 'getLogsUnix':
                return $this->getListLogNameUnixByHost( $request, $campos["id_template"] );
            default:
                return redirect("home");
        }
    }

    public function getGroupsAlternative($inventario,$method){
        $grupos = Inventory::where('id_inventory',$inventario)->distinct()->orderBy('name_group')->get(['name_group','id_group']);
        $groups = array();
        foreach($grupos as $grupo){
            array_push($groups, $grupo);
        }
        return $groups;
    }


}
