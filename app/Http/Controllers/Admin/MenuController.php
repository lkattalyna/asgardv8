<?php

namespace App\Http\Controllers\Admin;


use App\Models\AutomatizacionesGlobales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Menus;
use App\MenuView;
use App\Inventory;
use Spatie\Permission\Models\Permission;
use App\Http\Traits\ConnectionTrait;
use DB;

class MenuController extends Controller
{
    //
    use ConnectionTrait;
    private $method = "local";

    public function index() {

        $menus = Menus::where('level',1)->with('can')->get();

        $backpack = [
            "menus" => $menus,

        ];
        return view('admin.viewMenu.consultar',$backpack);
    }

    public function create(){
        $menus = Menus::all();
        $permissions = Permission::all();
        $menuCreate = isset(request()->menu) ? request()->menu : NULL;
        $backpack = [
            "menus" => $menus,
            "permissions" => $permissions,
            "menuCreate" => (int) $menuCreate
        ];
        return view('admin.viewMenu.create', $backpack);
    }


    public function storeWithAutomatizacion(Request $request){

        $this->validate($request, [
            'id_menu_father' => 'required',
            'id_permission' => 'required',
            'text' => 'required',
            'order' => 'required',
            'url' => 'required',
            'so'  => 'required',
            'level' => 'required',
            'automatizacion' => 'required'
        ]);
        $campos = $request->all();



        $campos['url'] = $campos['url']."/".$campos['automatizacion'];
        $atributos = [
            'id_menu_father' => $campos['id_menu_father'],
            'id_permission' => $campos['id_permission'],
            'text' => $campos['text'],
            'icon' => $campos['icon'],
            'order' => $campos['order'],
            'is_title' => isset($campos['is_title']) ? 1 : 0,
            'url' => $campos['url'],
            'level' => $campos['level'],
        ];
        $data = Menus::create($atributos);

        $dataMenuView = $this->storeEspecializarMenu($request, $data->id);




        if(isset($data) && isset($dataMenuView)){
            if( (int) $campos['id_menu_father'] == 0){
                return redirect()->route('admin.menus.index')
                ->with('success', 'El menu ha sido creado con éxito');
            }else{
                return redirect()->route('admin.menus.show',["menu" => $campos['id_menu_father']])
                ->with('success', 'El menu ha sido creado con éxito');
            }
        }else{
            return redirect()->back()
                ->withErrors(['Hubo un error al crear el menú']);
        }
    }

    public function createWithAutomatizacion(){
        $menus = Menus::all();
        $permissions = Permission::all();
        $menuCreate = isset(request()->menu) ? request()->menu : NULL;
        $inventarios = DB::table('inventories')->distinct()->get(['id_inventory','name_inventory']);
        $backpack = [
            "menus" => $menus,
            "permissions" => $permissions,
            "menuCreate" => (int) $menuCreate,
            "contextSO" => AutomatizacionesGlobales::getContextSO(),
            "mainWindows" => AutomatizacionesGlobales::getAllMainWindows(),
            "mainUnix" => AutomatizacionesGlobales::getAllMainUnix(),
            "inventarios" => $inventarios
        ];
        // dd($backpack);
        return view('admin.viewMenu.createWithAuto', $backpack);
    }


    public function show($id) {

        $menuPadre = Menus::where('id',$id)->first();
        $menus = Menus::where('id_menu_father',$id)->with('can')->get();
        $menuView = null;
        $inventarios = [];
        if( !(COUNT($menus) > 0) ){
            $menuView = MenuView::where('id_menu',$id)->first();
            $inventarios = DB::table('inventories')->distinct()->get(['id_inventory','name_inventory']);
            // dd($inventarios);
        }

        // dd(Menus::all()->first());
        //dd(MenuView::all());
        $backpack = [
            "menus" => $menus,
            "menuPadre" => $menuPadre,
            "menuView" => $menuView,
            "inventarios" => $inventarios,
            "contextSO" => AutomatizacionesGlobales::getContextSO(),
            "mainWindows" => AutomatizacionesGlobales::getAllMainWindows(),
            "mainUnix" => AutomatizacionesGlobales::getAllMainUnix()
        ];
        return view('admin.viewMenu.show',$backpack);
    }

    public function store( Request $request ){
        $this->validate($request, [
            'id_menu_father' => 'required',
            'id_permission' => 'required',
            'text' => 'required',
            'order' => 'required',
            'url' => 'required',
            'level' => 'required',
        ]);
        $campos = $request->all();
        $atributos = [
            'id_menu_father' => $campos['id_menu_father'],
            'id_permission' => $campos['id_permission'],
            'text' => $campos['text'],
            'icon' => $campos['icon'],
            'order' => $campos['order'],
            'is_title' => isset($campos['is_title']) ? 1 : 0,
            'url' => $campos['url'],
            'level' => $campos['level'],
        ];
        $data = Menus::create($atributos);
        if(isset($data)){
            if( (int) $campos['id_menu_father'] == 0){
                return redirect()->route('admin.menus.index')
                ->with('success', 'El menu ha sido creado con éxito');
            }else{
                return redirect()->route('admin.menus.show',["menu" => $campos['id_menu_father']])
                ->with('success', 'El menu ha sido creado con éxito');
            }
        }else{
            return redirect()->back()
                ->withErrors(['Hubo un error al crear el menú']);
        }
        //dd($atributos);
    }

    public function destroy($id){

        $data = Menus::where('id',$id)->first();
        // dd($data);
        if(isset($data)){
            if( (int) $data->id_menu_father == 0){
                $data->delete();
                return redirect()->route('admin.menus.index')
                ->with('success', 'El menu ha sido desactivado con éxito');
            }else{
                $data->delete();
                return redirect()->route('admin.menus.show',["menu" => $data->id_menu_father])
                ->with('success', 'El menu ha sido desactivado con éxito');
            }
        }else{
            return redirect()->back()
                ->withErrors(['Hubo un error al desactivar el menú']);
        }

    }

    public function edit($id){
        $menuEdit = Menus::where('id',$id)->with('relBelongSubmenu')->first();
        $menusKeys = Menus::getMenusKeyFather($id);
        $menus = Menus::whereNotIn('id',$menusKeys)->get();

        $permissions = Permission::all();
        $backpack = [
            "menuEdit" => $menuEdit,
            "menus" => $menus,
            "permissions" => $permissions
        ];
        return view('admin.viewMenu.edit', $backpack);

    }

    public function update(Request $request,$id){
        $this->validate($request, [
            'id_menu_father' => 'required',
            'id_permission' => 'required',
            'text' => 'required',
            'order' => 'required',
            'url' => 'required',
            'level' => 'required',
        ]);
        $campos = $request->all();
        $atributos = [
            'id_menu_father' => $campos['id_menu_father'],
            'id_permission' => $campos['id_permission'],
            'text' => $campos['text'],
            'icon' => $campos['icon'],
            'order' => $campos['order'],
            'is_title' => isset($campos['is_title']) ? 1 : 0,
            'url' => $campos['url'],
            'level' => $campos['level'],
        ];


        $data = Menus::where('id',$id)->update($atributos);

        if(isset($data)){
            if( (int) $campos['id_menu_father'] == 0){
                return redirect()->route('admin.menus.index')
                ->with('success', 'El menu ha sido actualizado con éxito');
            }else{
                return redirect()->route('admin.menus.show',["menu" => $campos['id_menu_father']])
                ->with('success', 'El menu ha sido actualizado con éxito');
            }
        }else{
            return redirect()->back()
                ->withErrors(['Hubo un error al crear el menú']);
        }

    }

    public function createWithSubMenus(Request $request, $menuCreate){

        $campos = $request->all();
        $menus = Menus::all();
        $permissions = Permission::all();
        $menusSelected = Menus::getMenusKeyFatherWithText($menuCreate);
        // $menuCreate = $menuCreate;
        $backpack = [
            "menus" => $menus,
            "permissions" => $permissions,
            "menuCreate" => (int) $menuCreate,
            "menuAdicionados" =>  $campos["menusAdicionados"],
            "menusAdicionadosTitulos" =>  explode(";",$campos["menusAdicionadosTitulos"]),
            "menusSelected" => $menusSelected
        ];
        return view('admin.viewMenu.createWithSubMenus', $backpack);
    }

    public function storeWithSubMenus(Request $request){
        $campos = $request->all();
        $menus = explode(";",$campos["menuAdicionados"]);

        if( $campos["subMenuTipo"]  == "reasignacion") {

            foreach($menus as $menu){
                $menu = Menus::find($menu);
                $menu->id_menu_father = $campos["menuPadreReasignar"];
                $menu->save();
            }

            return redirect()->route('admin.menus.show',["menu" => $campos["menuPadreReasignar"]])
                    ->with('success', 'El menu ha sido creado y se reasignaron los menus con éxito');

        }

        if( $campos["subMenuTipo"]  == "conCreacion"){

            $this->validate($request, [
                'id_menu_father' => 'required',
                'id_permission' => 'required',
                'text' => 'required',
                'order' => 'required',
                'url' => 'required',
                'level' => 'required',
            ]);
            $campos = $request->all();
            $atributos = [
                'id_menu_father' => $campos['id_menu_father'],
                'id_permission' => $campos['id_permission'],
                'text' => $campos['text'],
                'icon' => $campos['icon'],
                'order' => $campos['order'],
                'is_title' => isset($campos['is_title']) ? 1 : 0,
                'url' => $campos['url'],
                'level' => $campos['level'],
            ];
            $data = Menus::create($atributos);



            if(isset($data)){
                foreach($menus as $menu){
                    $menu = Menus::find($menu);
                    $menu->id_menu_father = $data->id;
                    $menu->save();
                }

                return redirect()->route('admin.menus.show',["menu" => $data->id])
                    ->with('success', 'El menu ha sido creado y se reasignaron los menus con éxito');


            }else{
                return redirect()->back()
                    ->withErrors(['Hubo un error al crear el menú']);
            }

        }


    }



    private function storeEspecializarMenu(Request $request , $idMenu = null, $automatizacion = null){
        $campos = $request->all();

        if( !$idMenu ){
            $menuView = MenuView::where('id_menu',$campos['id_menu'])->first();
        }else{
            $campos["id_menu"] = $idMenu;
            if($campos['so'] == 'unix'){
                $playbooks = AutomatizacionesGlobales::getAllMainUnix()->where('value',$campos['automatizacion'])->first()['playbooks'];
                $campos['template_playbook'] = $playbooks;
            }

            if($campos['so'] == 'windows'){
                $playbooks = AutomatizacionesGlobales::getAllMainWindows()->where('value',$campos['automatizacion'])->first()['playbooks'];
                $campos['template_playbook'] = $playbooks;
            }

            $menuView = MenuView::where('id_menu',$campos['id_menu'])->first();
        }

        $atributos = [
            'id_menu' => $campos['id_menu'],
            'template_playbook' => $campos['template_playbook'],
            'inventario' => $campos['inventario'],
            'grupo' => $campos['grupo'],
        ];

        if( isset($menuView) ){
            $data = MenuView::where('id_menu',$campos['id_menu'])->update($atributos);
        }else{
            $data = MenuView::create($atributos);
        }

        return $data;
    }


    public function especializarMenu(Request $request){

        $data = $this->storeEspecializarMenu($request);

        return redirect()->back()
        ->with('success', 'El menu ha sido actualizado con éxito');

    }

    public function cargarMenus(){
        // [
        //     "id"
        //     id_menu_father
        //     id_permission
        //     text
        //     icon
        //     order
        //     url
        //     is_title
        //     level
        // ]

        $permissions = Permission::all();

        DB::table('menu')->truncate();
        // dd($permissions->where('name','administration-menu')->first()->id);
        $menus = [
            [
                'id_menu_father' => 0,
                'text' => 'ADMINISTRACIÓN',
                'icon' => 'fas fa-key',
                'id_permission' => $permissions->where('name','administration-menu')->first()->id,
                'order' => 1,
                'level' => 1,
                'url'  => '/',
                'is_title' => 0
            ],
            [
                'id_menu_father' => 0,
                'text' => 'GESTION',
                'icon' => 'fas fa-key',
                'id_permission' => $permissions->where('name','gestion-menu')->first()->id,
                'order' => 2,
                'level' => 1,
                'url'  => '/',
                'is_title' => 0
            ],
            [
                'id_menu_father' => 0,
                'text' => 'SOPORTE DC',
                'icon' => '',
                'id_permission' => 1,
                'order' => 3,
                'level' => 1,
                'url'  => '/',
                'is_title' => 1
            ],
            [
                'id_menu_father' => 0,
                'text' => 'SOPORTE E&N',
                'icon' => 'far fa-circle',
                'id_permission' => $permissions->where('name','supportEN-menu')->first()->id,
                'order' => 4,
                'level' => 1,
                'url'  => '/',
                'is_title' => 0
            ],
            [
                'id_menu_father' => 0,
                'text' => 'CAPAS DE APLICACIÓN',
                'icon' => '',
                'id_permission' => 1,
                'order' => 5,
                'level' => 1,
                'url'  => '/',
                'is_title' => 1
            ],
            [
                'id_menu_father' => 0,
                'text' => 'POLIEDRO',
                'icon' => 'far fa-circle',
                'id_permission' => $permissions->where('name','poliedro-menu')->first()->id,
                'order' => 6,
                'level' => 1,
                'url'  => '/',
                'is_title' => 0
            ],
            [
                'id_menu_father' => 0,
                'text' => 'CAPAS DE SERVICIO',
                'icon' => '',
                'id_permission' => 1,
                'order' => 7,
                'level' => 1,
                'url'  => '/',
                'is_title' => 1
            ],
            [
                'id_menu_father' => 0,
                'text' => 'AMT',
                'icon' => 'far fa-circle',
                'id_permission' => $permissions->where('name','amt-menu')->first()->id,
                'order' => 8,
                'level' => 1,
                'url'  => '/',
                'is_title' => 0
            ],
            [
                'id_menu_father' => 0,
                'text' => 'BACKUP',
                'icon' => 'far fa-circle',
                'id_permission' => $permissions->where('name','backup-menu')->first()->id,
                'order' => 9,
                'level' => 1,
                'url'  => '/',
                'is_title' => 0
            ],
            [
                'id_menu_father' => 0,
                'text' => 'BALANCEADORES',
                'icon' => 'far fa-circle',
                'id_permission' => $permissions->where('name','balancer-menu')->first()->id,
                'order' => 10,
                'level' => 1,
                'url'  => '/',
                'is_title' => 0
            ],
            [
                'id_menu_father' => 0,
                'text' => 'CHECK PASO OPERACIÓN',
                'icon' => 'far fa-circle',
                'id_permission' => $permissions->where('name','pasosOP-menu')->first()->id,
                'order' => 11,
                'level' => 1,
                'url'  => '/',
                'is_title' => 0
            ],
            [
                'id_menu_father' => 0,
                'text' => 'CLOUD',
                'icon' => 'far fa-circle',
                'id_permission' => $permissions->where('name','cloud-menu')->first()->id,
                'order' => 12,
                'level' => 1,
                'url'  => '/',
                'is_title' => 0
            ],
            [
                'id_menu_father' => 0,
                'text' => 'CLOUD',
                'icon' => 'far fa-circle',
                'id_permission' => $permissions->where('name','cloud-menu')->first()->id,
                'order' => 13,
                'level' => 1,
                'url'  => '/',
                'is_title' => 0
            ],
            [
                'id_menu_father' => 0,
                'text' => 'DESPLIEGUE IaaS',
                'icon' => 'far fa-circle',
                'id_permission' => $permissions->where('name','implementation-menu')->first()->id,
                'order' => 14,
                'level' => 1,
                'url'  => '/',
                'is_title' => 0
            ],
            [
                'id_menu_father' => 0,
                'text' => 'OPERADORES',
                'icon' => 'far fa-circle',
                'id_permission' => $permissions->where('name','operator-menu')->first()->id,
                'order' => 15,
                'level' => 1,
                'url'  => '/',
                'is_title' => 0
            ],
            [
                'id_menu_father' => 0,
                'text' => 'REDES',
                'icon' => 'far fa-circle',
                'id_permission' => $permissions->where('name','networking-menu')->first()->id,
                'order' => 16,
                'level' => 1,
                'url'  => '/',
                'is_title' => 0
            ],
            [
                'id_menu_father' => 0,
                'text' => 'REDES PYMES',
                'icon' => 'far fa-circle',
                'id_permission' => $permissions->where('name','networking-pymes-menu')->first()->id,
                'order' => 17,
                'level' => 1,
                'url'  => '/',
                'is_title' => 0
            ],
            [
                'id_menu_father' => 0,
                'text' => 'SAN',
                'icon' => 'far fa-circle',
                'id_permission' => $permissions->where('name','san-menu')->first()->id,
                'order' => 18,
                'level' => 1,
                'url'  => '/',
                'is_title' => 0
            ],
            [
                'id_menu_father' => 0,
                'text' => 'SEGURIDAD DC',
                'icon' => 'far fa-circle',
                'id_permission' => $permissions->where('name','ManagedSecurity-menu')->first()->id,
                'order' => 19,
                'level' => 1,
                'url'  => '/',
                'is_title' => 0
            ],
            [
                'id_menu_father' => 0,
                'text' => 'TELEFONÍA',
                'icon' => 'far fa-circle',
                'id_permission' => $permissions->where('name','telephony-menu')->first()->id,
                'order' => 20,
                'level' => 1,
                'url'  => '/',
                'is_title' => 0
            ],
            [
                'id_menu_father' => 0,
                'text' => 'UNIX',
                'icon' => 'far fa-circle',
                'id_permission' => $permissions->where('name','unix-menu')->first()->id,
                'order' => 21,
                'level' => 1,
                'url'  => '/',
                'is_title' => 0
            ],
            [
                'id_menu_father' => 0,
                'text' => 'WINDOWS',
                'icon' => 'far fa-circle',
                'id_permission' => $permissions->where('name','windows-menu')->first()->id,
                'order' => 22,
                'level' => 1,
                'url'  => '/',
                'is_title' => 0
            ],
            [
                'id_menu_father' => 0,
                'text' => 'VIRTUALIZACIÓN',
                'icon' => 'far fa-circle',
                'id_permission' => $permissions->where('name','virtualization-menu')->first()->id,
                'order' => 23,
                'level' => 1,
                'url'  => '/',
                'is_title' => 0
            ],
            [
                'id_menu_father' => 0,
                'text' => 'RECURSOS',
                'icon' => 'far fa-circle',
                'id_permission' => $permissions->where('name','recursos-menu')->first()->id,
                'order' => 24,
                'level' => 1,
                'url'  => '/',
                'is_title' => 0
            ],
            [
                'id_menu_father' => 0,
                'text' => 'UTILIDADES',
                'icon' => '',
                'id_permission' => 1,
                'order' => 25,
                'level' => 1,
                'url'  => '/',
                'is_title' => 1
            ],
            [
                'id_menu_father' => 0,
                'text' => 'HERRAMIENTAS EXTERNAS',
                'icon' => 'far fa-circle',
                'id_permission' => $permissions->where('name','externalToolLog-menu')->first()->id,
                'order' => 26,
                'level' => 1,
                'url'  => 'externalToolLogs/',
                'is_title' => 0
            ],
            [
                'id_menu_father' => 0,
                'text' => 'LOGS',
                'icon' => 'far fa-circle',
                'id_permission' => $permissions->where('name','executionLog-menu')->first()->id,
                'order' => 27,
                'level' => 1,
                'url'  => 'executionLogs/',
                'is_title' => 0
            ],
            [
                'id_menu_father' => 0,
                'text' => 'REPORTES',
                'icon' => 'far fa-circle',
                'id_permission' => $permissions->where('name','report-menu')->first()->id,
                'order' => 28,
                'level' => 1,
                'url'  => '/',
                'is_title' => 0
            ],
        ];



        $menusN2Administracion = [
            [
                'id_menu_father' => 1,
                'text' => 'Roles',
                'icon' => 'fas fa-lock',
                'order' => 1,
                'is_title' => 0,
                'id_permission' => $permissions->where('name','rol-admin')->first()->id,
                'url'  => 'roles/',
                'level' => 2
            ],
            [
                'id_menu_father' => 1,
                'text' => 'Permisos',
                'icon' => 'fas fa-lock',
                'order' => 2,
                'is_title' => 0,
                'id_permission' => $permissions->where('name','permission-admin')->first()->id,
                'url'  => 'permissions/',
                'level' => 2
            ],
            [
                'id_menu_father' => 1,
                'text' => 'Usuarios',
                'icon' => 'fas fa-users',
                'order' => 3,
                'is_title' => 0,
                'id_permission' => $permissions->where('name','user-admin')->first()->id,
                'url'  => 'users/',
                'level' => 2
            ],
            [
                'id_menu_father' => 1,
                'text' => 'Automatizaciones',
                'icon' => 'fas fa-robot',
                'order' => 4,
                'is_title' => 0,
                'id_permission' => $permissions->where('name','regImprovement-menu')->first()->id,
                'url'  => '/',
                'level' => 2,
            ],
            [
                'id_menu_father' => 1,
                'text' => 'Desarrollo',
                'icon' => 'fas fa-code',
                'order' => 5,
                'is_title' => 0,
                'id_permission' => $permissions->where('name','devRequest-menu')->first()->id,
                'url'  => '/',
                'level' => 2,
            ],
            [
                'id_menu_father' => 1,
                'text' => 'Logs de login',
                'icon' => 'fas fa-clipboard-check',
                'order' => 6,
                'is_title' => 0,
                'id_permission' => $permissions->where('name','loginLog-admin')->first()->id,
                'url'  => 'loginLogs/',
                'level' => 2
            ],
            [
                'id_menu_father' => 1,
                'text' => 'Logs de sincronización',
                'icon' => 'fas fa-clipboard-check',
                'order' => 7,
                'is_title' => 0,
                'id_permission' => 0,
                'url'  => 'syncLogs/',
                'level' => 2
            ]
        ];

        $menuN3Administracion = [
            [
                'id_menu_father' => 32,
                'level' => 2,
                'is_title' => 0,
                'order' => 1,
                'text' => 'Capas de servicio',
                'icon' => 'fas fa-layer-group',
                'id_permission' => $permissions->where('name','regServiceLayer-admin')->first()->id,
                'url'  => 'RegServiceLayers',
                ],
                [
                'id_menu_father' => 32,
                'level' => 2,
                'is_title' => 0,
                'order' => 2,
                'text' => 'Niveles de cliente',
                'icon' => 'fas fa-layer-group',
                'id_permission' => $permissions->where('name','regCustomerLevel-admin')->first()->id,
                'url'  => 'RegCustomerLevels',
                ],
                [
                'id_menu_father' => 32,
                'level' => 2,
                'is_title' => 0,
                'order' => 3,
                'text' => 'Periodos',
                'icon' => 'fas fa-calendar-alt',
                'id_permission' => $permissions->where('name','regQuarter-admin')->first()->id,
                'url'  => 'RegQuarters',
                ],
                [
                'id_menu_father' => 32,
                'level' => 2,
                'is_title' => 0,
                'order' => 4,
                'text' => 'Segmentos de servicio',
                'icon' => 'fas fa-layer-group',
                'id_permission' => $permissions->where('name','regServiceSegment-admin')->first()->id,
                'url'  => 'RegServiceSegments',
                ],
                [
                'id_menu_father' => 32,
                'level' => 2,
                'is_title' => 0,
                'order' => 5,
                'text' => 'Servicios consumidos',
                'icon' => 'fas fa-layer-group',
                'id_permission' => $permissions->where('name','regConsumedService-admin')->first()->id,
                'url'  => 'RegConsumedServices',
                ],
                [
                    'id_menu_father' => 33,
                    'level' => 2,
                    'is_title' => 0,
                    'order' => 1,
                    'text' => 'Estados',
                    'icon' => 'fas fa-traffic-light',
                    'id_permission' => $permissions->where('name','devState-admin')->first()->id,
                    'url'  => 'dev/devStates',
                ],
                [
                    'id_menu_father' => 33,
                    'level' => 2,
                    'is_title' => 0,
                    'order' => 2,
                    'text' => 'Requerimientos',
                    'icon' => 'fas fa-ticket-alt',
                    'id_permission' => $permissions->where('name','devRequest-admin')->first()->id,
                    'url'  => 'dev/devRequests/admin',
                ],
                [
                    'id_menu_father' => 33,
                    'level' => 2,
                    'is_title' => 0,
                    'order' => 3,
                    'text' => 'Tareas',
                    'icon' => 'fas fa-tasks',
                    'id_permission' => $permissions->where('name','devTask-admin')->first()->id,
                    'url'  => 'dev/devTasks',
                ]
        ];

        $menuN1Gestion = [
            [
                'id_menu_father' => 2,
                'level' => 2,
                'is_title' => 0,
                'order' => 1,
                'text' => 'Automatizaciones',
                'icon' => 'fas fa-robot',
                'id_permission' => $permissions->where('name','regImprovement-user')->first()->id,
                'url'  => 'improvements',
            ],
            [
                'id_menu_father' => 2,
                'level' => 2,
                'is_title' => 0,
                'order' => 1,
                'text' => 'Documentación',
                'icon' => 'fas fa-book',
                'id_permission' => $permissions->where('name','documentation-menu')->first()->id,
                'url'  => 'documentations/',
            ],
            [
                'id_menu_father' => 2,
                'level' => 2,
                'is_title' => 0,
                'order' => 1,
                'text' => 'Grupos SO',
                'icon' => 'fas fa-sitemap',
                'id_permission' => $permissions->where('name','OsGroup-admin')->first()->id,
                'url'  => 'osGroups/',
            ],
            [
                'id_menu_father' => 2,
                'level' => 2,
                'is_title' => 0,
                'order' => 1,
                'text' => 'Inventarios',
                'icon' => 'fas fa-clipboard-list',
                'id_permission' => $permissions->where('name','inventory-menu')->first()->id,
                'url'  => 'inventories/',
            ],
            [
                'id_menu_father' => 2,
                'level' => 2,
                'is_title' => 0,
                'order' => 1,
                'text' => 'Mis requerimientos',
                'icon' => 'fas fa-ticket-alt',
                'id_permission' => $permissions->where('name','devRequest-user')->first()->id,
                'url'  => 'dev/devRequests',
            ],
            [
                'id_menu_father' => 2,
                'level' => 2,
                'is_title' => 0,
                'order' => 1,
                'text' => 'Templates AWX',
                'icon' => 'fas fa-clipboard',
                'id_permission' => $permissions->where('name','awxTemplate-admin')->first()->id,
                'url'  => 'awxTemplates/',
            ],
            [
                'id_menu_father' => 2,
                'level' => 2,
                'is_title' => 0,
                'order' => 1,
                'text' => 'Vcenters',
                'icon' => 'fas fa-cloud-meatball',
                'id_permission' => $permissions->where('name','awxTemplate-admin')->first()->id,
                'url'  => 'vcenters/',
            ],
        ];

        $reportesMenus = [
            [
                'id_menu_father' => 28,
                'level' => 2,
                'is_title' => 0,
                'order' => 1,
                'text' => 'Automatizaciones',
                'icon' => 'fas fa-robot',
                'id_permission' => $permissions->where('name','report-user')->first()->id,
                'url'  => 'reports/automation',
            ],[
                'id_menu_father' => 28,
                'level' => 2,
                'is_title' => 0,
                'order' => 2,
                'text' => 'RDR',
                'icon' => 'fas fa-robot',
                'id_permission' => $permissions->where('name','report-user')->first()->id,
                'url'  => 'reports/rdr',
            ],[
                'id_menu_father' => 28,
                'level' => 2,
                'is_title' => 0,
                'order' => 3,
                'text' => 'Tareas ejecutadas',
                'icon' => 'fas fa-list',
                'id_permission' => $permissions->where('name','report-user')->first()->id,
                'url'  => 'reports/taskLogs',
            ]
        ];


        $menusRecursos = [
            [
                'id_menu_father' => 24,
                'order' => 1,
                'is_title' => 0,
                'id_permission' => $permissions->where('name','recursos-menu')->first()->id,
                'url'  => '/',
                'level' => 2,
                'text' => 'COMPONENTES',
                'icon' => 'fas fa-fw fa-database',
            ],
            [
                'id_menu_father' => 24,
                'order' => 2,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => $permissions->where('name','recursos-menu')->first()->id,
                'text' => 'HARDWARE',
                'url'  => '/',
                'icon' => 'fas fa-fw fa-server',
            ],
                [
                    'id_menu_father' => 54,
                    'order' => 1,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => $permissions->where('name','recursos-menu')->first()->id,
                    'text'  => 'Clientes',
                    'url'   => 'infrastructure/server/components/clientes',
                    'icon'  => 'fas fa-fw fa-user-md',
                ],[
                    'id_menu_father' => 54,
                    'order' => 2,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => $permissions->where('name','recursos-menu')->first()->id,
                    'text'  => 'Marcas',
                    'url'   => 'infrastructure/server/server/marcas',
                    'icon'  => 'fas fa-fw fa-bars',
                ],[
                    'id_menu_father' => 54,
                    'order' => 3,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => $permissions->where('name','recursos-menu')->first()->id,
                    'text'  => 'Modelos',
                    'url'   => 'infrastructure/server/server/modelos',
                    'icon'  => 'fas fa-fw fa-barcode',
                ],[
                    'id_menu_father' => 54,
                    'order' => 4,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => $permissions->where('name','recursos-menu')->first()->id,
                    'text'  => 'Controladoras',
                    'url'   => 'infrastructure/server/components/controladoras',
                    'icon'  => 'fas fa-fw fa-random',
                ],[
                    'id_menu_father' => 54,
                    'order' => 5,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => $permissions->where('name','recursos-menu')->first()->id,
                    'text'  => 'CPU Marcas',
                    'url'   => 'infrastructure/server/components/cpuMarcas',
                    'icon'  => 'fas fa-fw fa-list-ol',
                ],[
                    'id_menu_father' => 54,
                    'order' => 6,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => $permissions->where('name','recursos-menu')->first()->id,
                    'text'  => 'CPU Modelos',
                    'url'   => 'infrastructure/server/components/cpuModelos',
                    'icon'  => 'fas fa-fw fa-list-ol',
                ],[
                    'id_menu_father' => 54,
                    'order' => 7,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => $permissions->where('name','recursos-menu')->first()->id,
                    'text'  => 'Data Centers',
                    'url'   => 'infrastructure/server/components/dataCenter',
                    'icon'  => 'fas fa-fw fa-globe',
                ],[
                    'id_menu_father' => 54,
                    'order' => 8,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => $permissions->where('name','recursos-menu')->first()->id,
                    'text'  => 'Disco Marcas',
                    'url'   => 'infrastructure/server/components/discoMarcas',
                    'icon'  => 'fas fa-fw fa-list-ol',
                ],[
                    'id_menu_father' => 54,
                    'order' => 9,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => $permissions->where('name','recursos-menu')->first()->id,
                    'text'  => 'Estados Servidor',
                    'url'   => 'infrastructure/server/components/serverEstados',
                    'icon'  => 'fas fa-fw fa-list-ol',
                ],[
                    'id_menu_father' => 54,
                    'order' => 10,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => $permissions->where('name','recursos-menu')->first()->id,
                    'text'  => 'Nic Referencias',
                    'url'   => 'infrastructure/server/components/nicReferencias',
                    'icon'  => 'fas fa-fw fa-list-ol',
                ],[
                    'id_menu_father' => 54,
                    'order' => 12,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => $permissions->where('name','recursos-menu')->first()->id,
                    'text'  => 'Propietarios',
                    'url'   => 'infrastructure/server/components/propietarios',
                    'icon'  => 'fas fa-fw fa-user',
                ],[
                    'id_menu_father' => 54,
                    'order' => 13,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => $permissions->where('name','recursos-menu')->first()->id,
                    'text'  => 'Raids',
                    'url'   => 'infrastructure/server/components/raids',
                    'icon'  => 'fas fa-fw fa-align-justify',
                ],[
                    'id_menu_father' => 54,
                    'order' => 14,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => $permissions->where('name','recursos-menu')->first()->id,
                    'text'  => 'Responsables',
                    'url'   => 'infrastructure/server/components/responsables',
                    'icon'  => 'fas fa-fw fa-user-plus',
                ],[
                    'id_menu_father' => 54,
                    'order' => 15,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => $permissions->where('name','recursos-menu')->first()->id,
                    'text'  => 'Sistema Operativo',
                    'url'   => 'infrastructure/server/components/sistemaOperativo',
                    'icon'  => 'fas fa-fw fa-registered',
                ],[
                    'id_menu_father' => 54,
                    'order' => 16,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => $permissions->where('name','recursos-menu')->first()->id,
                    'text'  => 'Tipo de Cliente',
                    'url'   => 'infrastructure/server/components/tiposCliente',
                    'icon'  => 'fas fa-fw fa-list-ol',
                ],[
                    'id_menu_father' => 54,
                    'order' => 17,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => $permissions->where('name','recursos-menu')->first()->id,
                    'text'  => 'Tipo de Hardware',
                    'url'   => 'infrastructure/server/components/tiposHardware',
                    'icon'  => 'fas fa-fw fa-list-ol',
                ],[
                    'id_menu_father' => 54,
                    'order' => 18,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => $permissions->where('name','recursos-menu')->first()->id,
                    'text'  => 'Tipo de memoria',
                    'url'   => 'infrastructure/server/components/tipoMemorias',
                    'icon'  => 'fas fa-fw fa-list-ol',
                ],[
                    'id_menu_father' => 54,
                    'order' => 19,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => $permissions->where('name','recursos-menu')->first()->id,
                    'text'  => 'Tipo de Rack',
                    'url'   => 'infrastructure/server/components/tiposRack',
                    'icon'  => 'fas fa-fw fa-list-ol',
                ],[
                    'id_menu_father' => 54,
                    'order' => 20,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => $permissions->where('name','recursos-menu')->first()->id,
                    'text'  => 'Tipo de Servicio',
                    'url'   => 'infrastructure/server/components/tiposServicio',
                    'icon'  => 'fas fa-fw fa-list-ol',
                ],



                [
                    'id_menu_father' => 55,
                    'order' => 1,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => $permissions->where('name','recursos-menu')->first()->id,
                    'text'  => 'Búsqueda de Servidor',
                    'url'   => 'infrastructure/server/server/servers/search',
                    'icon'  => 'fas fa-fw fa-search',
                ],[
                    'id_menu_father' => 55,
                    'order' => 2,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => $permissions->where('name','recursos-menu')->first()->id,
                    'text'  => 'Logs de actualización',
                    'url'   => 'infrastructure/server/server/updateLogs',
                    'icon'  => 'fas fa-fw fa-sync',
                ],[
                    'id_menu_father' => 55,
                    'order' => 3,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => $permissions->where('name','recursos-menu')->first()->id,
                    'text'  => 'Paquetes de actualización',
                    'url'   => 'infrastructure/server/server/updatePacks',
                    'icon'  => 'fas fa-fw fa-sync',
                ],[
                    'id_menu_father' => 55,
                    'order' => 4,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => $permissions->where('name','recursos-menu')->first()->id,
                    'text'  => 'Actualizar FW',
                    'url'   => 'infrastructure/server/server/updatePacks/search',
                    'icon'  => 'fas fa-fw fa-sync',
                ],[
                    'id_menu_father' => 55,
                    'order' => 5,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => $permissions->where('name','recursos-menu')->first()->id,
                    'text'  => 'Servidores',
                    'url'   => 'infrastructure/server/server/servers',
                    'icon'  => 'fas fa-fw fa-server',
                ]
        ];

        $menusVirtualizacion = [
            [
                'id_menu_father' => 23,
                'order' => 1,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => $permissions->where('name','virtualization-mixed')->first()->id,
                'text' => 'Diagnostico MV',
                'icon' => 'fas fa-diagnoses',
                'url'  => 'virtualizations/diagnostic',
            ],[
                'id_menu_father' => 23,
                'order' => 2,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => $permissions->where('name','virtualization-mixed')->first()->id,
                'text' => 'Consumos MV',
                'icon' => 'fas fa-chart-bar',
                'url'  => 'virtualizations/consumption',
            ],[
                'id_menu_father' => 23,
                'order' => 3,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => $permissions->where('name','virtualization-admin')->first()->id,
                'text' => 'Consola VmWare',
                'icon' => 'fas fa-terminal',
                'url'  => 'virtualizations/commandExe',
            ],[
                'id_menu_father' => 23,
                'order' => 4,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => $permissions->where('name','virtualization-mixed')->first()->id,
                'text' => 'Consumo cliente MVs',
                'icon' => 'fas fa-chart-bar',
                'url'  => 'virtualizations/cVMCustomer',
            ],[
                'id_menu_father' => 23,
                'order' => 5,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => $permissions->where('name','virtualization-user')->first()->id,
                'text' => 'Corrección check PO',
                'icon' => 'fas fa-thumbs-up',
                'url'  => 'virtualizations/checkVMRepairSearch',
            ],[
                'id_menu_father' => 23,
                'order' => 6,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => $permissions->where('name','virtualization-user')->first()->id,
                'text' => 'Inventario de plataformas',
                'icon' => 'fas fa-list',
                'url'  => 'virtualizations/inventory',
            ],[
                'id_menu_father' => 23,
                'order' => 7,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => $permissions->where('name','virtualization-mixed')->first()->id,
                'text' => 'Paso a operación Host',
                'icon' => 'fas fa-thumbs-up',
                'url'  => 'virtualizations/checkHost',
            ],[
                'id_menu_father' => 23,
                'order' => 8,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => $permissions->where('name','virtualization-user')->first()->id,
                'text' => 'Paso a operación VM',
                'icon' => 'fas fa-thumbs-up',
                'url'  => 'virtualizations/operationStep',
            ],[
                'id_menu_father' => 23,
                'order' => 9,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => $permissions->where('name','virtualization-user')->first()->id,
                'text' => 'Reportes',
                'icon' => 'fas fa-file-invoice',
                'url'  => 'virtualizations/reports',
            ],[
                'id_menu_father' => 23,
                'order' => 10,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => $permissions->where('name','virtualization-user')->first()->id,
                'text' => 'Reporte Cluster Capacity ',
                'icon' => 'fas fa-file-invoice',
                'url'  => 'virtualizations/clusterCapacityReport',
            ],[
                'id_menu_father' => 23,
                'order' => 11,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => $permissions->where('name','virtualization-user')->first()->id,
                'text' => 'Reporte VMHosts',
                'icon' => 'fas fa-file-invoice',
                'url'  => 'virtualizations/VMHostReport',
            ],[
                'id_menu_father' => 23,
                'order' => 12,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => $permissions->where('name','virtualization-user')->first()->id,
                'text' => 'Reporte VMHost HBA',
                'icon' => 'fas fa-file-invoice',
                'url'  => 'virtualizations/VMHBAReport',
            ],[
                'id_menu_father' => 23,
                'order' => 13,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => $permissions->where('name','virtualization-user')->first()->id,
                'text' => 'Reporte VMHost NIC',
                'icon' => 'fas fa-file-invoice',
                'url'  => 'virtualizations/VMNICReport',
            ],
            [
                'id_menu_father' => 23,
                'order' => 14,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => $permissions->where('name','virtualization-mixed')->first()->id,
                'text' => 'Snapshots',
                'icon' => 'fas fa-camera',
                'url'  => '/',
            ],

                [
                    'id_menu_father' => 93,
                    'order' => 1,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => $permissions->where('name','virtualization-mixed')->first()->id,
                    'text' => 'Toma de snapshot',
                    'icon' => 'fas fa-plus-square',
                    'url'  => 'virtualizations/snapshots/create',
                ],[
                    'id_menu_father' => 93,
                    'order' => 2,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => $permissions->where('name','virtualization-mixed')->first()->id,
                    'text' => 'Programar snapshot',
                    'icon' => 'fas fa-plus-square',
                    'url'  => 'virtualizations/snapshots/schedule',
                ],[
                    'id_menu_father' => 93,
                    'order' => 3,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => $permissions->where('name','virtualization-mixed')->first()->id,
                    'text' => 'Borrado de snapshot',
                    'icon' => 'fas fa-minus-square',
                    'url'  => 'virtualizations/snapshots/delete',
                ],[
                    'id_menu_father' => 93,
                    'order' => 4,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => $permissions->where('name','virtualization-mixed')->first()->id,
                    'text' => 'Revertir snapshot',
                    'icon' => 'fas fa-fast-backward',
                    'url'  => 'virtualizations/snapshots/revert',
                ],
            [
                'id_menu_father' => 23,
                'order' => 15,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => $permissions->where('name','virtualization-user')->first()->id,
                'text' => 'Tag MV',
                'icon' => 'fas fa-tag',
                'url'  => 'virtualizations/tagMV',
            ],[
                'id_menu_father' => 23,
                'order' => 16,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => $permissions->where('name','virtualization-admin')->first()->id,
                'text' => 'Update VMWare Tools',
                'icon' => 'fas fa-spinner',
                'url'  => 'virtualizations/updateVMWT',
            ],[
                'id_menu_father' => 23,
                'order' => 17,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => $permissions->where('name','virtualization-admin')->first()->id,
                'text' => 'Aumento de recursos',
                'icon' => 'fas fa-chalkboard-teacher',
                'url'  => 'virtualizations/resourcesUpgrade',
            ],[
                'id_menu_father' => 23,
                'order' => 18,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => $permissions->where('name','virtualization-admin')->first()->id,
                'text' => 'Cambio de Vlan',
                'icon' => 'fas fa-chalkboard-teacher',
                'url'  => 'virtualizations/vlanUpdate',
            ],[
                'id_menu_father' => 23,
                'order' => 19,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => $permissions->where('name','virtualization-admin')->first()->id,
                'text' => 'Aumento de Disco Duro',
                'icon' => 'fas fa-chalkboard-teacher',
                'url'  => 'virtualizations/resourcesDisk',
            ],
        ];


        $menusWindows1 = [
            [
                'id_menu_father' => 22,
                'order' => 1,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsEN-menu')->first())?$permissions->where('name','windowsEN-menu')->first()->id : 0,
                    'text' => 'WINDOWS E&N',
                    'icon' => 'fas fa-arrow-right',
                    'url'  => '/',
            ],
                    [
                'id_menu_father' => 103,
                'order' => 1,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsEN-user')->first())?$permissions->where('name','windowsEN-user')->first()->id : 0,
                        'text' => 'Check AD',
                        'icon' => 'fas fa-check-double',
                        'url'  => 'windows/checkAD',
                    ],[
                'id_menu_father' => 103,
                'order' => 2,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsEN-user')->first())?$permissions->where('name','windowsEN-user')->first()->id : 0,
                        'text' => 'Check Paso a Operación',
                        'icon' => 'fas fa-check-double',
                        'url'  => 'windows/checkPaso',
                    ],[
                'id_menu_father' => 103,
                'order' => 3,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsEN-user')->first())?$permissions->where('name','windowsEN-user')->first()->id : 0,
                        'text' => 'Check procesos CPU',
                        'icon' => 'fas fa-check-double',
                        'url'  => 'windows/checkCPUProcess',
                    ],[
                'id_menu_father' => 103,
                'order' => 4,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsEN-mixed')->first())?$permissions->where('name','windowsEN-mixed')->first()->id : 0,
                        'text' => 'Check S.O',
                        'icon' => 'fas fa-shoe-prints',
                        'url'  => '/',
                    ],          [
                'id_menu_father' => 107,
                'order' => 1,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsEN-mixed')->first())?$permissions->where('name','windowsEN-mixed')->first()->id : 0,
                            'text' => 'Pre-Ventana',
                            'icon' => 'fas fa-step-backward',
                            'url'  => 'windows/preVentana',
                        ],[
                'id_menu_father' => 107,
                'order' => 2,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsEN-mixed')->first())?$permissions->where('name','windowsEN-mixed')->first()->id : 0,
                            'text' => 'Post-Ventana',
                            'icon' => 'fas fa-step-forward',
                            'url'  => 'windows/postVentana',
                        ],
               [
                'id_menu_father' => 103,
                'order' => 5,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsEN-mixed')->first())?$permissions->where('name','windowsEN-mixed')->first()->id : 0,
                        'text' => 'Check Sistema Operativo',
                        'icon' => 'fas fa-check-double',
                        'url'  => 'windows/checkSO',
                    ],[
                'id_menu_father' => 103,
                'order' => 6,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsEN-mixed')->first())?$permissions->where('name','windowsEN-mixed')->first()->id : 0,
                        'text' => 'Gestión de servicios',
                        'icon' => 'fas fa-power-off',
                        'url'  => 'windows/serviceManagement',
                    ],[
                'id_menu_father' => 103,
                'order' => 7,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsEN-admin')->first())?$permissions->where('name','windowsEN-admin')->first()->id : 0,
                        'text' => 'Gestión WConsultas',
                        'icon' => 'fas fa-power-off',
                        'url'  => 'windows/manageWConsultas',
                    ],[
                'id_menu_father' => 103,
                'order' => 8,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsEN-admin')->first())?$permissions->where('name','windowsEN-admin')->first()->id : 0,
                        'text' => 'Gestión WCompensar',
                        'icon' => 'fas fa-power-off',
                        'url'  => 'windows/manageWCompensar',
                    ],[
                'id_menu_father' => 103,
                'order' => 9,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsEN-menu')->first())?$permissions->where('name','windowsEN-menu')->first()->id : 0,
                        'text' => 'Gestión de usuarios',
                        'icon' => 'fas fa-user',
                        'url'  => '/',
                    ],[
                'id_menu_father' => 114,
                'order' => 1,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsEN-mixed')->first())?$permissions->where('name','windowsEN-mixed')->first()->id : 0,
                            'text' => 'Crear usuarios',
                            'icon' => 'fas fa-user-plus',
                            'url'  => 'windows/create',
                        ],[
                'id_menu_father' => 114,
                'order' => 2,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsEN-mixed')->first())?$permissions->where('name','windowsEN-mixed')->first()->id : 0,
                            'text' => 'Cambiar password',
                            'icon' => 'fas fa-user-edit',
                            'url'  => 'windows/change',
                        ],[
                'id_menu_father' => 114,
                'order' => 3,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsEN-mixed')->first())?$permissions->where('name','windowsEN-mixed')->first()->id : 0,
                            'text' => 'Deshabilitar usuario',
                            'icon' => 'fas fa-user-slash',
                            'url'  => 'windows/disable',
                        ],[
                'id_menu_father' => 114,
                'order' => 4,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsEN-mixed')->first())?$permissions->where('name','windowsEN-mixed')->first()->id : 0,
                            'text' => 'Eliminar usuario',
                            'icon' => 'fas fa-user-times',
                            'url'  => 'windows/delete',
                        ],[
                'id_menu_father' => 114,
                'order' => 5,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsEN-mixed')->first())?$permissions->where('name','windowsEN-mixed')->first()->id : 0,
                            'text' => 'Modificar usuario',
                            'icon' => 'fas fa-user-edit',
                            'url'  => 'windows/edit',
                        ],
                    [
                'id_menu_father' => 103,
                'order' => 10,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsEN-mixed')->first())?$permissions->where('name','windowsEN-mixed')->first()->id : 0,
                        'text' => 'Depuración de memoria',
                        'icon' => 'fas fa-memory',
                        'url'  => 'windows/freeMemory',
                    ],[
                'id_menu_father' => 103,
                'order' => 11,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsEN-mixed')->first())?$permissions->where('name','windowsEN-mixed')->first()->id : 0,
                        'text' => 'Depuración de discos',
                        'icon' => 'fas fa-hdd',
                        'url'  => 'windows/debuggingDisks',
                    ],[
                'id_menu_father' => 103,
                'order' => 12,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsEN-mixed')->first())?$permissions->where('name','windowsEN-mixed')->first()->id : 0,
                        'text' => 'Extracción de Parches',
                        'icon' => 'fas fa-external-link-alt',
                        'url'  => 'windows/extParches',
                    ],[
                'id_menu_father' => 103,
                'order' => 13,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsEN-user')->first())?$permissions->where('name','windowsEN-user')->first()->id : 0,
                        'text' => 'Extracción de uptime',
                        'icon' => 'fas fa-external-link-alt',
                        'url'  => 'windows/extUptime',
                    ],[
                'id_menu_father' => 103,
                'order' => 14,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsEN-mixed')->first())?$permissions->where('name','windowsEN-mixed')->first()->id : 0,
                        'text' => 'Inventario Windows',
                        'icon' => 'fas fa-list',
                        'url'  => 'windows/inventario',
                    ],[
                'id_menu_father' => 103,
                'order' => 15,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsEN-mixed')->first())?$permissions->where('name','windowsEN-mixed')->first()->id : 0,
                        'text' => 'Rutas Estáticas',
                        'icon' => 'fas fa-route',
                        'url'  => 'windows/rutasEstaticas',
                    ],[
                'id_menu_father' => 103,
                'order' => 16,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsEN-mixed')->first())?$permissions->where('name','windowsEN-mixed')->first()->id : 0,
                        'text' => 'PLK - 7 Pasos - Windows',
                        'icon' => 'fas fa-shoe-prints',
                        'url'  => 'windows/sevenSteps',
                    ],[
                        'id_menu_father' => 103,
                        'order' => 17,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','windowsEN-user')->first())?$permissions->where('name','windowsEN-user')->first()->id : 0,
                        'text' => 'Update SO',
                        'icon' => 'fas fa-cog',
                        'url'  => 'windows/updateSO',
                    ],

        ];

        $menusWindows2 = [

            [
                'id_menu_father' => 22,
                'order' => 2,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsPH-menu')->first())?$permissions->where('name','windowsPH-menu')->first()->id : 0,
                'text' => 'WINDOWS P&H',
                'icon' => 'fas fa-arrow-right',
                'url'  => '/',
            ],
            [
                'id_menu_father' => 128,
                'order' => 1,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsPH-user')->first())?$permissions->where('name','windowsPH-user')->first()->id : 0,
                'text' => 'Actualización Atr. Users AD',
                'icon' => 'fas fa-user',
                'url'  => 'windowsPH/updateAtUserAD',
            ],[
                'id_menu_father' => 128,
                'order' => 2,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','winShareFolder-menu')->first())?$permissions->where('name','winShareFolder-menu')->first()->id : 0,
                'text' => 'Carpetas compartidas',
                'icon' => 'fas fa-folder-open',
                'url'  => 'windowsPH/winShareFolder',
            ],[
                'id_menu_father' => 128,
                'order' => 3,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsPH-user')->first())?$permissions->where('name','windowsPH-user')->first()->id : 0,
                'text' => 'Check estado S.O.',
                'icon' => 'fas fa-check-double',
                'url'  => 'windowsPH/checkSO',
            ],[
                'id_menu_father' => 128,
                'order' => 4,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsPH-user')->first())?$permissions->where('name','windowsPH-user')->first()->id : 0,
                'text' => 'Check estado S.O. Rep',
                'icon' => 'fas fa-search',
                'url'  => 'windowsPH/getCheckSO',
            ],[
                'id_menu_father' => 128,
                'order' => 5,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsPH-user')->first())?$permissions->where('name','windowsPH-user')->first()->id : 0,
                'text' => 'Consulta updates (KB)',
                'icon' => 'fas fa-download',
                'url'  => 'windowsPH/queryKb',
            ],[
                'id_menu_father' => 128,
                'order' => 6,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsPH-user')->first())?$permissions->where('name','windowsPH-user')->first()->id : 0,
                'text' => 'Permisos carpeta compartida',
                'icon' => 'fas fa-folder',
                'url'  => 'windowsPH/sharedFolderPer',
            ],[
                'id_menu_father' => 128,
                'order' => 7,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsPH-mixed')->first())?$permissions->where('name','windowsPH-mixed')->first()->id : 0,
                'text' => 'Reinicio IIS Com',
                'icon' => 'fas fa-power-off',
                'url'  => 'windowsPH/restartIISCom',
            ],[
                'id_menu_father' => 128,
                'order' => 8,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsPH-mixed')->first())?$permissions->where('name','windowsPH-mixed')->first()->id : 0,
                'text' => 'Reinicio Pool Com',
                'icon' => 'fas fa-power-off',
                'url'  => 'windowsPH/restartPoolCom',
            ],[
                'id_menu_father' => 128,
                'order' => 9,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsPH-user')->first())?$permissions->where('name','windowsPH-user')->first()->id : 0,
                'text' => 'Reinicio Servicios Com',
                'icon' => 'fas fa-power-off',
                'url'  => 'windowsPH/restartServicesCom',
            ],[
                'id_menu_father' => 128,
                'order' => 10,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsPH-user')->first())?$permissions->where('name','windowsPH-user')->first()->id : 0,
                'text' => 'Rep. Sitios Web y AppPools',
                'icon' => 'fas fa-file-contract',
                'url'  => 'windowsPH/reportSWP',
            ],[
                'id_menu_father' => 128,
                'order' => 11,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsPH-user')->first())?$permissions->where('name','windowsPH-user')->first()->id : 0,
                'text' => 'Rep. usuarios locales',
                'icon' => 'fas fa-file-contract',
                'url'  => 'windowsPH/localUsersReport',
            ]
        ];

        $menusTelefonia = [
            [
                'id_menu_father' => 20,
                'order' => 1,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','telephony-user')->first())?$permissions->where('name','telephony-user')->first()->id : 0,
                'text' => 'Reporte usuarios Avaya',
                'icon' => 'fas fa-user',
                'url'  => 'telephony/logUserAvaya',
            ]
        ];

        $menusSeguridadDC = [
            [
                'id_menu_father' => 19,
                'order' => 1,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','ManagedSecurity-user')->first())?$permissions->where('name','ManagedSecurity-user')->first()->id : 0,
                'text' => 'Instalación AV DS Unix',
                'icon' => 'fas fa-download',
                'url'  => 'managedSecurity/instAVDSUnix',
            ],[
                'id_menu_father' => 19,
                'order' => 2,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','ManagedSecurity-user')->first())?$permissions->where('name','ManagedSecurity-user')->first()->id : 0,
                'text' => 'Instalación AV DS Win',
                'icon' => 'fas fa-download',
                'url'  => 'managedSecurity/instAVDSWin',
            ],[
                'id_menu_father' => 19,
                'order' => 3,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','ManagedSecurity-user')->first())?$permissions->where('name','ManagedSecurity-user')->first()->id : 0,
                'text' => 'BlackList Firewall SIN_VDOM',
                'icon' => 'fas fa-fire',
                'url'  => 'managedSecurity/blacklistNotVdom',
            ],[
                'id_menu_father' => 19,
                'order' => 4,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','ManagedSecurity-user')->first())?$permissions->where('name','ManagedSecurity-user')->first()->id : 0,
                'text' => 'BlackList Firewall CON_VDOM',
                'icon' => 'fas fa-fire',
                'url'  => 'managedSecurity/blacklistVdom',
            ]
        ];

        $menusRedesPymes = [
            [
                'id_menu_father' => 17,
                'order' => 1,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','networking-pymes-run')->first())?$permissions->where('name','networking-pymes-run')->first()->id : 0,
                'text' => 'Reinicio FW Gaoke',
                'icon' => 'fas fa-power-off',
                'url'  => 'networkingPymes/restartGaoke',
            ],[
                'id_menu_father' => 17,
                'order' => 2,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','networking-pymes-run')->first())?$permissions->where('name','networking-pymes-run')->first()->id : 0,
                'text' => 'Actualizacion FW Gaoke',
                'icon' => 'fas fa-wrench',
                'url'  => 'networkingPymes/updateGaoke',
            ]
        ];

        $menusRedes = [
            [
                'id_menu_father' => 16,
                'order' => 1,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','networking-user')->first())?$permissions->where('name','networking-user')->first()->id : 0,
                'text' => 'Check Inventario',
                'icon' => 'fas fa-check-double',
                'url'  => 'networking/checkInventario',
            ],[
                'id_menu_father' => 16,
                'order' => 2,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','networking-user')->first())?$permissions->where('name','networking-user')->first()->id : 0,
                'text' => 'MAC_Search Plaza Claro',
                'icon' => 'fas fa-search',
                'url'  => 'networking/macSearchPC',
            ],[
                'id_menu_father' => 16,
                'order' => 3,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','networking-user')->first())?$permissions->where('name','networking-user')->first()->id : 0,
                'text' => 'Revisión Uptime',
                'icon' => 'fas fa-stopwatch',
                'url'  => 'networking/valUptime',
            ],[
                'id_menu_father' => 16,
                'order' => 4,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','networking-user')->first())?$permissions->where('name','networking-user')->first()->id : 0,
                'text' => 'T-Shoot CAVs',
                'icon' => 'fas fa-list',
                'url'  => 'networking/tShootCAV',
            ]
        ];

        $menusOperadores = [
            [
                'id_menu_father' => 15,
                'order' => 1,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','operator-menu')->first())?$permissions->where('name','operator-menu')->first()->id : 0,
                'text' => 'UNIX',
                'icon' => 'fas fa-arrow-circle-right',
                'url'  => '/',
            ],
            [
                'id_menu_father' => 151,
                'order' => 1,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','operator-mixed')->first())?$permissions->where('name','operator-mixed')->first()->id : 0,
                'text' => 'Informe operadores',
                'icon' => 'fas fa-file-contract',
                'url'  => 'operators/opeReport',
            ]
        ];

        $menusOpeLas = [
            [
                'id_menu_father' => 14,
            'order' => 1,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','implementation-menu')->first())?$permissions->where('name','implementation-menu')->first()->id : 0,
            'text' => 'Windows',
            'icon' => 'fas fa-arrow-right',
            'url'  => '/',
            ],
            [
                    'id_menu_father' => 153,
            'order' => 1,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','implementation-user')->first())?$permissions->where('name','implementation-user')->first()->id : 0,
                'text' => 'Check paso a operación V2',
                'icon' => 'fas fa-check-double',
                'url'  => 'implementations/checkPasoWin',
            ],[
                    'id_menu_father' => 153,
            'order' => 2,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','implementation-user')->first())?$permissions->where('name','implementation-user')->first()->id : 0,
                'text' => 'Hardening',
                'icon' => 'fas fa-tasks',
                'url'  => 'implementations/hardeningW',
            ],[
                    'id_menu_father' => 153,
            'order' => 3,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','implementation-user')->first())?$permissions->where('name','implementation-user')->first()->id : 0,
                'text' => 'Instalación Cisco Tetration',
                'icon' => 'fas fa-download',
                'url'  => 'implementations/tetrationW',
            ],[
                    'id_menu_father' => 153,
            'order' => 4,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','implementation-user')->first())?$permissions->where('name','implementation-user')->first()->id : 0,
                'text' => 'Licenciamiento',
                'icon' => 'fas fa-id-badge',
                'url'  => 'implementations/licenciamientoW',
            ],[
                    'id_menu_father' => 153,
            'order' => 5,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','implementation-user')->first())?$permissions->where('name','implementation-user')->first()->id : 0,
                'text' => 'Normalización',
                'icon' => 'fas fa-check-square',
                'url'  => 'implementations/normalizacionW',
            ],
            [
                'id_menu_father' => 14,
            'order' => 2,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','implementation-menu')->first())?$permissions->where('name','implementation-menu')->first()->id : 0,
            'text' => 'Linux',
            'icon' => 'fas fa-arrow-right',
            'url'  => '/',
            ],
            [
                    'id_menu_father' => 159,
            'order' => 1,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','implementation-user')->first())?$permissions->where('name','implementation-user')->first()->id : 0,
                'text' => 'Check paso a operación',
                'icon' => 'fas fa-check-double',
                'url'  => 'implementations/checkPasoUnix',
            ],
            [
                'id_menu_father' => 14,
            'order' => 3,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','implementation-menu')->first())?$permissions->where('name','implementation-menu')->first()->id : 0,
            'text' => 'Virtualización',
            'icon' => 'fas fa-arrow-right',
            'url'  => '/',
            ],    [
                    'id_menu_father' => 161,
            'order' => 1,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','implementation-user')->first())?$permissions->where('name','implementation-user')->first()->id : 0,
                'text' => 'Reporte Cluster Capacity ',
                'icon' => 'fas fa-file-invoice',
                'url'  => 'virtualizations/clusterCapacityReport',
            ],[
                    'id_menu_father' => 161,
            'order' => 2,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','implementation-user')->first())?$permissions->where('name','implementation-user')->first()->id : 0,
                'text' => 'Aumento de recursos',
                'icon' => 'fas fa-chalkboard-teacher',
                'url'  => 'virtualizations/resourcesUpgrade',
            ],
        ];

        $menusCloud = [
            [
                'id_menu_father' => 12,
                'order' => 1,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','cloud-user')->first())?$permissions->where('name','cloud-user')->first()->id : 0,
                'text' => 'API Agregar cuentas',
                'icon' => 'fas fa-user-plus',
                'url'  => 'cloud/accountAdd',
            ]
        ];

        $meunsCheckPaso = [
            [
                'id_menu_father' => 11,
                'order' => 1,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','executionLog-menu')->first())?$permissions->where('name','executionLog-menu')->first()->id : 0,
                'text' => 'VIRTUALIZACIÓN',
                'icon' => 'fas fa-arrow-circle-right',

                'url'  => '/',
            ],
            [
                'id_menu_father' => 165,
                'order' => 1,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','pasosOP-admin')->first())?$permissions->where('name','pasosOP-admin')->first()->id : 0,
                'text' => 'Paso a operación VM',
                'icon' => 'fas fa-thumbs-up',

                'url'  => 'virtualizations/operationStep',
            ],[
                'id_menu_father' => 165,
                'order' => 2,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','pasosOP-admin')->first())?$permissions->where('name','pasosOP-admin')->first()->id : 0,
                'text' => 'Paso a operación Host',
                'icon' => 'fas fa-thumbs-up',

                'url'  => 'virtualizations/checkHost',
            ]
        ];

        $menuBalance = [
            [
                'id_menu_father' => 10,
                'order' => 1,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','balancer-user')->first())?$permissions->where('name','balancer-user')->first()->id : 0,
                'text' => 'Adición de servidor NS',
                'icon' => 'fas fa-spinner',
                'url'  => 'balancers/addServerNS',
            ],[
                'id_menu_father' => 10,
                'order' => 2,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','balancer-user')->first())?$permissions->where('name','balancer-user')->first()->id : 0,
                'text' => 'Adición Member_Service NS',
                'icon' => 'fas fa-spinner',
                'url'  => 'balancers/addServiceMemberNS',
            ],[
                'id_menu_father' => 10,
                'order' => 3,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','balancer-user')->first())?$permissions->where('name','balancer-user')->first()->id : 0,
                'text' => 'Reporte Member_Service LB-VS NS',
                'icon' => 'fas fa-spinner',
                'url'  => 'balancers/reportMemberLB',
            ],[
                'id_menu_father' => 10,
                'order' => 4,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','balancer-user')->first())?$permissions->where('name','balancer-user')->first()->id : 0,
                'text' => 'Reporte Inventario LB-VS',
                'icon' => 'fas fa-spinner',
                'url'  => 'balancers/reportInventoryLB',
            ],[
                'id_menu_father' => 10,
                'order' => 5,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','balancer-user')->first())?$permissions->where('name','balancer-user')->first()->id : 0,
                'text' => 'Creación VS F5',
                'icon' => 'fas fa-spinner',
                'url'  => 'balancers/addVSF5',
            ],[
                'id_menu_father' => 10,
                'order' => 6,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','balancer-user')->first())?$permissions->where('name','balancer-user')->first()->id : 0,
                'text' => 'Creación VS NS',
                'icon' => 'fas fa-spinner',
                'url'  => 'balancers/addVSNS',
            ],[
                'id_menu_father' => 10,
                'order' => 7,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','balancer-user')->first())?$permissions->where('name','balancer-user')->first()->id : 0,
                'text' => 'Creación Vlan y Selfip F5',
                'icon' => 'fas fa-spinner',
                'url'  => 'balancers/addVlanSelfipF5',
            ],[
                'id_menu_father' => 10,
                'order' => 8,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','balancer-user')->first())?$permissions->where('name','balancer-user')->first()->id : 0,
                'text' => 'Gestión zonas GTM F5',
                'icon' => 'fas fa-spinner',
                'url'  => 'balancers/nodosGTMF5',
            ],[
                'id_menu_father' => 10,
                'order' => 9,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','balancer-mixed')->first())?$permissions->where('name','balancer-mixed')->first()->id : 0,
                'text' => 'Grupo de Servicio NS',
                'icon' => 'fas fa-spinner',
                'url'  => 'balancers/grupoServicioNS',
            ],[
                'id_menu_father' => 10,
                'order' => 10,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','balancer-user')->first())?$permissions->where('name','balancer-user')->first()->id : 0,
                'text' => 'Health Check NS',
                'icon' => 'fas fa-spinner',
                'url'  => 'balancers/healthCheckNS',
            ],[
                'id_menu_father' => 10,
                'order' => 11,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','balancer-user')->first())?$permissions->where('name','balancer-user')->first()->id : 0,
                'text' => 'Health Check F5',
                'icon' => 'fas fa-spinner',
                'url'  => 'balancers/healthCheckF5',
            ],[
                'id_menu_father' => 10,
                'order' => 12,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','balancer-user')->first())?$permissions->where('name','balancer-user')->first()->id : 0,
                'text' => 'Nodo F5',
                'icon' => 'fas fa-spinner',
                'url'  => 'balancers/nodoF5',
            ],[
                'id_menu_father' => 10,
                'order' => 13,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','balancer-mixed')->first())?$permissions->where('name','balancer-mixed')->first()->id : 0,
                'text' => 'Nodo NS',
                'icon' => 'fas fa-spinner',
                'url'  => 'balancers/nodoNS',
            ],[
                'id_menu_father' => 10,
                'order' => 14,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','balancer-user')->first())?$permissions->where('name','balancer-user')->first()->id : 0,
                'text' => 'Perfil SSL F5',
                'icon' => 'fas fa-spinner',
                'url'  => 'balancers/perfilSSLF5',
            ],[
                'id_menu_father' => 10,
                'order' => 15,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','balancer-user')->first())?$permissions->where('name','balancer-user')->first()->id : 0,
                'text' => 'Puertos F5',
                'icon' => 'fas fa-spinner',
                'url'  => 'balancers/adminPuertosF5',
            ],[
                'id_menu_father' => 10,
                'order' => 16,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','balancer-user')->first())?$permissions->where('name','balancer-user')->first()->id : 0,
                'text' => 'Request F5',
                'icon' => 'fas fa-spinner',
                'url'  => 'balancers/requestF5',
            ],[
                'id_menu_father' => 10,
                'order' => 17,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','balancer-user')->first())?$permissions->where('name','balancer-user')->first()->id : 0,
                'text' => 'Request_CSR NS',
                'icon' => 'fas fa-spinner',
                'url'  => 'balancers/requestNS',
            ],[
                'id_menu_father' => 10,
                'order' => 18,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','balancer-user')->first())?$permissions->where('name','balancer-user')->first()->id : 0,
                'text' => 'Servicio NS',
                'icon' => 'fas fa-spinner',
                'url'  => 'balancers/servicioNS',
            ],[
                'id_menu_father' => 10,
                'order' => 19,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','balancer-user')->first())?$permissions->where('name','balancer-user')->first()->id : 0,
                'text' => 'Upload_CER NS',
                'icon' => 'fas fa-spinner',
                'url'  => 'balancers/sslCertNS',
            ],[
                'id_menu_father' => 10,
                'order' => 20,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','balancer-user')->first())?$permissions->where('name','balancer-user')->first()->id : 0,
                'text' => 'Información VisorMobile',
                'icon' => 'fas fa-spinner',
                'url'  => 'balancers/visorMobile',
            ],[
                'id_menu_father' => 10,
                'order' => 21,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','balancer-user')->first())?$permissions->where('name','balancer-user')->first()->id : 0,
                'text' => 'Reporte Visor Único NS',
                'icon' => 'fas fa-spinner',
                'url'  => 'balancers/visorUnique',
            ],[
                'id_menu_father' => 10,
                'order' => 22,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','balancer-user')->first())?$permissions->where('name','balancer-user')->first()->id : 0,
                'text' => 'Creación SNIP NS',
                'icon' => 'fas fa-spinner',
                'url'  => 'balancers/addSnipNS',
            ],[
                'id_menu_father' => 10,
                'order' => 23,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','balancer-user')->first())?$permissions->where('name','balancer-user')->first()->id : 0,
                'text' => 'Creación VLAN NS',
                'icon' => 'fas fa-spinner',
                'url'  => 'balancers/addVlanCitrix',
            ],[
                'id_menu_father' => 10,
                'order' => 24,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','balancer-user')->first())?$permissions->where('name','balancer-user')->first()->id : 0,
                'text' => 'Servicio Tennis_NOW_8083 NS',
                'icon' => 'fas fa-spinner',
                'url'  => 'balancers/stateTennis',
            ],[
                'id_menu_father' => 10,
                'order' => 25,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','balancer-user')->first())?$permissions->where('name','balancer-user')->first()->id : 0,
                'text' => 'Servidor FIDUOCCIDENTE NS',
                'icon' => 'fas fa-spinner',
                'url'  => 'balancers/servfiduoccidenteNs',
            ]
        ];

        $menuBackup = [
            [
                'id_menu_father' => 9,
                'order' => 1,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','backup-mixed')->first())?$permissions->where('name','backup-mixed')->first()->id : 0,
                'text' => 'Check 1N Win',
                'icon' => 'fas fa-check-double',
                'url'  => 'backup/checkPWindows',
            ],[
                'id_menu_father' => 9,
                'order' => 2,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','backup-user')->first())?$permissions->where('name','backup-user')->first()->id : 0,
                'text' => 'Maestro de fallas',
                'icon' => 'fas fa-check-double',
                'url'  => 'backup/failedMaster',
            ],[
                'id_menu_father' => 9,
                'order' => 3,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','backup-mixed')->first())?$permissions->where('name','backup-mixed')->first()->id : 0,
                'text' => 'Ping desde CS02-CAP-TRIARA',
                'icon' => 'fas fa-project-diagram',
                'url'  => 'backup/pingCS02',
            ],[
                'id_menu_father' => 9,
                'order' => 4,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','backup-user')->first())?$permissions->where('name','backup-user')->first()->id : 0,
                'text' => 'Revisión ventana',
                'icon' => 'fas fa-check-double',
                'url'  => 'backup/backupTask',
            ],[
                'id_menu_father' => 9,
                'order' => 5,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','backup-user')->first())?$permissions->where('name','backup-user')->first()->id : 0,
                'text' => 'Schedule de la Movil',
                'icon' => 'fas fa-check-double',
                'url'  => 'backup/scheduleMovil',
            ],[
                'id_menu_father' => 9,
                'order' => 6,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','backup-user')->first())?$permissions->where('name','backup-user')->first()->id : 0,
                'text' => 'Transporte VADP',
                'icon' => 'fas fa-check-double',
                'url'  => 'backup/vadp',
            ],[
                'id_menu_father' => 9,
                'order' => 7,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','backup-user')->first())?$permissions->where('name','backup-user')->first()->id : 0,
                'text' => 'Jobs Commvault',
                'icon' => 'fas fa-cog',
                'url'  => 'backup/jobs',
            ]
        ];

        $menuPoliedro = [
            [
                'id_menu_father' => 6,
                'order' => 1,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','balancer-mixed')->first())?$permissions->where('name','balancer-mixed')->first()->id : 0,
                'text' => 'Grupo de Servicio NS',
                'icon' => 'fas fa-spinner',
                'url'  => 'balancers/grupoServicioNS',
            ],[
                'id_menu_father' => 6,
                'order' => 2,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','balancer-mixed')->first())?$permissions->where('name','balancer-mixed')->first()->id : 0,
                'text' => 'Nodo NS',
                'icon' => 'fas fa-spinner',
                'url'  => 'balancers/nodoNS',
            ],[
                'id_menu_father' => 6,
                'order' => 3,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsPH-mixed')->first())?$permissions->where('name','windowsPH-mixed')->first()->id : 0,
                'text' => 'Reinicio IIS Com',
                'icon' => 'fas fa-power-off',
                'url'  => 'windowsPH/restartIISCom',
            ],[
                'id_menu_father' => 6,
                'order' => 4,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','windowsPH-mixed')->first())?$permissions->where('name','windowsPH-mixed')->first()->id : 0,
                'text' => 'Reinicio Pool Com',
                'icon' => 'fas fa-power-off',
                'url'  => 'windowsPH/restartPoolCom',
            ]
        ];

        $menuArreglo = [
            [
                'id_menu_father' => 0,
                'order' => 4,
                'is_title' => 0,
                'level' => 1,
                'id_permission' => ($permissions->where('name','supportPH-menu')->first())?$permissions->where('name','supportPH-menu')->first()->id : 0,
                'text' => 'SOPORTE P&H',
                'icon' => 'far fa-circle',
                'url' => '/'
            ]
        ];

        $menusAMTENMenus = [
            [
                'id_menu_father' => 8,
                'order' => 1,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','amt-menu')->first())?$permissions->where('name','amt-menu')->first()->id : 0,
                'text' => 'AMT E&N',
                'icon' => 'far fa-circle',
                'url'  => '/'
            ],
            [
                'id_menu_father' => 205,
                'order' => 1,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','amt-mixed')->first())?$permissions->where('name','amt-mixed')->first()->id : 0,
                'text' => 'App Tomcat Unix',
                'icon' => 'fas fa-spinner',
                'url'  => 'amt/appTomcatUnix',
            ],[
                'id_menu_father' => 205,
                'order' => 2,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','amt-mixed')->first())?$permissions->where('name','amt-mixed')->first()->id : 0,
                'text' => 'App Tomcat Unix PCCAAS',
                'icon' => 'fas fa-spinner',
                'url'  => 'amt/appTomcatUnixPCCAAS',
            ],[
                'id_menu_father' => 205,
                'order' => 3,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','amt-user')->first())?$permissions->where('name','amt-user')->first()->id : 0,
                'text' => 'App Tomcat Windows',
                'icon' => 'fas fa-spinner',
                'url'  => 'amt/appTomcatWindows',
            ],[
                'id_menu_father' => 205,
                'order' => 4,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','amt-mixed')->first())?$permissions->where('name','amt-mixed')->first()->id : 0,
                'text' => 'Backup Formas',
                'icon' => 'fas fa-spinner',
                'url'  => 'amt/backupFormas',
            ],[
                'id_menu_father' => 205,
                'order' => 5,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','amt-mixed')->first())?$permissions->where('name','amt-mixed')->first()->id : 0,
                'text' => 'Check P.O. Tomcat',
                'icon' => 'fas fa-spinner',
                'url'  => 'amt/checkPasoTomcat',
            ],[
                'id_menu_father' => 205,
                'order' => 6,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','amt-mixed')->first())?$permissions->where('name','amt-mixed')->first()->id : 0,
                'text' => 'Check P.O. WebLogic',
                'icon' => 'fas fa-spinner',
                'url'  => 'amt/checkPOWebLogic',
            ],[
                'id_menu_father' => 205,
                'order' => 7,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','amt-user')->first())?$permissions->where('name','amt-user')->first()->id : 0,
                'text' => 'Connect DB',
                'icon' => 'fas fa-spinner',
                'url'  => 'amt/connectDB',
            ],[
                'id_menu_father' => 205,
                'order' => 8,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','amt-user')->first())?$permissions->where('name','amt-user')->first()->id : 0,
                'text' => 'Health Check AMT',
                'icon' => 'fas fa-spinner',
                'url'  => 'amt/healthCheck',
            ],[
                'id_menu_father' => 205,
                'order' => 9,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','amt-mixed')->first())?$permissions->where('name','amt-mixed')->first()->id : 0,
                'text' => 'Movimiento Formas',
                'icon' => 'fas fa-spinner',
                'url'  => 'amt/movimientoFormas',
            ],[
                'id_menu_father' => 205,
                'order' => 10,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','amt-user')->first())?$permissions->where('name','amt-user')->first()->id : 0,
                'text' => 'Parche Weblogic',
                'icon' => 'fas fa-spinner',
                'url'  => 'amt/parcheWeblogic',
            ],[
                'id_menu_father' => 205,
                'order' => 11,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','amt-user')->first())?$permissions->where('name','amt-user')->first()->id : 0,
                'text' => 'Reinicio FUSE',
                'icon' => 'fas fa-spinner',
                'url'  => 'amt/fuse',
            ],[
                'id_menu_father' => 205,
                'order' => 12,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','amt-user')->first())?$permissions->where('name','amt-user')->first()->id : 0,
                'text' => 'Reinicio SOA',
                'icon' => 'fas fa-spinner',
                'url'  => 'amt/soa',
            ],[
                'id_menu_father' => 205,
                'order' => 13,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','amt-user')->first())?$permissions->where('name','amt-user')->first()->id : 0,
                'text' => 'Reporte Weblogic',
                'icon' => 'fas fa-file-word',
                'url'  => 'amt/webReports',
            ]

        ];

        $menusAMTPNMenus1 = [

            [
                'id_menu_father' => 8,
                'order' => 2,
                'is_title' => 0,
                'level' => 2,
                'url'  => '/',
                'id_permission' => ($permissions->where('name','amtPH-menu')->first())?$permissions->where('name','amtPH-menu')->first()->id : 0,
                'text' => 'AMT P&H',
                'icon' => 'far fa-circle',
            ],
                    [
                        'id_menu_father' => 219,
                        'order' => 1,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                        'text' => 'Alarma_stuck FulESB',
                        'icon' => 'fas fa-bell',
                        'url'  => 'amtPH/ESBAlarm',
                    ],
                    [
                         'id_menu_father' => 219,
                        'order' => 2,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                        'text' => 'Bajada de dominio',
                        'icon' => 'fas fa-arrow-alt-circle-down',
                        'url'  => 'amtPH/bajadaDominio',
                    ],[
                        'id_menu_father' => 219,
                        'order' => 3,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','amtPHIT-admin')->first())?$permissions->where('name','amtPHIT-admin')->first()->id : 0,
                        'text' => 'Depurar F5 Logs Glasfish',
                        'icon' => 'fas fa-spinner',
                        'url'  => 'amtPHIT/depFileSystem',
                    ],[
                        'id_menu_father' => 219,
                        'order' => 4,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','amtPHIT-admin')->first())?$permissions->where('name','amtPHIT-admin')->first()->id : 0,
                        'text' => 'Depurar F5 WebService',
                        'icon' => 'fas fa-spinner',
                        'url'  => 'amtPHIT/depFileWebService',
                    ],[
                        'id_menu_father' => 219,
                        'order' => 5,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','amtPHIT-admin')->first())?$permissions->where('name','amtPHIT-admin')->first()->id : 0,
                        'text' => 'Depurar Logs Glasfish Unix',
                        'icon' => 'fas fa-spinner',
                        'url'  => 'amtPHIT/depLogsGlasfish',
                    ],[
                         'id_menu_father' => 219,
                        'order' => 6,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','amtPHIT-admin')->first())?$permissions->where('name','amtPHIT-admin')->first()->id : 0,
                        'text' => 'Despliegue Agendamiento',
                        'icon' => 'fas fa-spinner',
                        'url'  => 'amtPHIT/papAgendamiento',
                    ],[
                         'id_menu_father' => 219,
                        'order' => 7,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','amtPHIT-admin')->first())?$permissions->where('name','amtPHIT-admin')->first()->id : 0,
                        'text' => 'Despliegue 89 MC',
                        'icon' => 'fas fa-spinner',
                        'url'  => 'amtPHIT/despliegueMC',
                    ],[
                         'id_menu_father' => 219,
                        'order' => 8,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','amtPHIT-admin')->first())?$permissions->where('name','amtPHIT-admin')->first()->id : 0,
                        'text' => 'Desp. Call Center Cluster',
                        'icon' => 'fas fa-spinner',
                        'url'  => 'amtPHIT/despCallCenter',
                    ],[
                         'id_menu_father' => 219,
                        'order' => 9,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                        'text' => 'Revisión memoria y cpu',
                        'icon' => 'fas fa-microchip',
                        'url'  => 'amtPHIT/diagnosticMC',
                    ],[
                         'id_menu_father' => 219,
                        'order' => 10,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','amtPHIT-admin')->first())?$permissions->where('name','amtPHIT-admin')->first()->id : 0,
                        'text' => 'Despliegue Venta Cluster',
                        'icon' => 'fas fa-spinner',
                        'url'  => 'amtPHIT/despliegueVentas',
                    ],[
                         'id_menu_father' => 219,
                        'order' => 11,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','amtPHIT-admin')->first())?$permissions->where('name','amtPHIT-admin')->first()->id : 0,
                        'text' => 'Despliegue PCML Cluster',
                        'icon' => 'fas fa-spinner',
                        'url'  => 'amtPHIT/desplieguePCML',
                    ],[
                         'id_menu_father' => 219,
                        'order' => 12,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','amtPHIT-admin')->first())?$permissions->where('name','amtPHIT-admin')->first()->id : 0,
                        'text' => 'DesplieguePostVentaCluster',
                        'icon' => 'fas fa-spinner',
                        'url'  => 'amtPHIT/desplieguePostVenta',
                    ],[
                         'id_menu_father' => 219,
                        'order' => 13,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','amtPHIT-admin')->first())?$permissions->where('name','amtPHIT-admin')->first()->id : 0,
                        'text' => 'Desp. Venta Técnica Cluster',
                        'icon' => 'fas fa-spinner',
                        'url'  => 'amtPHIT/ventaTecnica',
                    ],[
                         'id_menu_father' => 219,
                        'order' => 14,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','amtPHIT-admin')->first())?$permissions->where('name','amtPHIT-admin')->first()->id : 0,
                        'text' => 'Desp. WoService Cluster',
                        'icon' => 'fas fa-spinner',
                        'url'  => 'amtPHIT/woService',
                    ],[
                         'id_menu_father' => 219,
                        'order' => 15,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                        'text' => 'Estadística de los datasource',
                        'icon' => 'fas fa-chart-bar',
                        'url'  => 'amtPH/estDataSource',
                    ],[
                         'id_menu_father' => 219,
                        'order' => 16,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                        'text' => 'Estado Itel Venecia',
                        'icon' => 'fas fa-spinner',
                        'url'  => 'amtPH/ITELState',
                    ],
                    // 236
                    [
                        'id_menu_father' => 219,
                        'order' => 17,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                        'text' => 'Itel',
                        'icon' => 'fas fa-server',
                        'url'  => '/',
                    ],[
                            'id_menu_father' => 236,
                            'order' => 1,
                            'is_title' => 0,
                            'level' => 2,
                            'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                            'text' => 'Venecia',
                            'icon' => 'fas fa-industry',
                            'url'  => '/',
                    ],[
                                'id_menu_father' => 237,
                                'order' => 1,
                                'is_title' => 0,
                                'level' => 2,
                                'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                                'text' => 'OSB',
                                'icon' => 'fas fa-list',
                                'url'  => '/',
                    ],[
                                        'id_menu_father' => 238,
                                        'order' => 1,
                                        'is_title' => 0,
                                        'level' => 2,
                                        'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                                        'text' => 'Bajada',
                                        'icon' => 'fas fa-arrow-circle-down',
                                        'url'  => 'amtPH/ITELVeneciaDown',
                                    ],[
                                        'id_menu_father' => 238,
                                        'order' => 2,
                                        'is_title' => 0,
                                        'level' => 2,
                                        'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                                        'text' => 'Subida',
                                        'icon' => 'fas fa-arrow-circle-up',
                                        'url'  => 'amtPH/ITELVeneciaUp',
                                ],
                            // 241
                            [
                            'id_menu_father' => 237,
                            'order' => 2,
                            'is_title' => 0,
                            'level' => 2,
                            'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                            'text' => 'SOA',
                            'icon' => 'fas fa-list',
                            'url'  => '/',
                            ],
                            [
                                'id_menu_father' => 241,
                                'order' => 1,
                                'is_title' => 0,
                                'level' => 2,
                                'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                                'text' => 'Bajada',
                                'icon' => 'fas fa-arrow-circle-down',
                                'url'  => 'amtPH/ITELVeneciaSoaDown',
                                ],[
                                'id_menu_father' => 241,
                                'order' => 2,
                                'is_title' => 0,
                                'level' => 2,
                                'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                                        'text' => 'Subida',
                                        'icon' => 'fas fa-arrow-circle-up',
                                        'url'  => 'amtPH/ITELVeneciaSoaUp',
                                ],

                            [ // 243
                                'id_menu_father' => 237,
                                'order' => 3,
                                'is_title' => 0,
                                'level' => 2,
                                'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                                'text' => 'PCA',
                                'icon' => 'fas fa-list',
                                'url'  => '/',
                            ],[
                                    'id_menu_father' => 244,
                                    'order' => 1,
                                    'is_title' => 0,
                                    'level' => 2,
                                    'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                                    'text' => 'Bajada',
                                    'icon' => 'fas fa-arrow-circle-down',
                                    'url'  => '#',
                                ],

                            [// 245
                                'id_menu_father' => 237,
                                'order' => 4,
                                'is_title' => 0,
                                'level' => 2,
                                'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                                'text' => 'BRE',
                                'icon' => 'fas fa-list',
                                'url'  => '/',
                            ],[
                                    'id_menu_father' => 246,
                                    'order' => 1,
                                    'is_title' => 0,
                                    'level' => 2,
                                    'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                                    'text' => 'Bajada',
                                    'icon' => 'fas fa-arrow-circle-down',
                                    'url'  => '#',
                            ],
                            [//247
                            'id_menu_father' => 237,
                            'order' => 5,
                            'is_title' => 0,
                            'level' => 2,
                            'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                            'text' => 'FINEQ',
                            'icon' => 'fas fa-list',
                            'url'  => '/',
                        ],[
                                'id_menu_father' => 248,
                                'order' => 1,
                                'is_title' => 0,
                                'level' => 2,
                                'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                                'text' => 'Bajada',
                                'icon' => 'fas fa-arrow-circle-down',
                                'url'  => '#',

                            ],
                            [// 249
                                'id_menu_father' => 237,
                                'order' => 6,
                                'is_title' => 0,
                                'level' => 2,
                                'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                                'text' => 'APROV',
                                'icon' => 'fas fa-list',
                                'url'  => '/',
                            ],[
                                    'id_menu_father' => 250,
                                    'order' => 1,
                                    'is_title' => 0,
                                    'level' => 2,
                                    'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                                    'text' => 'Bajada',
                                    'icon' => 'fas fa-arrow-circle-down',
                                    'url'  => '#',

                            ],
                            [//251
                                'id_menu_father' => 237,
                                'order' => 7,
                                'is_title' => 0,
                                'level' => 2,
                                'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                                'text' => 'PROCESOS CLOUD',
                                'icon' => 'fas fa-list',
                                'url'  => '/',
                            ],[
                                    'id_menu_father' => 252,
                                    'order' => 1,
                                    'is_title' => 0,
                                    'level' => 2,
                                    'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                                    'text' => 'Bajada',
                                    'icon' => 'fas fa-arrow-circle-down',
                                    'url'  => 'amtPH/downCloudVenecia',
                                ],[
                                    'id_menu_father' => 252,
                                    'order' => 2,
                                    'is_title' => 0,
                                    'level' => 2,
                                    'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                                    'text' => 'Subida',
                                    'icon' => 'fas fa-arrow-circle-up',
                                    'url'  => 'amtPH/upCloudVenecia',
                                ],
        ];

        $menusAMTPNMenus2 = [

            [
                'id_menu_father' => 236,
                'order' => 1,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                'text' => 'Triara',
                'icon' => 'fas fa-industry',
                'url'  => '/',
            ],[
                    'id_menu_father' => 255,
                    'order' => 1,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                    'text' => 'OSB',
                    'icon' => 'fas fa-list',
                    'url'  => '/',
                ],[
                        'id_menu_father' => 256,
                        'order' => 1,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                        'text' => 'Bajada',
                        'icon' => 'fas fa-arrow-circle-down',
                        'url'  => 'amtPH/ITELTriaraDown',
                    ],[
                        'id_menu_father' => 256,
                        'order' => 2,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                        'text' => 'Subida',
                        'icon' => 'fas fa-arrow-circle-up',
                        'url'  => 'amtPH/ITELTriaraUp',

                ],
                [
                    'id_menu_father' => 255,
                    'order' => 2,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                    'text' => 'SOA',
                    'icon' => 'fas fa-list',
                    'url'  => '/',
                ],[
                        'id_menu_father' => 259,
                        'order' => 1,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                        'text' => 'Bajada',
                        'icon' => 'fas fa-arrow-circle-down',
                        'url'  => 'amtPH/downSoaTriara',
                    ],[
                        'id_menu_father' => 259,
                        'order' => 2,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                        'text' => 'Subida',
                        'icon' => 'fas fa-arrow-circle-up',
                        'url'  => 'amtPH/ITELTriaraSoaUp',

                ],
                [
                    'id_menu_father' => 255,
                    'order' => 3,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                    'text' => 'PCA',
                    'icon' => 'fas fa-list',
                    'url'  => '/',
                ],[
                        'id_menu_father' => 262,
                        'order' => 1,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                        'text' => 'Bajada',
                        'icon' => 'fas fa-arrow-circle-down',
                        'url'  => '#',

                ],
                [
                    'id_menu_father' => 255,
                    'order' => 4,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                    'text' => 'BRE',
                    'icon' => 'fas fa-list',
                    'url'  => '/',
                ],[
                            'id_menu_father' => 264,
                            'order' => 1,
                            'is_title' => 0,
                            'level' => 2,
                            'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                            'text' => 'Bajada',
                            'icon' => 'fas fa-arrow-circle-down',
                            'url'  => '#',

                ],
                [
                    'id_menu_father' => 255,
                    'order' => 5,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                    'text' => 'FINEQ',
                    'icon' => 'fas fa-list',
                    'url'  => '/',
                ],[
                            'id_menu_father' => 266,
                            'order' => 1,
                            'is_title' => 0,
                            'level' => 2,
                            'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                            'text' => 'Bajada',
                            'icon' => 'fas fa-arrow-circle-down',
                            'url'  => '#',

                ],
                [
                    'id_menu_father' => 255,
                    'order' => 6,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                    'text' => 'APROV',
                    'icon' => 'fas fa-list',
                    'url'  => '/',
                ],[
                        'id_menu_father' => 268,
                        'order' => 1,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                        'text' => 'Bajada',
                        'icon' => 'fas fa-arrow-circle-down',
                        'url'  => 'amtPH/ITELTriaraAprovDown',
                    ],[
                        'id_menu_father' => 268,
                        'order' => 2,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                        'text' => 'Subida',
                        'icon' => 'fas fa-arrow-circle-up',
                        'url'  => 'amtPH/ITELTriaraAprovUp',

                ],
                [
                    'id_menu_father' => 255,
                    'order' => 7,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                    'text' => 'PROCESOS CLOUD',
                    'icon' => 'fas fa-list',
                    'url'  => '/',
                ],[
                        'id_menu_father' => 271,
                        'order' => 1,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                        'text' => 'Bajada',
                        'icon' => 'fas fa-arrow-circle-down',
                        'url'  => 'amtPH/downCloudTriara',
                    ],[
                        'id_menu_father' => 271,
                        'order' => 2,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                        'text' => 'Subida',
                        'icon' => 'fas fa-arrow-circle-up',
                        'url'  => 'amtPH/upCloudTriara',

            ],


















            [
                'id_menu_father' => 219,
                'order' => 18,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                'text' => 'Purgue Colas AssurIn',
                'icon' => 'fas fa-spinner',
                'url'  => 'amtPH/jobPurge',
            ],[
                'id_menu_father' => 219,
                'order' => 19,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','amtPHIT-admin')->first())?$permissions->where('name','amtPHIT-admin')->first()->id : 0,
                'text' => 'ReinicioApacheAgendamiento',
                'icon' => 'fas fa-spinner',
                'url'  => 'amtPHIT/reinicioAgendamiento',
            ],[
                'id_menu_father' => 219,
                'order' => 20,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                'text' => 'Reinicio Cluster EAP',
                'icon' => 'fas fa-spinner',
                'url'  => 'amtPH/reinicioClusterEAP',
            ],[
                'id_menu_father' => 219,
                'order' => 21,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                'text' => 'Reinicio Datos Comp',
                'icon' => 'fas fa-spinner',
                'url'  => 'amtPH/reinicioDatosComp',
            ],[
                'id_menu_father' => 219,
                'order' => 22,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                'text' => 'Reinicio Dom. Trafico',
                'icon' => 'fas fa-spinner',
                'url'  => 'amtPH/reinicioDomTrafico',
            ],[
                'id_menu_father' => 219,
                'order' => 23,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','amtPH-mixed')->first())?$permissions->where('name','amtPH-mixed')->first()->id : 0,
                'text' => 'Reinicio Escalonado',
                'icon' => 'fas fa-spinner',
                'url'  => 'amtPH/reinicioEscalonado',
            ],[
                'id_menu_father' => 219,
                'order' => 24,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                'text' => 'Reinicio Itel Osb Venecia',
                'icon' => 'fas fa-spinner',
                'url'  => 'amtPH/ITELRestart',
            ],[
                'id_menu_father' => 219,
                'order' => 25,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','amtPHIT-admin')->first())?$permissions->where('name','amtPHIT-admin')->first()->id : 0,
                'text' => 'Reinicio Visor',
                'icon' => 'fas fa-spinner',
                'url'  => 'amtPHIT/reinicioVisor',
            ],[
                'id_menu_father' => 219,
                'order' => 26,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','amtPHIT-admin')->first())?$permissions->where('name','amtPHIT-admin')->first()->id : 0,
                'text' => 'Reinicio WebService',
                'icon' => 'fas fa-spinner',
                'url'  => 'amtPHIT/reinicioWebService',
            ],[
                'id_menu_father' => 219,
                'order' => 27,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                'text' => 'Subida de dominio',
                'icon' => 'fas fa-arrow-alt-circle-up',
                'url'  => 'amtPH/subidaDominio',
            ],[
                'id_menu_father' => 219,
                'order' => 28,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                'text' => 'Reinicio Itel Osb Triara',
                'icon' => 'fas fa-spinner',
                'url'  => 'amtPH/ITELOsbTriara',
            ],[
                'id_menu_father' => 219,
                'order' => 29,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                'text' => 'Consulta Nodo Manager EAP',
                'icon' => 'fas fa-spinner',
                'url'  => 'amtPH/stateEAP',
            ],[
                'id_menu_father' => 219,
                'order' => 30,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                'text' => 'Diagnóstico Dominios EAP',
                'icon' => 'fas fa-spinner',
                'url'  => 'amtPH/errorEAP',
            ],[
                'id_menu_father' => 219,
                'order' => 31,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','amtPH-admin')->first())?$permissions->where('name','amtPH-admin')->first()->id : 0,
                'text' => 'Diagnóstico Datasource BSCS',
                'icon' => 'fas fa-spinner',
                'url'  => 'amtPH/diagEapBSCS',
            ],
        ];



        $menusSan = [
            [
                'id_menu_father' => 18,
                'order' => 1,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','san-admin')->first())?$permissions->where('name','san-admin')->first()->id : 0,
                'text' => 'Administración',
                'icon' => 'fas fa-user-shield',
                'url'  => '/',
            ],[
                     'id_menu_father' => 288,
                    'order' => 1,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','san-admin')->first())?$permissions->where('name','san-admin')->first()->id : 0,
                    'text' => 'Comandos Fabric',
                    'icon' => 'fas fa-network-wired',
                    'url'  => 'san/admin/fabric',
                ],[
                     'id_menu_father' => 288,
                    'order' => 2,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','san-admin')->first())?$permissions->where('name','san-admin')->first()->id : 0,
                    'text' => 'SAN Extendida',
                    'icon' => 'fas fa-network-wired',
                    'url'  => 'san/admin/sanExtend',
                ],[
                     'id_menu_father' => 288,
                    'order' => 3,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','san-admin')->first())?$permissions->where('name','san-admin')->first()->id : 0,
                    'text' => 'Reporte de puertos',
                    'icon' => 'fas fa-file-invoice',
                    'url'  => 'san/admin/portsReport',
                ],[
                     'id_menu_father' => 288,
                    'order' => 4,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','san-admin')->first())?$permissions->where('name','san-admin')->first()->id : 0,
                    'text' => 'Umbrales reporte de puertos',
                    'icon' => 'fas fa-file-contract',
                    'url'  => 'san/admin/configPortReport',

            ],
            [
                 'id_menu_father' => 18,
                'order' => 2,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','san-user')->first())?$permissions->where('name','san-user')->first()->id : 0,
                'text' => 'Consultas',
                'icon' => 'fas fa-search',
                'url'  => '/',
            ],[
                     'id_menu_father' => 293,
                    'order' => 1,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','san-user')->first())?$permissions->where('name','san-user')->first()->id : 0,
                    'text' => 'Puertos',
                    'icon' => 'fas fa-network-wired',
                    'url'  => 'san/queries/portState',
                ],[
                     'id_menu_father' => 293,
                    'order' => 2,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','san-user')->first())?$permissions->where('name','san-user')->first()->id : 0,
                    'text' => 'WWN',
                    'icon' => 'fas fa-hdd',
                    'url'  => 'san/queries/WWNSearch',
                ],[
                     'id_menu_father' => 293,
                    'order' => 3,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','san-user')->first())?$permissions->where('name','san-user')->first()->id : 0,
                    'text' => 'WWN/NAA Discos',
                    'icon' => 'fas fa-hdd',
                    'url'  => 'san/queries/wwnNaa',
                ],[
                     'id_menu_father' => 293,
                    'order' => 4,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','san-user')->first())?$permissions->where('name','san-user')->first()->id : 0,
                    'text' => 'Zonas',
                    'icon' => 'fas fa-network-wired',
                    'url'  => 'san/queries/ZoneSearch',

            ],[
                 'id_menu_father' => 18,
                'order' => 3,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','san-user')->first())?$permissions->where('name','san-user')->first()->id : 0,
                'text' => 'Inventarios',
                'icon' => 'fas fa-search',
                'url'  => '/',
            ],[
                     'id_menu_father' => 298,
                    'order' => 1,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','sanNas-user')->first())?$permissions->where('name','sanNas-user')->first()->id : 0,
                    'text' => 'NAS',
                    'icon' => 'fas fa-hdd',
                    'url'  => 'san/inventories/sanNas',
                    ],[
                         'id_menu_father' => 298,
                        'order' => 2,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','sanLink-user')->first())?$permissions->where('name','sanLink-user')->first()->id : 0,
                        'text' => 'Links',
                        'icon' => 'fas fa-link',
                        'url'  => 'san/inventories/sanLink',
                    ],[
                         'id_menu_father' => 298,
                        'order' => 3,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','sanLun-user')->first())?$permissions->where('name','sanLun-user')->first()->id : 0,
                        'text' => 'LUN',
                        'icon' => 'fas fa-hdd',
                        'url'  => 'san/inventories/sanLun',
                    ],[
                         'id_menu_father' => 298,
                        'order' => 4,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','sanPort-user')->first())?$permissions->where('name','sanPort-user')->first()->id : 0,
                        'text' => 'Puertos',
                        'icon' => 'fas fa-network-wired',
                        'url'  => 'san/inventories/sanPorts',
                    ],[
                         'id_menu_father' => 298,
                        'order' => 5,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','sanServer-user')->first())?$permissions->where('name','sanServer-user')->first()->id : 0,
                        'text' => 'Servidores',
                        'icon' => 'fas fa-server',
                        'url'  => 'san/inventories/sanServer',
                    ],[
                         'id_menu_father' => 298,
                        'order' => 6,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','sanSwitch-user')->first())?$permissions->where('name','sanSwitch-user')->first()->id : 0,
                        'text' => 'Switch',
                        'icon' => 'fas fa-network-wired',
                        'url'  => 'san/inventories/sanSwitch',
                    ],[
                         'id_menu_father' => 298,
                        'order' => 7,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','sanStorage-user')->first())?$permissions->where('name','sanStorage-user')->first()->id : 0,
                        'text' => 'Storage',
                        'icon' => 'fas fa-hdd',
                        'url'  => 'san/inventories/sanStorage',
                    ]

        ];

        $menusUnix = [
            [
                //id 306
                'id_menu_father' => 21,
                'order' => 1,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','unixEN-menu')->first())?$permissions->where('name','unixEN-menu')->first()->id : 0,
                'text' => 'UNIX E&N',
                'icon' => 'fas fa-arrow-right',
                'url'  => '/',
            ],[
                    'id_menu_father' => 306,
                    'order' => 1,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','unixEN-user')->first())?$permissions->where('name','unixEN-user')->first()->id : 0,
                    'text' => 'Conectividad Unix',
                    'icon' => 'fas fa-check-double',
                    'url'  => 'unix/connectivity',
                ],[
                    'id_menu_father' => 306,
                    'order' => 2,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','unixEN-user')->first())?$permissions->where('name','unixEN-user')->first()->id : 0,
                    'text' => 'Asignación de permisos',
                    'icon' => 'fas fa-check-double',
                    'url'  => 'unix/folderPermission',
                ],[
                    'id_menu_father' => 306,
                    'order' => 3,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','unixEN-user')->first())?$permissions->where('name','unixEN-user')->first()->id : 0,
                    'text' => 'Check Paso a Operación ',
                    'icon' => 'fas fa-check-double',
                    'url'  => 'unix/checkPaso',
                ],[
                    'id_menu_father' => 306,
                    'order' => 4,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','unixEN-mixed')->first())?$permissions->where('name','unixEN-mixed')->first()->id : 0,
                    'text' => 'Depuración filesystem',
                    'icon' => 'fas fa-trash',
                    'url'  => 'unix/cleanFileSystem',
                ],[
                    'id_menu_father' => 306,
                    'order' => 5,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','unixEN-mixed')->first())?$permissions->where('name','unixEN-mixed')->first()->id : 0,
                    'text' => 'Configuración LVM',
                    'icon' => 'fas fa-hdd',
                    'url'  => 'unix/configLvm',
                ],[
                    'id_menu_father' => 306,
                    'order' => 6,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','unixEN-user')->first())?$permissions->where('name','unixEN-user')->first()->id : 0,
                    'text' => 'Gestión de discos',
                    'icon' => 'fas fa-save',
                    'url'  => 'unix/diskManagement',
                ],[
                    'id_menu_father' => 306,
                    'order' => 7,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','unixEN-menu')->first())?$permissions->where('name','unixEN-menu')->first()->id : 0,
                    'text' => 'Gestión de usuarios',
                    'icon' => 'fas fa-user',
                    'url'  => '/',
                ],[
                        'id_menu_father' => 313,
                        'order' => 1,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','unixEN-mixed')->first())?$permissions->where('name','unixEN-mixed')->first()->id : 0,
                        'text' => 'Crear usuarios',
                        'icon' => 'fas fa-user-plus',

                        'url'  => 'unix/create',
                    ],[
                        'id_menu_father' => 313,
                        'order' => 2,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','unixEN-admin')->first())?$permissions->where('name','unixEN-admin')->first()->id : 0,
                        'text' => 'Crear usuarios Admin',
                        'icon' => 'fas fa-user-plus',

                        'url'  => 'unix/createAdm',
                    ],[
                        'id_menu_father' => 313,
                        'order' => 3,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','unixEN-mixed')->first())?$permissions->where('name','unixEN-mixed')->first()->id : 0,
                        'text' => 'Cambio password',
                        'icon' => 'fas fa-user-edit',

                        'url'  => 'unix/change',
                    ],[
                        'id_menu_father' => 313,
                        'order' => 4,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','unixEN-user')->first())?$permissions->where('name','unixEN-user')->first()->id : 0,
                        'text' => 'Cambio password AD',
                        'icon' => 'fas fa-user-edit',

                        'url'  => 'unix/resetUserByAD',
                    ],[
                        'id_menu_father' => 313,
                        'order' => 5,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','unixEN-mixed')->first())?$permissions->where('name','unixEN-mixed')->first()->id : 0,
                        'text' => 'Deshabiltar usuario',
                        'icon' => 'fas fa-user-times',

                        'url'  => 'unix/disable',
                    ],[

                        // 349
                        'id_menu_father' => 313,
                        'order' => 6,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','unixEN-mixed')->first())?$permissions->where('name','unixEN-mixed')->first()->id : 0,
                        'text' => 'Eliminar usuario',
                        'icon' => 'fas fa-user-times',

                        'url'  => 'unix/delete',
                ],[
                    //350
                    'id_menu_father' => 306,
                    'order' => 8,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','unixEN-user')->first())?$permissions->where('name','unixEN-user')->first()->id : 0,
                    'text' => 'Logrotate',
                    'icon' => 'fas fa-file-code',

                    'url'  => 'unix/logrotate',
                ],[
                    'id_menu_father' => 306,
                    'order' => 9,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','unixEN-mixed')->first())?$permissions->where('name','unixEN-mixed')->first()->id : 0,
                    'text' => 'Inventario',
                    'icon' => 'fas fa-list',

                    'url'  => 'unix/inventario',
                ],[
                    'id_menu_father' => 306,
                    'order' => 10,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','unixEN-mixed')->first())?$permissions->where('name','unixEN-mixed')->first()->id : 0,
                    'text' => 'Liberación de memoria',
                    'icon' => 'fas fa-memory',

                    'url'  => 'unix/freeMemory',
                ],[
                    'id_menu_father' => 306,
                    'order' => 11,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','unixEN-mixed')->first())?$permissions->where('name','unixEN-mixed')->first()->id : 0,
                    'text' => 'Listado de puertos',
                    'icon' => 'fas fa-list',

                    'url'  => 'unix/portListen',
                ],[
                    'id_menu_father' => 306,
                    'order' => 12,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','unixEN-mixed')->first())?$permissions->where('name','unixEN-mixed')->first()->id : 0,
                    'text' => 'Check S.O',
                    'icon' => 'fas fa-shoe-prints',
                    'url'  => '/',
                ],[
                        'id_menu_father' => 324,
                        'order' => 1,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','unixEN-mixed')->first())?$permissions->where('name','unixEN-mixed')->first()->id : 0,
                        'text' => 'Pre-Ventana',
                        'icon' => 'fas fa-step-backward',

                        'url'  => 'unix/pasoPrevio',
                    ],[
                        'id_menu_father' => 324,
                        'order' => 2,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','unixEN-mixed')->first())?$permissions->where('name','unixEN-mixed')->first()->id : 0,
                        'text' => 'Post-Ventana',
                        'icon' => 'fas fa-step-forward',

                        'url'  => 'unix/pasoPosterior',

                ],[
                    'id_menu_father' => 306,
                    'order' => 13,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','unixEN-mixed')->first())?$permissions->where('name','unixEN-mixed')->first()->id : 0,
                    'text' => 'PLK - 7 Pasos - Unix',
                    'icon' => 'fas fa-shoe-prints',

                    'url'  => 'unix/sevenSteps',
                ],[
                    'id_menu_father' => 306,
                    'order' => 14,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','unixEN-mixed')->first())?$permissions->where('name','unixEN-mixed')->first()->id : 0,
                    'text' => 'Reinicio de servicios',
                    'icon' => 'fas fa-spinner',

                    'url'  => 'unix/restartServices',
                ],[
                    'id_menu_father' => 306,
                    'order' => 15,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','unixEN-mixed')->first())?$permissions->where('name','unixEN-mixed')->first()->id : 0,
                    'text' => 'Rutas Estáticas',
                    'icon' => 'fas fa-route',

                    'url'  => 'unix/rutasEstaticas',
                ],[
                    'id_menu_father' => 306,
                    'order' => 16,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','unixEN-mixed')->first())?$permissions->where('name','unixEN-mixed')->first()->id : 0,
                    'text' => 'Simpana',
                    'icon' => 'fas fa-route',

                    'url'  => 'unix/simpana',
                ],[
                    'id_menu_father' => 306,
                    'order' => 17,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','unixEN-mixed')->first())?$permissions->where('name','unixEN-mixed')->first()->id : 0,
                    'text' => 'Snapshot Solaris',
                    'icon' => 'fas fa-camera-retro',
                    'url'  => '/',
                ],[
                        'id_menu_father' => 331,
                        'order' => 1,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','unixEN-mixed')->first())?$permissions->where('name','unixEN-mixed')->first()->id : 0,
                        'text' => 'Listar información',
                        'icon' => 'fas fa-clipboard-list',

                        'url'  => 'unix/snapSList',
                    ],[
                        'id_menu_father' => 331,
                        'order' => 2,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','unixEN-mixed')->first())?$permissions->where('name','unixEN-mixed')->first()->id : 0,
                        'text' => 'Gestión de snapshot',
                        'icon' => 'fas fa-camera-retro',

                        'url'  => 'unix/snapSolaris',
                ],[

                    // 364
                    'id_menu_father' => 306,
                    'order' => 18,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','unixEN-mixed')->first())?$permissions->where('name','unixEN-mixed')->first()->id : 0,
                    'text' => 'Uptime',
                    'icon' => 'fas fa-stopwatch',
                    'url'  => 'unix/uptime',
            ],



            [
                'id_menu_father' => 21,
                'order' => 2,
                'is_title' => 0,
                'level' => 2,
                'id_permission' => ($permissions->where('name','unixPH-menu')->first())?$permissions->where('name','unixPH-menu')->first()->id : 0,
                'text' => 'UNIX P&H',
                'icon' => 'fas fa-arrow-right',
                'url'  => '/',
            ],[
                    'id_menu_father' => 335,
                    'order' => 1,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','unixPH-user')->first())?$permissions->where('name','unixPH-user')->first()->id : 0,
                    'text' => 'Check de plataformas',
                    'icon' => 'fas fa-network-wired',
                    'url'  => 'unixPH/checkPlatforms',
                ],[
                    'id_menu_father' => 335,
                    'order' => 2,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','unixPH-user')->first())?$permissions->where('name','unixPH-user')->first()->id : 0,
                    'text' => 'Check paso a operación',
                    'icon' => 'fas fa-check-double',
                    'url'  => 'unixPH/checkPasoUnix',
                ],[
                    'id_menu_father' => 335,
                    'order' => 3,
                    'is_title' => 0,
                    'level' => 2,
                    'id_permission' => ($permissions->where('name','unixPH-user')->first())?$permissions->where('name','unixPH-user')->first()->id : 0,
                    'text' => 'Gestión de usuarios',
                    'icon' => 'fas fa-user',
                    'url'  => '/',
                ],[
                        'id_menu_father' => 338,
                        'order' => 1,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','unixPH-user')->first())?$permissions->where('name','unixPH-user')->first()->id : 0,
                        'text' => 'Crear usuarios',
                        'icon' => 'fas fa-user-plus',
                        'url'  => 'unixPH/create',
                    ],[
                        'id_menu_father' => 338,
                        'order' => 2,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','unixPH-user')->first())?$permissions->where('name','unixPH-user')->first()->id : 0,
                        'text' => 'Desbloqueo de usuario',
                        'icon' => 'fas fa-user-lock',
                        'url'  => 'unixPH/unlock',
                    ],[
                        'id_menu_father' => 338,
                        'order' => 3,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','unixPH-user')->first())?$permissions->where('name','unixPH-user')->first()->id : 0,
                        'text' => 'Eliminar usuario',
                        'icon' => 'fas fa-user-times',
                        'url'  => 'unixPH/delete',
                    ],[
                        'id_menu_father' => 338,
                        'order' => 4,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','unixPH-user')->first())?$permissions->where('name','unixPH-user')->first()->id : 0,
                        'text' => 'Modificar usuario',
                        'icon' => 'fas fa-user-edit',
                        'url'  => 'unixPH/change',

                    ],[
                        'id_menu_father' => 335,
                        'order' => 4,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','unixPH-user')->first())?$permissions->where('name','unixPH-user')->first()->id : 0,
                        'text' => 'Gestión DNS',
                        'icon' => 'fas fa-network-wired',
                        'url'  => 'unixPH/dnsclaro',
                    ],[
                        'id_menu_father' => 335,
                        'order' => 5,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','unixPH-user')->first())?$permissions->where('name','unixPH-user')->first()->id : 0,
                        'text' => 'PAM vs Release',
                        'icon' => 'fas fa-network-wired',
                        'url'  => 'unixPH/uptimeRelease',
                    ],[
                        'id_menu_father' => 335,
                        'order' => 6,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','unixPH-user')->first())?$permissions->where('name','unixPH-user')->first()->id : 0,
                        'text' => 'Reinicio Unix',
                        'icon' => 'fas fa-power-off',
                        'url'  => '/',
                    ],[
                            'id_menu_father' => 345,
                            'order' => 1,
                            'is_title' => 0,
                            'level' => 2,
                            'id_permission' => ($permissions->where('name','unixPH-user')->first())?$permissions->where('name','unixPH-user')->first()->id : 0,
                            'text' => 'Prevalidación Reinicio',
                            'icon' => 'fas fa-hand-point-right',
                            'url'  => 'unixPH/prevalidation',
                        ],[
                            'id_menu_father' => 345,
                            'order' => 2,
                            'is_title' => 0,
                            'level' => 2,
                            'id_permission' => ($permissions->where('name','unixPH-user')->first())?$permissions->where('name','unixPH-user')->first()->id : 0,
                            'text' => 'Proceso Reinicio',
                            'icon' => 'fas fa-hand-point-right',
                            'url'  => 'unixPH/restart',
                        ],[
                            'id_menu_father' => 345,
                            'order' => 3,
                            'is_title' => 0,
                            'level' => 2,
                            'id_permission' => ($permissions->where('name','unixPH-user')->first())?$permissions->where('name','unixPH-user')->first()->id : 0,
                            'text' => 'Proceso Validación',
                            'icon' => 'fas fa-hand-point-right',
                            'url'  => 'unixPH/validation',
                        ],[
                            'id_menu_father' => 345,
                            'order' => 4,
                            'is_title' => 0,
                            'level' => 2,
                            'id_permission' => ($permissions->where('name','unixPH-user')->first())?$permissions->where('name','unixPH-user')->first()->id : 0,
                            'text' => 'Proceso subida BD',
                            'icon' => 'fas fa-hand-point-right',
                            'url'  => 'unixPH/uploadDb',

                    ],[
                        'id_menu_father' => 335,
                        'order' => 7,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','unixPH-user')->first())?$permissions->where('name','unixPH-user')->first()->id : 0,
                        'text' => 'Uptime',
                        'icon' => 'fas fa-network-wired',
                        'url'  => 'unixPH/uptime',
                    ],[
                        'id_menu_father' => 335,
                        'order' => 8,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','unixPH-user')->first())?$permissions->where('name','unixPH-user')->first()->id : 0,
                        'text' => 'Siete Pasos',
                        'icon' => 'fas fa-shoe-prints',
                        'url'  => 'unixPH/sevenStepsPH',
                    ],[
                        'id_menu_father' => 335,
                        'order' => 9,
                        'is_title' => 0,
                        'level' => 2,
                        'id_permission' => ($permissions->where('name','unixPH-user')->first())?$permissions->where('name','unixPH-user')->first()->id : 0,
                        'text' => 'Validación NFS Venecia',
                        'icon' => 'fas fa-server',
                        'url'  => 'unixPH/validationNFSVenecia',
                    ]
        ];

        $menusSOPH = [

            [
            'id_menu_father' => 4,
            'order' => 1,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','supportEN-menu')->first())?$permissions->where('name','supportEN-menu')->first()->id : 0,
            'text' => 'AMT',
            'icon' => 'fas fa-spinner',
            'url'  => '#',
            ],[
            'id_menu_father' => 4,
            'order' => 2,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','supportEN-menu')->first())?$permissions->where('name','supportEN-menu')->first()->id : 0,
            'text' => 'Balanceadores',
            'icon' => 'fas fa-spinner',
            'url'  => '#',
            ],[
            'id_menu_father' => 4,
            'order' => 3,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','supportEN-menu')->first())?$permissions->where('name','supportEN-menu')->first()->id : 0,
            'text' => 'Oracle',
            'icon' => 'fas fa-spinner',
            'url'  => '#',
            ],[
            'id_menu_father' => 4,
            'order' => 4,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','supportEN-menu')->first())?$permissions->where('name','supportEN-menu')->first()->id : 0,
            'text' => 'Unix',
            'icon' => 'fas fa-spinner',
            'url'  => '#',
            ],[
            'id_menu_father' => 4,
            'order' => 5,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','supportEN-menu')->first())?$permissions->where('name','supportEN-menu')->first()->id : 0,
            'text' => 'Sql',
            'icon' => 'fas fa-spinner',
            'url'  => '#',
            ],[
            'id_menu_father' => 4,
            'order' => 6,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','supportEN-menu')->first())?$permissions->where('name','supportEN-menu')->first()->id : 0,
            'text' => 'Windows',
            'icon' => 'fas fa-spinner',
            'url'  => '/',
            ],[
            'id_menu_father' => 358,
            'order' => 1,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','supportEN-menu')->first())?$permissions->where('name','supportEN-menu')->first()->id : 0,
            'text' => 'Check AD',
            'icon' => 'fas fa-check-double',
            'url'  => 'supportEN/windows/checkAD',
            ],[
            'id_menu_father' => 358,
            'order' => 2,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','supportEN-menu')->first())?$permissions->where('name','supportEN-menu')->first()->id : 0,
            'text' => 'Check procesos CPU',
            'icon' => 'fas fa-check-double',
            'url'  => 'supportEN/windows/checkCPUProcess',
            ],[
            'id_menu_father' => 358,
            'order' => 3,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','supportEN-menu')->first())?$permissions->where('name','supportEN-menu')->first()->id : 0,
            'text' => 'Check Sistema Operativo',
            'icon' => 'fas fa-check-double',
            'url'  => 'supportEN/windows/checkSO',
            ],[
            'id_menu_father' => 358,
            'order' => 4,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','supportEN-menu')->first())?$permissions->where('name','supportEN-menu')->first()->id : 0,
            'text' => 'Check S.O',
            'icon' => 'fas fa-shoe-prints',
            'url'  => '/',
            ],[
            'id_menu_father' => 362,
            'order' => 1,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','supportEN-menu')->first())?$permissions->where('name','supportEN-menu')->first()->id : 0,
            'text' => 'Pre-Ventana',
            'icon' => 'fas fa-step-backward',
            'url'  => 'supportEN/windows/preVentana',
            ],[
            'id_menu_father' => 362,
            'order' => 1,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','supportEN-menu')->first())?$permissions->where('name','supportEN-menu')->first()->id : 0,
            'text' => 'Post-Ventana',
            'icon' => 'fas fa-step-forward',
            'url'  => 'supportEN/windows/postVentana',

            ],[
            'id_menu_father' => 358,
            'order' => 5,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','supportEN-menu')->first())?$permissions->where('name','supportEN-menu')->first()->id : 0,
            'text' => 'Depuración de memoria',
            'icon' => 'fas fa-memory',
            'url'  => 'supportEN/windows/freeMemory',
            ],[
            'id_menu_father' => 358,
            'order' => 6,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','supportEN-menu')->first())?$permissions->where('name','supportEN-menu')->first()->id : 0,
            'text' => 'Depuración de discos',
            'icon' => 'fas fa-hdd',
            'url'  => 'supportEN/windows/debuggingDisks',
            ],[
            'id_menu_father' => 358,
            'order' => 7,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','supportEN-menu')->first())?$permissions->where('name','supportEN-menu')->first()->id : 0,
            'text' => 'PLK - 7 Pasos - Windows',
            'icon' => 'fas fa-shoe-prints',
            'url'  => 'supportEN/windows/sevenSteps',
            ],[
            'id_menu_father' => 358,
            'order' => 8,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','supportEN-menu')->first())?$permissions->where('name','supportEN-menu')->first()->id : 0,
            'text' => 'Gestión de servicios',
            'icon' => 'fas fa-check-double',
            'url'  => 'pass/windows/services',
            ],[
            'id_menu_father' => 358,
            'order' => 9,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','supportEN-menu')->first())?$permissions->where('name','supportEN-menu')->first()->id : 0,
            'text' => 'Conectividad',
            'icon' => 'fas fa-check-double',
            'url'  => 'pass/windows/connectivity',

            ],[
            'id_menu_father' => 4,
            'order' => 10,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','supportEN-menu')->first())?$permissions->where('name','supportEN-menu')->first()->id : 0,
            'text' => 'Unix',
            'icon' => 'fas fa-spinner',
            'url'  => '/',
            ],[
            'id_menu_father' => 370,
            'order' => 1,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','supportEN-menu')->first())?$permissions->where('name','supportEN-menu')->first()->id : 0,
            'text' => 'Conectividad',
            'icon' => 'fas fa-check-double',
            'url'  => 'pass/unix/connectivity',


            ],

















            // 'text' => 'SOPORTE P&H',
            // 'icon' => 'far fa-circle',
            // 'can' => 'supportPH-menu',
            // 'submenu' => array([
            [
            'id_menu_father' => 204,
            'order' => 1,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','supportPH-menu')->first())?$permissions->where('name','supportPH-menu')->first()->id : 0,
            'text' => 'AMT',
            'icon' => 'fas fa-spinner',
            'url'  => '#',
            ],[
            'id_menu_father' => 204,
            'order' => 2,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','supportPH-menu')->first())?$permissions->where('name','supportPH-menu')->first()->id : 0,
            'text' => 'Balanceadores',
            'icon' => 'fas fa-spinner',
            'url'  => '#',
            ],[
            'id_menu_father' => 204,
            'order' => 3,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','supportPH-menu')->first())?$permissions->where('name','supportPH-menu')->first()->id : 0,
            'text' => 'Oracle',
            'icon' => 'fas fa-spinner',
            'url'  => '#',
            ],[
            'id_menu_father' => 204,
            'order' => 4,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','supportPH-menu')->first())?$permissions->where('name','supportPH-menu')->first()->id : 0,
            'text' => 'Unix',
            'icon' => 'fas fa-spinner',
            'url'  => '#',
            ],[
            'id_menu_father' => 375,
            'order' => 1,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','supportPH-menu')->first())?$permissions->where('name','supportPH-menu')->first()->id : 0,
            'text' => 'Check Sistema Operativo',
            'icon' => 'fas fa-shoe-prints',
            'url'  => 'supportPH/linux/checkUnixPH',

            ],[
            'id_menu_father' => 204,
            'order' => 5,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','supportPH-menu')->first())?$permissions->where('name','supportPH-menu')->first()->id : 0,
            'text' => 'Sql',
            'icon' => 'fas fa-spinner',
            'url'  => '#',
            ],[
            'id_menu_father' => 204,
            'order' => 6,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','supportPH-menu')->first())?$permissions->where('name','supportPH-menu')->first()->id : 0,
            'text' => 'Windows',
            'icon' => 'fas fa-spinner',
            'url'  => '/',
            ],[
            'id_menu_father' => 378,
            'order' => 1,
            'is_title' => 0,
            'level' => 2,
            'id_permission' => ($permissions->where('name','supportPH-menu')->first())?$permissions->where('name','supportPH-menu')->first()->id : 0,
            'text' => 'Check Sistema Operativo',
            'icon' => 'fas fa-shoe-prints',
            'url'  => 'supportPH/windows/checkWindowsPH',
            ]






        ];







        Menus::insert($menus);
        DB::table('menu')->where('id',13)->delete();
        Menus::insert($menusN2Administracion);
        Menus::insert($menuN3Administracion);
        Menus::insert($menuN1Gestion);
        Menus::insert($reportesMenus);
        Menus::insert($menusRecursos);
        Menus::insert($menusVirtualizacion);
        Menus::insert($menusWindows1);
        Menus::insert($menusWindows2);
        Menus::insert($menusTelefonia);
        Menus::insert($menusSeguridadDC);
        Menus::insert($menusRedesPymes);
        Menus::insert($menusRedes);
        Menus::insert($menusOperadores);
        Menus::insert($menusOpeLas);
        Menus::insert($menusCloud);
        Menus::insert($meunsCheckPaso);
        Menus::insert($menuBalance);
        Menus::insert($menuBackup);
        Menus::insert($menuPoliedro);
        Menus::insert($menuArreglo);
        Menus::insert($menusAMTENMenus);
        Menus::insert($menusAMTPNMenus1);
        Menus::insert($menusAMTPNMenus2);
        Menus::insert($menusSan);
        Menus::insert($menusUnix);
        Menus::insert($menusSOPH);

    }
}
