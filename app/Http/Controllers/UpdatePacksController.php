<?php

namespace App\Http\Controllers;


use App\update_packs;
use App\server_modelos;
use App\servers;
use App\clientes;
use App\server_marcas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection as Collection;
use App\Http\Traits\ConnectionTrait;




class UpdatePacksController extends Controller
{
    Use ConnectionTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $paquetes = update_packs::with('modelo')->get();
        return view('infrastructure.server.server.updatePacks.index', compact('paquetes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $modelos = server_modelos::with('marca')->orderBy('modelo')->get();
        return view('infrastructure.server.server.updatePacks.create', compact('modelos'));
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
            'nombre' => 'required|string|min:1|max:30',
            'biosFW' => 'required|string|min:1|max:30',
            'nicFW' => 'required|string|min:1|max:30',
            'iloFW' => 'required|string|min:1|max:30',
            'controladoraFW' => 'required|string|min:1|max:30',
            'pmFW' => 'required|string|min:1|max:30',
            'hbaFW' => 'required|string|min:1|max:30',
            'oaFW' => 'required|string|min:1|max:30',
            'vcSanFW' => 'required|string|min:1|max:30',
            'vcLanFW' => 'required|string|min:1|max:30',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $modelo = server_modelos::where('id', $request->input('modelo'))->first();
        $new= update_packs::create([
            'id_marca' => $modelo->marca->id,
            'id_modelo' => $request->input('modelo'),
            'nombre' => $request->input('nombre'),
            'vigente' => true,
            'bios_fw' => $request->input('biosFW'),
            'nic_fw' => $request->input('nicFW'),
            'ilo_fw' => $request->input('iloFW'),
            'controladora_fw' => $request->input('controladoraFW'),
            'power_management_fw' => $request->input('pmFW'),
            'hba_fw' => $request->input('hbaFW'),
            'oa_fw' => $request->input('oaFW'),
            'vc_san_fw' => $request->input('vcSanFW'),
            'vc_lan_fw' => $request->input('vcLanFW'),
        ]);

        update_packs::where('id_modelo',$new->id_modelo)->where('id', '!=', $new->id)->update([
            'vigente' => false,
        ]);
        $this->resourcesLog('Create-UpdatePack');
        return redirect()->route('updatePacks.index')
            ->with('success','El paquete de actualización ha sido creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\update_packs  $update_packs
     * @return \Illuminate\Http\Response
     */
    public function show(update_packs $updatePack)
    {
        //
        return view('infrastructure.server.server.updatePacks.show',compact('updatePack'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\update_packs  $update_packs
     * @return \Illuminate\Http\Response
     */
    public function edit(update_packs $updatePack)
    {
        //
        $modelos = server_modelos::with('marca')->orderBy('modelo')->get();
        return view('infrastructure.server.server.updatePacks.edit', compact('modelos','updatePack'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\update_packs  $update_packs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, update_packs $updatePack)
    {
        //
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|min:1|max:30',
            'biosFW' => 'required|string|min:1|max:30',
            'nicFW' => 'required|string|min:1|max:30',
            'iloFW' => 'required|string|min:1|max:30',
            'controladoraFW' => 'required|string|min:1|max:30',
            'pmFW' => 'required|string|min:1|max:30',
            'hbaFW' => 'required|string|min:1|max:30',
            'oaFW' => 'required|string|min:1|max:30',
            'vcSanFW' => 'required|string|min:1|max:30',
            'vcLanFW' => 'required|string|min:1|max:30',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $modelo = server_modelos::where('id', $request->input('modelo'))->first();
        $updatePack->update([
            'id_marca' => $modelo->marca->id,
            'id_modelo' => $request->input('modelo'),
            'nombre' => $request->input('nombre'),
            'bios_fw' => $request->input('biosFW'),
            'nic_fw' => $request->input('nicFW'),
            'ilo_fw' => $request->input('iloFW'),
            'controladora_fw' => $request->input('controladoraFW'),
            'power_management_fw' => $request->input('pmFW'),
            'hba_fw' => $request->input('hbaFW'),
            'oa_fw' => $request->input('oaFW'),
            'vc_san_fw' => $request->input('vcSanFW'),
            'vc_lan_fw' => $request->input('vcLanFW'),
        ]);
        $this->resourcesLog('Update-UpdatePack');
        return redirect()->route('updatePacks.index')
            ->with('success','El paquete de actualización ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\update_packs  $update_packs
     * @return \Illuminate\Http\Response
     */
    public function destroy(update_packs $updatePack)
    {
        //
        $updatePack->delete();
        $this->resourcesLog('Delete-UpdatePack');
        return redirect()->route('updatePacks.index')
            ->with('error','El paquete de actualización ha sido eliminado con éxito');
    }
    public function search()
    {
        $modelos = server_modelos::with('marca')->whereIn('id',update_packs::get('id_modelo'))->orderBy('modelo')->get();
        //$modelos = server_modelos::with('marca')->orderBy('modelo')->get();
        $clientes = clientes::orderBy('nombre')->get();
        $fabricantes = server_marcas::orderBy('nombre')->get();
        //$total = Server::orderBy('estado')->get();
        $total = servers::all();
        //dd($total);
        return view('infrastructure.server.server.updatePacks.search',compact('modelos', 'clientes', 'fabricantes','total'));
    }
    public function result(Request $request)
    {
        $searchValue = $request->input('buscar');
        switch ($searchValue) {
            case '1':
                $conteo = servers::where('cod_servicio',$request->input('cod_servicio'))->count();
                //$cruce = UpdatePack::where('cod_servicio',$request->input('cod_servicio'))->count();
                //Busqueda sin like
                // $server = Server::where('cod_servicio',$request->input('cod_servicio'))->with
                $server = servers::where('cod_servicio','like',"%$request->cod_servicio%")->with([
                    'marca' => function($query){
                        $query->select('id','nombre');
                    },
                    'modelo' => function($query){
                        $query->select('id','modelo');
                    }
                ])->first(['id','cod_servicio','id_modelo','id_marca','bios_firmware','nic_firmware','ilo_firmware','controladora_firmware','power_management_firmware','hba_firmware','oa_firmware','vc_san','vc_lan']);
                $hasUpdatePack =  update_packs::where('id_modelo',$server->id_modelo)->where('vigente',true)->count();
                $updatePack =  update_packs::where('id_modelo',$server->id_modelo)->where('vigente',true)->first();
                $servers = Collection::make();
                $servers->push($server);
                //dd($servers);
                if ($hasUpdatePack != 0) {
                    # code...
                    $pendientes = $this->getOutOfDateServer($servers, $updatePack);
                }
                break;
            case '2':
                $conteo = servers::where('id_marca',$request->input('fabricante'))->count();
                //$cruce = UpdatePack::where('id_modelo',$request->input('modelo'))->count();
                //dd($conteo);
                //dd($request->input('fabricante'));
                //$server = servers::where('id_marca',$request->input('fabricante'))->get(['id','cod_servicio','id_modelo','id_marca','bios_firmware','nic_firmware','ilo_firmware','controladora_firmware','power_management_firmware','hba_firmware','oa_firmware','vc_san','vc_lan']);

                $server = servers::where('id_marca',$request->input('fabricante'))->latest()->with([
                    'marca' => function($query){
                        $query->select('id','nombre');
                    },
                    'modelo' => function($query){
                        $query->select('id','modelo');
                    }

                ])->first(['id','cod_servicio','id_modelo','id_marca','bios_firmware','nic_firmware','ilo_firmware','controladora_firmware','power_management_firmware','hba_firmware','oa_firmware','vc_san','vc_lan']);
                //->first(['id','cod_servicio','id_modelo','id_marca','bios_firmware','nic_firmware','ilo_firmware','controladora_firmware','power_management_firmware','hba_firmware','oa_firmware','vc_san','vc_lan']);
                //dd($server);
                $hasUpdatePack =  update_packs::where('id_marca',$server->id_marca)->where('vigente',true)->count();
                //dd($hasUpdatePack);
                $updatePack =  update_packs::where('id_marca',$server->id_marca)->where('vigente',true)->first();
                //dd($updatePack);
                $servers = Collection::make();
                //dd($servers);
                $servers->push($server);
                //$servers->dd();
                //$pendientes = $this->getOutOfDateServer($servers);
                //dd($servers);

                if ($hasUpdatePack != 0) {
                    # code...
                    $pendientes = $this->getOutOfDateServer($servers, $updatePack);
                    //dd($pendientes);
                }


                break;
            case '3':
                $conteo = servers::where('id_modelo',$request->input('modelo'))->count();
                //$cruce = UpdatePack::where('id_modelo',$request->input('modelo'))->count();
                $servers = servers::where('id_modelo',$request->input('modelo'))->with([
                    'marca' => function($query){
                        $query->select('id','nombre');
                    },
                    'modelo' => function($query){
                        $query->select('id','modelo');
                    }
                ])->take(1000)->get(['id','cod_servicio','id_modelo','id_marca','bios_firmware','nic_firmware','ilo_firmware','controladora_firmware','power_management_firmware','hba_firmware','oa_firmware','vc_san','vc_lan']);
                $hasUpdatePack =  update_packs::where('id_modelo',$request->input('modelo'))->where('vigente',true)->count();
                $updatePack =  update_packs::where('id_modelo',$request->input('modelo'))->where('vigente',true)->first();
                if ($hasUpdatePack != 0) {
                    # code...
                    $pendientes = $this->getOutOfDateServer($servers, $updatePack);
                }
                break;
            case '4':
                $conteo = servers::where('serie',$request->input('serie'))->count();
                //$cruce = UpdatePack::where('serie',$request->input('serie'))->count();
                //Busqueda sin like
                //$server = Server::where('serie',$request->input('serie'))->with
                $server = servers::where('serie','like',"%$request->serie%")->with([
                    'marca' => function($query){
                        $query->select('id','nombre');
                    },
                    'modelo' => function($query){
                        $query->select('id','modelo');
                    }
                ])->first(['id','cod_servicio','id_modelo','id_marca','bios_firmware','nic_firmware','ilo_firmware','controladora_firmware','power_management_firmware','hba_firmware','oa_firmware','vc_san','vc_lan']);
                $hasUpdatePack =  update_packs::where('id_modelo',$server->id_modelo)->where('vigente',true)->count();
                $updatePack =  update_packs::where('id_modelo',$server->id_modelo)->where('vigente',true)->first();
                $servers = Collection::make();
                $servers->push($server);
                if ($hasUpdatePack != 0) {
                    # code...
                    $pendientes = $this->getOutOfDateServer($servers, $updatePack);
                }
                break;
            case '5':
                $conteo = servers::where('id_cliente',$request->input('cliente'))->count();
                //Server::where('id_cliente',$request->input('cliente'))->count()
                //$cruce = UpdatePack::where('serie',$request->input('serie'))->count();
                $server = servers::where('id_cliente',$request->input('cliente'))->with([
                    'marca' => function($query){
                        $query->select('id','nombre');
                    },
                    'modelo' => function($query){
                        $query->select('id','modelo');
                    }
                ])->first(['id','cod_servicio','id_modelo','id_marca','bios_firmware','nic_firmware','ilo_firmware','controladora_firmware','power_management_firmware','hba_firmware','oa_firmware','vc_san','vc_lan','id_cliente']);
                $hasUpdatePack =  update_packs::where('id_modelo',$server->id_modelo)->where('vigente',true)->count();
                $updatePack =  update_packs::where('id_modelo',$server->id_modelo)->where('vigente',true)->first();
                $servers = Collection::make();
                $servers->push($server);
                //dd($servers);
                if ($hasUpdatePack != 0) {
                    # code...
                    $pendientes = $this->getOutOfDateServer($servers, $updatePack);
                }
                break;
            case '6':
                # code...
                //$conteo = Server::orderBy('id')->count();
                $conteo = servers::all()->count();
                //$cruce = UpdatePack::where('id_modelo',$request->input('modelo'))->count();
                //$server = Server::all(['id','cod_servicio','id_modelo','id_marca','bios_firmware','nic_firmware','ilo_firmware','controladora_firmware','power_management_firmware','hba_firmware','oa_firmware','vc_san','vc_lan']);
                //dd($conteo);
                //$server = Server::get()->count();

                $servers = servers::where('id_modelo',$request->input('servidores'))->with([
                    'marca' => function($query){
                        $query->select('id','nombre');
                    },
                    'modelo' => function($query){
                        $query->select('id','modelo');
                    }
                ])->take(1000)->get(['id','cod_servicio','id_modelo','id_marca','bios_firmware','nic_firmware','ilo_firmware','controladora_firmware','power_management_firmware','hba_firmware','oa_firmware','vc_san','vc_lan']);
                $hasUpdatePack =  update_packs::where('id_modelo',$request->input('servidores'))->where('vigente',true)->count();
                $updatePack =  update_packs::where('id_modelo',$request->input('servidores'))->where('vigente',true)->first();

                //dd($servers);
                if ($hasUpdatePack != 0) {
                    # code...
                    $pendientes = $this->getOutOfDateServer($servers, $updatePack);
                }
                break;
        }
        //dd($hasUpdatePack);
        if ($hasUpdatePack != 0) {
            # code...
            if($conteo && $conteo > 1000){
                $error = 'La búsqueda contiene '.$conteo.' resultados, solo se mostraran 1.000 en esta vista, para obtener todos los resultados por favor ingrese al modulo de exportar';
                return view('infrastructure.server.server.updatePacks.result',compact('pendientes','hasUpdatePack','error'));
            }else{
                return view('infrastructure.server.server.updatePacks.result',compact('pendientes','hasUpdatePack'));
            }
        } else {
            # code...
            $error = 'El modelo del servidor actual no tiene paquetes de actualizacion disponibles';
            return view('infrastructure.server.server.updatePacks.result',compact('hasUpdatePack','error'));
        }
        //dd($pendientes);
    }
    private function getOutOfDateServer($servers, $updatePack)
    {
        $flag = array();
        $pendientes = Collection::make();
        foreach($servers as $server){
            $servidor['id'] = $server->id;
            $servidor['cod_servicio'] = $server->cod_servicio;
            $servidor['marca'] = $server->marca->nombre;
            $servidor['modelo'] = $server->modelo->modelo.' - '.$server->modelo->generación;
            //dd($server);
            //$servidor['generacion'] = $server->modelo->generacion;
            if($server->bios_firmware == $updatePack->bios_fw){
                $servidor['bios']=1;
                array_push($flag,0);
            }else{
                $servidor['bios'] = 0;
                array_push($flag,1);
            }
            if($server->nic_firmware == $updatePack->nic_fw){
                $servidor['nic']=1;
                array_push($flag,0);
            }else{
                $servidor['nic'] = 0;
                array_push($flag,1);
            }
            if($server->ilo_firmware == $updatePack->ilo_fw){
                $servidor['ilo']=1;
                array_push($flag,0);
            }else{
                $servidor['ilo'] = 0;
                array_push($flag,1);
            }
            if($server->controladora_firmware == $updatePack->controladora_fw){
                $servidor['controladora']=1;
                array_push($flag,0);
            }else{
                $servidor['controladora'] = 0;
                array_push($flag,1);
            }
            if($server->power_management_firmware == $updatePack->power_management_fw){
                $servidor['power_management']=1;
                array_push($flag,0);
            }else{
                $servidor['power_management'] = 0;
                array_push($flag,1);
            }
            if($server->hba_firmware == $updatePack->hba_fw){
                $servidor['hba']=1;
                array_push($flag,0);
            }else{
                $servidor['hba'] = 0;
                array_push($flag,1);
            }
            if($server->oa_firmware == $updatePack->oa_fw){
                $servidor['oa']=1;
                array_push($flag,0);
            }else{
                $servidor['oa'] = 0;
                array_push($flag,1);
            }
            if($server->vc_lan == $updatePack->vc_lan_fw){
                $servidor['vc_lan']=1;
                array_push($flag,0);
            }else{
                $servidor['vc_lan'] = 0;
                array_push($flag,1);
            }
            if($server->vc_san == $updatePack->vc_san_fw){
                $servidor['vc_san']=1;
                array_push($flag,0);
            }else{
                $servidor['vc_san'] = 0;
                array_push($flag,1);
            }
            //dd(array_sum($flag));
            //dd($servidor);
            if(array_sum($flag)>=1){
                $pendientes->push((object) $servidor);
            }
        }
        //dd($pendientes);
        return $pendientes;
    }
}
