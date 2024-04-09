<?php

namespace App\Http\Controllers;

use App\update_logs;
use App\update_packs;
use App\servers;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;
use App\Http\Traits\ConnectionTrait;

class UpdateLogsController extends Controller
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
        $logs = update_logs::with([
            'server' => function($query){
                $query->select('id','cod_servicio','id_marca','id_modelo','serie');
            },
            'updatePack' => function($query){
                $query->select('id','nombre');
            },
            'user' => function($query){
                $query->select('id','name');
            }
        ])->latest()->take(500)->get(['id','id_server','id_user','id_update_pack','created_at','cambio']);

        return view('infrastructure.server.server.servers.updatelogs.index',compact('logs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(servers $server)
    {
        //
        $updatePack =  update_packs::where('id_modelo',$server->id_modelo)->where('vigente',true)->first();
        return view('infrastructure.server.server.updatePacks.sync',compact('server','updatePack'));
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
        $server = servers::find($request->input('servidor'));
        $updatePack = update_packs::find($request->input('update'));
        //dd($request->input('cambio'));

        //$updateLog = UpdateLog::all();
        //$updateLog = UpdateLog::with('cambio')->first();

        $log = [
            'bios' => $server->bios_firmware,
            'ilo' => $server->ilo_firmware,
            'controladora' => $server->controladora_firmware,
            'pm' => $server->power_management_firmware,
            'nic' => $server->nic_firmware,
            'hba' => $server->hba_firmware,
            //'cambio' => $updateLog->cambio,
            'oa' => $server->oa_firmware,
            'vc_lan' => $server->vc_lan,
            'vc_san' => $server->vc_san,
        ];
        $log_old = $log;
        $log_new = update_logs::create([
            'bios_fw_old' => 'N/A',
            'bios_fw_new' => 'N/A',
            'ilo_fw_old' => 'N/A',
            'ilo_fw_new' => 'N/A',
            'controladora_fw_old' => 'N/A',
            'controladora_fw_new' => 'N/A',
            'pm_fw_old' => 'N/A',
            'pm_fw_new' => 'N/A',
            'nic_fw_old' => 'N/A',
            'nic_fw_new' => 'N/A',
            'hba_fw_old' => 'N/A',
            'hba_fw_new' => 'N/A',
            'oa_fw_old' => 'N/A',
            'oa_fw_new' => 'N/A',
            'vc_lan_fw_old' => 'N/A',
            'vc_lan_fw_new' => 'N/A',
            'vc_san_fw_old' => 'N/A',
            'vc_san_fw_new' => 'N/A',
            'cambio' => $request->input('cambio'),
            'id_server' => $server->id,
            'id_update_pack' => $updatePack->id,
            'id_user' => Auth::user()->id,
        ]);
        //$this->getExternalToolLog('LogsUpdateFirmware');
        foreach($request->input('componentes') as $componente){
            switch ($componente) {
                case 'bios':
                    $log_new->update([
                        'bios_fw_old' => $log_old['bios'],
                        'bios_fw_new' => $updatePack->bios_fw
                    ]);
                    $log['bios'] = $updatePack->bios_fw;
                    break;
                case 'ilo':
                    $log_new->update([
                        'ilo_fw_old' => $log_old['ilo'],
                        'ilo_fw_new' => $updatePack->ilo_fw
                    ]);
                    $log['ilo'] = $updatePack->ilo_fw;
                    break;
                case 'controladora':
                    $log_new->update([
                        'controladora_fw_old' => $log_old['controladora'],
                        'controladora_fw_new' => $updatePack->controladora_fw
                    ]);
                    $log['controladora'] = $updatePack->controladora_fw;
                    break;
                case 'pm':
                    $log_new->update([
                        'pm_fw_old' => $log_old['pm'],
                        'pm_fw_new' => $updatePack->power_management_fw
                    ]);
                    $log['pm'] = $updatePack->power_management_fw;
                    break;
                case 'nic':
                    $log_new->update([
                        'nic_fw_old' => $log_old['nic'],
                        'nic_fw_new' => $updatePack->nic_fw
                    ]);
                    $log['nic'] = $updatePack->nic_fw;
                    break;
                case 'hba':
                    $log_new->update([
                        'hba_fw_old' => $log_old['hba'],
                        'hba_fw_new' => $updatePack->hba_fw
                    ]);
                    $log['hba'] = $updatePack->hba_fw;
                    break;
                case 'oa':
                    $log_new->update([
                        'oa_fw_old' => $log_old['oa'],
                        'oa_fw_new' => $updatePack->oa_fw
                    ]);
                    $log['oa'] = $updatePack->oa_fw;
                    break;
                case 'vc_lan':
                    $log_new->update([
                        'vc_lan_fw_old' => $log_old['vc_lan'],
                        'vc_lan_fw_new' => $updatePack->vc_lan_fw
                    ]);
                    $log['vc_lan'] = $updatePack->vc_lan_fw;
                    break;
                case 'vc_san':
                    $log_new->update([
                        'vc_san_fw_old' => $log_old['vc_san'],
                        'vc_san_fw_new' => $updatePack->vc_san_fw
                    ]);
                    $log['vc_san'] = $updatePack->vc_san_fw;
                    break;
                /*
                case 'cambio':
                    $log_new->update([
                        'cambio_old' => $log_old['cambio'],
                        'cambio_new' => $updateLog->cambio
                    ]);
                    $log['cambio'] = $updateLog->cambio;
                    break;*/

            }
        }
        $server->update([
            'bios_firmware' => $log['bios'],
            'ilo_firmware' => $log['ilo'],
            'controladora_firmware' => $log['controladora'],
            'power_management_firmware' => $log['pm'],
            'nic_firmware' => $log['nic'],
            'hba_firmware' => $log['hba'],
            'oa_firmware' => $log['oa'],
            'vc_lan' => $log['vc_lan'],
            'vc_san' => $log['vc_san'],
            //'cambio' => $log['cambio'],
        ]);
        //dd($log_new);
        $this->resourcesLog('LogsUpdateFirmware');
        return redirect()->route('updatePacks.search')
            ->with('success', 'Actualizaciones cargadas con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\update_logs  $update_logs
     * @return \Illuminate\Http\Response
     */
    public function show(update_logs $updateLog)
    {
        //
        return view('infrastructure.server.server.servers.updatelogs.show', compact('updateLog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\update_logs  $update_logs
     * @return \Illuminate\Http\Response
     */
    public function edit(update_logs $update_logs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\update_logs  $update_logs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, update_logs $update_logs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\update_logs  $update_logs
     * @return \Illuminate\Http\Response
     */
    public function destroy(update_logs $update_logs)
    {
        //
    }
    public function logsByServer(servers $server)
    {
        $logs = update_logs::where('id_server',$server->id)->with([
            'server' => function($query){
                $query->select('id','cod_servicio','id_marca','id_modelo','serie');
            },
            'updatePack' => function($query){
                $query->select('id','nombre');
            },
            'user' => function($query){
                $query->select('id','name');
            }
        ])->get(['id','id_server','id_user','id_update_pack','created_at','cambio']);
        $this->resourcesLog('UpdateFirmware');
        return view('infrastructure.server.server.servers.updatelogs.index',compact('logs','server'));
    }
    public function view(servers $server, update_logs $updateLog)
    {
        //dd($server, $updateLog);
        return view('infrastructure.server.server.servers.updatelogs.show', compact('server','updateLog'));
    }
}
