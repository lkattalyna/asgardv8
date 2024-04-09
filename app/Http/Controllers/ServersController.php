<?php

namespace App\Http\Controllers;

use App\clientes;
use App\controladoras;
use App\data_centers;
use App\servers;
use App\server_marcas;
use App\server_modelos;
use App\propietarios;
use App\raids;
use App\responsables;
use App\sistema_operativos;
use App\server_estados;
use App\tipos_clientes;
use App\tipos_hardware;
use App\tipos_racks;
use App\tipos_servicios;
use App\memorias;
use App\tipo_memorias;
use App\cpus;
use App\cpu_marcas;
use App\cpu_modelos;
use App\discos;
use App\disco_marcas;
use App\hbas;
use App\nics;
use App\nic_referencias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ServersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $servers = servers::with([
            'marca' => function($query){
                $query->select('id','nombre');
            },
            'modelo' => function($query){
                $query->select('id','modelo');
            },
            'generacion' => function($query){
                $query->select('id','generacion');
            },
            'dataCenter' => function($query){
                $query->select('id','nombre');
            },
            'cliente' => function($query){
                $query->select('id','nombre');
            }
        ])->latest()->take(100)->get(['id','cod_servicio','serie','site','rack','unidad_inferior','unidad_superior','bahia','id_modelo','id_marca','id_data_center','id_cliente']);
         return view('infrastructure.server.server.servers.index', compact('servers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $propietarios = propietarios::orderBy('nombre')->get();
        $responsables = responsables::orderBy('nombre')->get();
        $marcas = server_marcas::orderBy('nombre')->get();
        //$modelos = ServerModelo::orderBy('modelo')->get();
        $sos = sistema_operativos::orderBy('nombre')->get();
        $dataCenters = data_centers::orderBy('nombre')->get();
        $clientes = clientes::orderBy('nombre')->get();
        $tipoClientes = tipos_clientes::orderBy('nombre')->get();
        $tiposHardware = tipos_hardware::orderBy('nombre')->get();
        $tipoServicios = tipos_servicios::orderBy('nombre')->get();
        $tipoRacks = tipos_racks::orderBy('nombre')->get();
        $raids = raids::orderBy('tipo')->get();
        $controladoras = controladoras::orderBy('nombre')->get();
        $estados = server_estados::orderBy('nombre')->get();
        $memorias = tipo_memorias::orderBy('nombre')->get();
        $cpuModelos = cpu_modelos::orderBy('nombre')->get();
        $cpuMarcas = cpu_marcas::orderBy('nombre')->get();
        $discoMarcas = disco_marcas::orderBy('nombre')->get();
        //$discoCapac = Disco::orderBy('capacidad')->get();
        $discoCapac = discos::distinct('capacidad')->get('capacidad');
        $hbas = hbas::distinct('puertos')->get('puertos');
        $nicReferencias = nic_referencias::distinct('nombre')->get('nombre');
        $nics = nics::distinct('puertos')->get('puertos');
        $capMemorias = memorias::distinct('capacidad')->get('capacidad');
        $tipoSoportes = servers::distinct('tipo_soporte')->get('tipo_soporte');

        /*
        $prueba = DB::table('discos')
                        ->select(DB::raw('count(*) as discos_marcas, capacidad'))
                        ->having('capacidad', '>', 1)
                        ->groupBy('capacidad')
                        ->get();*/


        //$memorias = Memoria::orderBy('capacidad', 'desc')->get();
        //$memorias = Memoria::where('id_servidor', $server->id)->get();
        //dd($memorias);
        //dd($discoCapac);
        //dd($prueba);

        return view('infrastructure.server.server.servers.create', compact('propietarios','responsables','marcas','sos','dataCenters','clientes','tipoClientes','tiposHardware','tipoRacks','tipoServicios','raids','controladoras','estados','memorias','cpuModelos','discoMarcas','discoCapac','hbas','nicReferencias','nics','capMemorias','tipoSoportes','cpuMarcas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'cod_servicio' => 'required|string|min:1|max:20',
            'serie' => 'required|string|min:1|max:25',
            'site' => 'required|string|min:1|max:30',
            'rack' => 'required|string|min:1|max:30',
            'und_inferior' => 'required|string|min:1|max:10',
            'und_superior' => 'required|string|min:1|max:10',
            'bahia' => 'required|string|min:1|max:10',
            'estado' => 'required|string|min:1|max:10',
            'tipoSoporte' => 'required|string|min:1|max:190',
            'fuentes' => 'required|integer',
            'biosFW' => 'required|string|min:1|max:50',
            'nicFW' => 'required|string|min:1|max:50',
            'iloFW' => 'required|string|min:1|max:50',
            'controladoraFW' => 'required|string|min:1|max:50',
            'pmFW' => 'required|string|min:1|max:50',
            'hbaFW' => 'required|string|min:1|max:50',
            'oaFW' => 'required|string|min:1|max:50',
            'vcSanFW' => 'required|string|min:1|max:50',
            'vcLanFW' => 'required|string|min:1|max:50',
        ]);
        if ($validator->fails()) {
            return redirect('server/servers/create')
                ->withErrors($validator)
                ->withInput();
        }
        $servidor = servers::create([
            'id_marca' => $request->input('marca'),
            'id_modelo' => $request->input('modelo'),
            'cod_servicio' => $request->input('cod_servicio'),
            'serie' => $request->input('serie'),
            'id_estado' => $request->input('serverEstado'),
            'estado' => $request->input('estado'),
            'id_propietario' => $request->input('propietario'),
            'id_responsable' => $request->input('responsable'),
            'id_so' => $request->input('so'),
            'id_data_center' => $request->input('dataCenter'),
            'site' => $request->input('site'),
            'rack' => $request->input('rack'),
            'unidad_inferior' => $request->input('und_inferior'),
            'unidad_superior' => $request->input('und_superior'),
            'bahia' => $request->input('bahia'),
            'id_cliente' => $request->input('cliente'),
            'id_tipo_cliente' => $request->input('tipoCliente'),
            'id_tipo_hardware' => $request->input('tipoHardware'),
            'id_tipo_servicio' => $request->input('tipoServicio'),
            'servicio_macro' => $request->input('servicioMacro'),
            'id_tipo_rack' => $request->input('tipoRack'),
            'tiene_soporte' => $request->input('tieneSoporte'),
            'tipo_soporte' => $request->input('tipoSoporte'),
            'soporte' => $request->input('fechaSoporte'),
            'eos_date' => $request->input('eosDate'),
            'eol_date' => $request->input('eolDate'),
            'id_controladora' => $request->input('controladora'),
            'fuentes' => $request->input('fuentes'),
            'id_raid' => $request->input('raid'),
            'unidad_dvd' => $request->input('dvd'),
            'bios_firmware' => $request->input('biosFW'),
            'nic_firmware' => $request->input('nicFW'),
            'ilo_firmware' => $request->input('iloFW'),
            'controladora_firmware' => $request->input('controladoraFW'),
            'power_management_firmware' => $request->input('pmFW'),
            'hba_firmware' => $request->input('hbaFW'),
            'oa_firmware' => $request->input('oaFW'),
            'vc_san' => $request->input('vcSanFW'),
            'vc_lan' => $request->input('vcLanFW'),
            'ip' => $request->input('ip'),
            'observaciones' => $request->input('obs'),
            'fecha_Implementacion' => $request->input('fechaImplementacion'),
            'fecha_Desistalacion' => $request->input('fechaDesistalacion'),
            'correos' => $request->input('correos'),
        ]);
        /*
        $cpuMarca = CpuMarca::create([
            'nombre' => $request->input('marcaProc'),
        ]);
        $cpuModelo = CpuModelo::create([
            'nombre' => $request->input('modProc'),
            'id_cpu_marca' => $cpuMarca->id,
        ]);*/

        return redirect()->route('servers.index')
            ->with('success','El servidor ha sido creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\servers  $servers
     * @return \Illuminate\Http\Response
     */
    public function show(servers $server)
    {
        //
        return view('infrastructure.server.server.servers.show', compact('server'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\servers  $servers
     * @return \Illuminate\Http\Response
     */
    public function edit(servers $server, $form)
    {
        //
        $propietarios = propietarios::orderBy('nombre')->get();
        $responsables = responsables::orderBy('nombre')->get();
        $marcas = server_marcas::orderBy('nombre')->get();
        //$modelos = ServerModelo::orderBy('modelo')->get();
        $sos = sistema_operativos::orderBy('nombre')->get();
        $dataCenters = data_centers::orderBy('nombre')->get();
        $clientes = clientes::orderBy('nombre')->get();
        $tipoClientes = tipos_clientes::orderBy('nombre')->get();
        $tiposHardware = tipos_hardware::orderBy('nombre')->get();
        $tipoServicios = tipos_servicios::orderBy('nombre')->get();
        $tipoRacks = tipos_racks::orderBy('nombre')->get();
        $raids = raids::orderBy('tipo')->get();
        $controladoras = controladoras::orderBy('nombre')->get();
        $estados = server_estados::orderBy('nombre')->get();
        return view('infrastructure.server.server.servers.edit',compact('propietarios','responsables','marcas','sos','dataCenters','clientes','tipoClientes','tiposHardware','tipoRacks','tipoServicios','raids','controladoras','server','form','estados'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\servers  $servers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, servers $server)
    {
        //
        $form = $request->input('form');
        switch ($form) {
            case 1:
               /* $validator = Validator::make($request->all(), [
                    'cod_servicio' => 'required|unique:servers,cod_servicio|string|min:1|max:20',
                    'serie' => 'required|unique:servers,serie|string|min:1|max:25',
                ]);*/
                $validator = Validator::make($request->all(), [
                    'cod_servicio' => 'required|string|min:1|max:20',
                    'serie' => 'required|string|min:1|max:25',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
                }
                $server->update([
                    'id_marca' => $request->input('marca'),
                    'id_modelo' => $request->input('modelo'),
                    'cod_servicio' => $request->input('cod_servicio'),
                    'serie' => $request->input('serie'),
                    'estado' => $request->input('estado'),
                    'id_propietario' => $request->input('propietario'),
                    'id_responsable' => $request->input('responsable'),
                    'id_so' => $request->input('so'),
                ]);
                break;
            case 2:
                $validator = Validator::make($request->all(), [
                    'site' => 'required|string|min:1|max:30',
                    'rack' => 'required|string|min:1|max:30',
                    'und_inferior' => 'required|string|min:1|max:10',
                    'und_superior' => 'required|string|min:1|max:10',
                    'bahia' => 'required|string|min:1|max:10',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
                }
                $server->update([
                    'id_data_center' => $request->input('dataCenter'),
                    'site' => $request->input('site'),
                    'rack' => $request->input('rack'),
                    'unidad_inferior' => $request->input('und_inferior'),
                    'unidad_superior' => $request->input('und_superior'),
                    'bahia' => $request->input('bahia'),
                    'ip' => $request->input('ip'),
                    'observaciones' => $request->input('obs'),
                ]);
                break;
            case 3:
                $server->update([
                    'id_cliente' => $request->input('cliente'),
                    'id_tipo_cliente' => $request->input('tipoCliente'),
                    'fecha_Implementacion' => $request->input('fechaImplementacion'),
                    'fecha_Desistalacion' => $request->input('fechaDesistalacion'),
                    'correos' => $request->input('correos'),
                ]);
                break;
            case 4:
                $server->update([
                    'id_tipo_hardware' => $request->input('tipoHardware'),
                    'id_tipo_servicio' => $request->input('tipoServicio'),
                    'servicio_macro' => $request->input('segmento'),
                    'id_tipo_rack' => $request->input('tipoRack'),
                ]);
                break;
            case 5:
                $validator = Validator::make($request->all(), [
                    'tipoSoporte' => 'required|string|min:1|max:190',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
                }
                $server->update([
                    'tiene_soporte' => $request->input('tieneSoporte'),
                    'tipo_soporte' => $request->input('tipoSoporte'),
                    'soporte' => $request->input('fechaSoporte'),
                    'eos_date' => $request->input('eosDate'),
                    'eol_date' => $request->input('eolDate'),
                ]);
                break;
            case 6:
                $validator = Validator::make($request->all(), [
                    'fuentes' => 'required|integer',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
                }
                $server->update([
                    'id_controladora' => $request->input('controladora'),
                    'fuentes' => $request->input('fuentes'),
                    'id_raid' => $request->input('raid'),
                    'unidad_dvd' => $request->input('dvd'),
                ]);
                break;
            case 7:
                $validator = Validator::make($request->all(), [
                    'biosFW' => 'required|string|min:1|max:50',
                    'nicFW' => 'required|string|min:1|max:50',
                    'iloFW' => 'required|string|min:1|max:50',
                    'controladoraFW' => 'required|string|min:1|max:50',
                    'pmFW' => 'required|string|min:1|max:50',
                    'hbaFW' => 'required|string|min:1|max:50',
                    'oaFW' => 'required|string|min:1|max:50',
                    'vcSanFW' => 'required|string|min:1|max:50',
                    'vcLanFW' => 'required|string|min:1|max:50',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
                }
                $server->update([
                    'bios_firmware' => $request->input('biosFW'),
                    'nic_firmware' => $request->input('nicFW'),
                    'ilo_firmware' => $request->input('iloFW'),
                    'controladora_firmware' => $request->input('controladoraFW'),
                    'power_management_firmware' => $request->input('pmFW'),
                    'hba_firmware' => $request->input('hbaFW'),
                    'oa_firmware' => $request->input('oaFW'),
                    'vc_san' => $request->input('vcSanFW'),
                    'vc_lan' => $request->input('vcLanFW'),
                ]);
                break;
            case 8:
                $server->update([
                    'id_estado' => $request->input('serverEstado'),
                ]);
                break;
            case 9:
                # code...
                $validator = Validator::make($request->all(), [
                    'cod_servicio' => 'required|string|min:1|max:20',
                    'serie' => 'required|string|min:1|max:25',
                    'site' => 'required|string|min:1|max:30',
                    'rack' => 'required|string|min:1|max:30',
                    'und_inferior' => 'required|string|min:1|max:10',
                    'und_superior' => 'required|string|min:1|max:10',
                    'bahia' => 'required|string|min:1|max:10',
                    'tipoSoporte' => 'required|string|min:1|max:190',
                    'fuentes' => 'required|integer',
                    'biosFW' => 'required|string|min:1|max:50',
                    'nicFW' => 'required|string|min:1|max:50',
                    'iloFW' => 'required|string|min:1|max:50',
                    'controladoraFW' => 'required|string|min:1|max:50',
                    'pmFW' => 'required|string|min:1|max:50',
                    'hbaFW' => 'required|string|min:1|max:50',
                    'oaFW' => 'required|string|min:1|max:50',
                    'vcSanFW' => 'required|string|min:1|max:50',
                    'vcLanFW' => 'required|string|min:1|max:50',

                ]);
                if ($validator->fails()) {
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
                }
                $server->update([
                    'id_marca' => $request->input('marca'),
                    'id_modelo' => $request->input('modelo'),
                    'cod_servicio' => $request->input('cod_servicio'),
                    'serie' => $request->input('serie'),
                    'estado' => $request->input('estado'),
                    'id_propietario' => $request->input('propietario'),
                    'id_responsable' => $request->input('responsable'),
                    'id_so' => $request->input('so'),
                    'id_data_center' => $request->input('dataCenter'),
                    'site' => $request->input('site'),
                    'rack' => $request->input('rack'),
                    'unidad_inferior' => $request->input('und_inferior'),
                    'unidad_superior' => $request->input('und_superior'),
                    'bahia' => $request->input('bahia'),
                    'ip' => $request->input('ip'),
                    'observaciones' => $request->input('obs'),
                    'id_cliente' => $request->input('cliente'),
                    'id_tipo_cliente' => $request->input('tipoCliente'),
                    'fecha_Implementacion' => $request->input('fechaImplementacion'),
                    'fecha_Desistalacion' => $request->input('fechaDesistalacion'),
                    'correos' => $request->input('correos'),
                    'tiene_soporte' => $request->input('tieneSoporte'),
                    'tipo_soporte' => $request->input('tipoSoporte'),
                    'soporte' => $request->input('fechaSoporte'),
                    'eos_date' => $request->input('eosDate'),
                    'eol_date' => $request->input('eolDate'),
                    'id_controladora' => $request->input('controladora'),
                    'fuentes' => $request->input('fuentes'),
                    'id_raid' => $request->input('raid'),
                    'unidad_dvd' => $request->input('dvd'),
                    'bios_firmware' => $request->input('biosFW'),
                    'nic_firmware' => $request->input('nicFW'),
                    'ilo_firmware' => $request->input('iloFW'),
                    'controladora_firmware' => $request->input('controladoraFW'),
                    'power_management_firmware' => $request->input('pmFW'),
                    'hba_firmware' => $request->input('hbaFW'),
                    'oa_firmware' => $request->input('oaFW'),
                    'vc_san' => $request->input('vcSanFW'),
                    'vc_lan' => $request->input('vcLanFW'),
                    'id_estado' => $request->input('serverEstado'),

                    'id_tipo_hardware' => $request->input('tipoHardware'),
                    'id_tipo_servicio' => $request->input('tipoServicio'),
                    'servicio_macro' => $request->input('segmento'),
                    'id_tipo_rack' => $request->input('tipoRack'),

                ]);
                break;

        }
        return redirect()->route('servers.index')
            ->with('success','El servidor ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\servers  $servers
     * @return \Illuminate\Http\Response
     */
    public function destroy(servers $server)
    {
        //Con este metodo se realiza el softdelete de la base de datos
        $server->delete();
        return redirect()->route('servers.index')->with('success','La maquina quedo desistalada en el inventario');
    }
    public function search()
    {
        $modelos = server_modelos::with('marca')->orderBy('modelo')->get();
        $estados = server_estados::orderBy('nombre')->get();
        $clientes = clientes::orderBy('nombre')->get();
        //dd($clientes);
        return view('infrastructure.server.server.servers.search',compact('modelos','estados','clientes'));
    }
    public function result(Request $request)
    {
        $searchValue = $request->input('buscar');
        switch ($searchValue) {
            case '1':
                $servers = servers::where('cod_servicio','like',"%$request->cod_servicio%")->with([
                    'marca' => function($query){
                        $query->select('id','nombre');
                    },
                    'modelo' => function($query){
                        $query->select('id','modelo');
                    },
                    'dataCenter' => function($query){
                        $query->select('id','nombre');
                    },
                    'cliente' => function($query){
                        $query->select('id','nombre');
                    }
                ])->take(1000)->get(['id','cod_servicio','serie','site','rack','unidad_inferior','unidad_superior','bahia','id_modelo','id_marca','id_data_center','id_cliente']);
                break;
            case '2':
                $conteo = servers::where('id_estado',$request->input('serverEstado'))->count();
                $servers = servers::where('id_estado',$request->input('serverEstado'))->with([
                    'marca' => function($query){
                        $query->select('id','nombre');
                    },
                    'modelo' => function($query){
                        $query->select('id','modelo');
                    },
                    'dataCenter' => function($query){
                        $query->select('id','nombre');
                    },
                    'cliente' => function($query){
                        $query->select('id','nombre');
                    }
                ])->take(1000)->get(['id','cod_servicio','serie','site','rack','unidad_inferior','unidad_superior','bahia','id_modelo','id_marca','id_data_center','id_cliente']);
                break;
            case '3':
                $conteo = servers::where('id_modelo',$request->input('modelo'))->count();
                $servers = servers::where('id_modelo',$request->input('modelo'))->with([
                    'marca' => function($query){
                        $query->select('id','nombre');
                    },
                    'modelo' => function($query){
                        $query->select('id','modelo');
                    },
                    'dataCenter' => function($query){
                        $query->select('id','nombre');
                    },
                    'cliente' => function($query){
                        $query->select('id','nombre');
                    }
                ])->take(1000)->get(['id','cod_servicio','serie','site','rack','unidad_inferior','unidad_superior','bahia','id_modelo','id_marca','id_data_center','id_cliente']);
                break;
            case '4':
                $servers = servers::where('serie','like',"%$request->serie%")->with([

                    'marca' => function($query){
                        $query->select('id','nombre');
                    },
                    'modelo' => function($query){
                        $query->select('id','modelo');
                    },
                    'dataCenter' => function($query){
                        $query->select('id','nombre');
                    },
                    'cliente' => function($query){
                        $query->select('id','nombre');
                    }
                ])->take(1000)->get(['id','cod_servicio','serie','site','rack','unidad_inferior','unidad_superior','bahia','id_modelo','id_marca','id_data_center','id_cliente']);
                break;
            case '5':
                $conteo = servers::where('id_cliente',$request->input('cliente'))->count();
                $servers = servers::where('id_cliente',$request->input('cliente'))->with([
                    'marca' => function($query){
                        $query->select('id','nombre');
                    },
                    'modelo' => function($query){
                        $query->select('id','modelo');
                    },
                    'dataCenter' => function($query){
                        $query->select('id','nombre');
                    },
                    'cliente' => function($query){
                        $query->select('id','nombre');
                    }
                ])->get(['id','cod_servicio','serie','site','rack','unidad_inferior','unidad_superior','bahia','id_modelo','id_marca','id_data_center','id_cliente']);
                break;
        }
        if(isset($conteo) && $conteo > 1000){
            $error = 'La búsqueda contiene '.$conteo.' resultados, solo se mostraran 1.000 en esta vista, para obtener todos los resultados por favor ingrese al modulo de exportar';
            return view('infrastructure.server.server.servers.result',compact('servers','error'));
        }else{
            return view('infrastructure.server.server.servers.result',compact('servers'));
        }

    }
}
