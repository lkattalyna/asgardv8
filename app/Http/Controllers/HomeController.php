<?php

namespace App\Http\Controllers;

use App\Inventory;
use App\AwxTemplate;
use App\VirtualHost;
use App\ExecutionLog;
use App\ExternalToolLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{


    public function indexPremium(){



        $max_logs_prem = null;
        $max_logs_soporte = null;
        $logs_premium = 0;
        $porcentajes = array('correctas' => 0, 'erróneas' => 0,'pendientes' => 0);
        $porcentajes_au = array('correctas' => 0, 'erróneas' => 0,'pendientes' => 0);
        $ejecuciones = array('correctas' => 0, 'erróneas' => 0,'pendientes' => 0);
        // if( strpos(Auth::user()->group,'GRP-ASG-PREM') !== false)
        // if( strpos(Auth::user()->group,'GRP-ASG-Soporte-DC') !== false )
        $logs_premium = ExecutionLog::where('id_user', '!=', 1)->where('user_group','like','%PREM%')->count();
        $filter_logs_premium = ExecutionLog::select(DB::raw('count(*) as cantidad, status'))->where('id_user', '!=', 1)->where('user_group','like','%PREM%')->groupBy('status')->get();
        $max_logs_prem = ExecutionLog::select(DB::raw('count(*) as cantidad, playbook'))->where('id_user', '!=', 1)->where('user_group','like','%PREM%')->groupBy('playbook')->orderBy('cantidad','DESC')->take(8)->get();

        if($logs_premium > 0){
            $ok=0;
            $fail = 0;
            $not_yet = 0;
            foreach($filter_logs_premium as $filter_log){
                if($filter_log->status >= 1 && $filter_log->status <= 9 ){
                    $ok = $ok+$filter_log->cantidad;
                }elseif($filter_log->status >= 11 && $filter_log->status <= 19 ){
                    $fail = $fail+$filter_log->cantidad;
                }elseif($filter_log->status == 0){
                    $not_yet = $not_yet+$filter_log->cantidad;
                }
            }
            $porcentajes = array('correctas' => $this->getPercent($ok,$logs_premium), 'erróneas' => $this->getPercent($fail,$logs_premium),'pendientes' => $this->getPercent($not_yet,$logs_premium));
            $ejecuciones = array('correctas' => $ok, 'erróneas' => $fail,'pendientes' => $not_yet);
        }



        $logs_soporte = ExecutionLog::where('id_user', '!=', 1)->where('user_group','like','%Soporte-DC%')->count();
        $filter_logs_soporte = ExecutionLog::select(DB::raw('count(*) as cantidad, status'))->where('id_user', '!=', 1)->where('user_group','like','%Soporte-DC%')->groupBy('status')->get();
        $max_logs_soporte = ExecutionLog::select(DB::raw('count(*) as cantidad, playbook'))->where('id_user', '!=', 1)->where('user_group','like','%Soporte-DC%')->groupBy('playbook')->orderBy('cantidad','DESC')->take(8)->get();


        if($logs_soporte > 0){
            $ok=0;
            $fail = 0;
            $not_yet = 0;
            foreach($filter_logs_soporte as $filter_log){
                if($filter_log->status >= 1 && $filter_log->status <= 9 ){
                    $ok = $ok+$filter_log->cantidad;
                }elseif($filter_log->status >= 11 && $filter_log->status <= 19 ){
                    $fail = $fail+$filter_log->cantidad;
                }elseif($filter_log->status == 0){
                    $not_yet = $not_yet+$filter_log->cantidad;
                }
            }
            $porcentajes_au = array('correctas' => $this->getPercent($ok,$logs_soporte), 'erróneas' => $this->getPercent($fail,$logs_soporte),'pendientes' => $this->getPercent($not_yet,$logs_soporte));
            $ejecuciones_au = array('correctas' => $ok, 'erróneas' => $fail,'pendientes' => $not_yet);
        }
        $backpack = compact(
            'max_logs_prem',
            'max_logs_soporte',
            'porcentajes',
            'porcentajes_au',
            'ejecuciones',
            'ejecuciones_au',
            'logs_premium',
            'logs_soporte'
        );


        return view('homePremium',$backpack);
    }

    public  function index()
    {
        $servers = Inventory::count();
        $vservers = VirtualHost::count();
        $awxTemplates = AwxTemplate::count();
        $externalTools = ExternalToolLog::distinct('job_script')->count();
        // $grupos = explode(";",Auth::user()->group);
        // $newGrupo = "GRP-ASG-Admin-UNIXEN;GRP-ASG-Admin-Master;GRP-ASG-Admin-VIRTUALIZACION;GRP-ASG-Admin-WINPHGRP-ASG-Admin-UNIXEN;GRP-ASG-Admin-Master;GRP-ASG-Admin-VIRTUALIZACION;GRP-ASG-Admin-WINPHGRP-ASG-Admin-UNIXEN;GRP-ASG-Admin-Master;GRP-ASG-Admin-VIRTUALIZACION;GRP-ASG-Admin-WINPHGRP-ASG-Admin-UNIXEN;GRP-ASG-Admin-Master;GRP-ASG-Admin-VIRTUALIZACION;GRP-ASG-Admin-WINPHGRP-ASG-Admin-UNIXEN;GRP-ASG-Admin-Master;GRP-ASG-Admin-VIRTUALIZACION;GRP-ASG-Admin-WINPHGRP-ASG-Admin-UNIXEN;GRP-ASG-Admin-Master;GRP-ASG-Admin-VIRTUALIZACION;GRP-ASG-Admin-WINPHGRP-ASG-Admin-UNIXEN;GRP-ASG-Admin-Master;GRP-ASG-Admin-VIRTUALIZACION;GRP-ASG-Admin-WINPHGRP-ASG-Admin-UNIXEN;GRP-ASG-Admin-Master;GRP-ASG-Admin-VIRTUALIZACION;GRP-ASG-Admin-WINPH;GRP-ASG-Admin-UNIXEN;GRP-ASG-Admin-Master;GRP-ASG-Admin-VIRTUALIZACION;GRP-ASG-Admin-WINPHGRP-ASG-Admin-UNIXEN;GRP-ASG-Admin-Master;GRP-ASG-Admin-VIRTUALIZACION;GRP-ASG-Admin-WINPHGRP-ASG-Admin-UNIXEN;GRP-ASG-Admin-Master;GRP-ASG-Admin-VIRTUALIZACION;GRP-ASG-Admin-WINPHGRP-ASG-Admin-UNIXEN;GRP-ASG-Admin-Master;GRP-ASG-Admin-VIRTUALIZACION;GRP-ASG-Admin-WINPHGRP-ASG-Admin-UNIXEN;GRP-ASG-Admin-Master;GRP-ASG-Admin-VIRTUALIZACION;GRP-ASG-Admin-WINPHGRP-ASG-Admin-UNIXEN;GRP-ASG-Admin-Master;GRP-ASG-Admin-VIRTUALIZACION;GRP-ASG-Admin-WINPHGRP-ASG-Admin-UNIXEN;GRP-ASG-Admin-Master;GRP-ASG-Admin-VIRTUALIZACION;GRP-ASG-Admin-WINPHGRP-ASG-Admin-UNIXEN;GRP-ASG-Admin-Master;GRP-ASG-Admin-VIRTUALIZACION;GRP-ASG-Admin-WINPH";
        // Auth::user()->group = $newGrupo;
        // Auth::user()->save();
        // dd(Auth::user());

        $porcentajes_au = array('correctas' => 0, 'erróneas' => 0,'pendientes' => 0);
        $porcentajes = array('correctas' => 0, 'erróneas' => 0,'pendientes' => 0);
        $ejecuciones_au = array('correctas' => 0, 'erróneas' => 0,'pendientes' => 0);
        $ejecuciones = array('correctas' => 0, 'erróneas' => 0,'pendientes' => 0);

        // if(Auth::user()->group == 'GRP-ASG-Admin-Master' || Auth::user()->group =='GRP-ASG-DES' || Auth::user()->group =='GRP-ASG-Cord-PAAS'
        //     || Auth::user()->group =='GRP-ASG-Cord-IAAS' || Auth::user()->group == 'GRP-ASG-Gte-IAAS-PASS'){


        // if( in_array('GRP-ASG-Admin-Master',$grupos) || in_array('GRP-ASG-DES',$grupos) ||
        //     in_array('GRP-ASG-Cord-PAAS',$grupos) || in_array('GRP-ASG-Cord-IAAS',$grupos) ||
        //     in_array('GRP-ASG-Gte-IAAS-PASS',$grupos)
        // ){

            // dd(strpos(Auth::user()->group,'GRP-ASG-Admin-Master'));
        if( strpos(Auth::user()->group,'GRP-ASG-Admin-Master') !== false ||
            strpos(Auth::user()->group,'GRP-ASG-DES') !== false ||
            strpos(Auth::user()->group,'GRP-ASG-Cord-PAAS') !== false ||
            strpos(Auth::user()->group,'GRP-ASG-Cord-IAAS') !== false ||
            strpos(Auth::user()->group,'GRP-ASG-Gte-IAAS-PASS') !== false
        ){
            $logs = ExecutionLog::where('id_user', '!=', 1)->count();
            $filter_logs = ExecutionLog::select(DB::raw('count(*) as cantidad, status'))->where('id_user', '!=', 1)->groupBy('status')->get();
            $max_logs = ExecutionLog::select(DB::raw('count(*) as cantidad, playbook'))->where('id_user', '!=', 1)->groupBy('playbook')->orderBy('cantidad','DESC')->take(8)->get();
            $logs_au = ExecutionLog::where('id_user', 1)->count();
            $filter_logs_au = ExecutionLog::select(DB::raw('count(*) as cantidad, status'))->where('id_user', 1)->groupBy('status')->get();
            $max_logs_au = ExecutionLog::select(DB::raw('count(*) as cantidad, playbook'))->where('id_user', 1)->groupBy('playbook')->orderBy('cantidad','DESC')->take(8)->get();
        }else{
            $logs = ExecutionLog::where('user_group',Auth::user()->group)->where('id_user', '!=', 1)->count();
            $filter_logs = ExecutionLog::select(DB::raw('count(*) as cantidad, status'))->where('user_group',Auth::user()->group)->where('id_user', '!=', 1)->groupBy('status')->get();
            $max_logs = ExecutionLog::select(DB::raw('count(*) as cantidad, playbook'))->where('user_group',Auth::user()->group)->where('id_user', '!=', 1)->groupBy('playbook')
            ->orderBy('cantidad','DESC')->take(8)->get();
            $logs_au = ExecutionLog::where('user_group',Auth::user()->group)->where('id_user', 1)->count();
            $filter_logs_au = ExecutionLog::select(DB::raw('count(*) as cantidad, status'))->where('user_group',Auth::user()->group)->where('id_user', 1)->groupBy('status')->get();
            $max_logs_au = ExecutionLog::select(DB::raw('count(*) as cantidad, playbook'))->where('user_group',Auth::user()->group)->where('id_user', 1)->groupBy('playbook')
            ->orderBy('cantidad','DESC')->take(8)->get();
        }
        if($logs > 0){
            $ok=0;
            $fail = 0;
            $not_yet = 0;
            foreach($filter_logs as $filter_log){
                if($filter_log->status >= 1 && $filter_log->status <= 9 ){
                    $ok = $ok+$filter_log->cantidad;
                }elseif($filter_log->status >= 11 && $filter_log->status <= 19 ){
                    $fail = $fail+$filter_log->cantidad;
                }elseif($filter_log->status == 0){
                    $not_yet = $not_yet+$filter_log->cantidad;
                }
            }
            $porcentajes = array('correctas' => $this->getPercent($ok,$logs), 'erróneas' => $this->getPercent($fail,$logs),'pendientes' => $this->getPercent($not_yet,$logs));
            $ejecuciones = array('correctas' => $ok, 'erróneas' => $fail,'pendientes' => $not_yet);

        }
        // else{
        //     $porcentajes = null;
        //     $ejecuciones = null;
        //     $max_logs = null;
        // }
        if($logs_au > 0){
            $ok_au=0;
            $fail_au = 0;
            $not_yet_au = 0;
            foreach($filter_logs_au as $filter_log_au){
                if($filter_log_au->status >= 1 && $filter_log_au->status <= 9 ){
                    $ok_au = $ok_au+$filter_log_au->cantidad;
                }elseif($filter_log_au->status >= 11 && $filter_log_au->status <= 19 ){
                    $fail_au = $fail_au+$filter_log_au->cantidad;
                }elseif($filter_log_au->status == 0){
                    $not_yet_au = $not_yet_au+$filter_log_au->cantidad;
                }
            }
            $porcentajes_au = array('correctas' => $this->getPercent($ok_au,$logs_au), 'erróneas' => $this->getPercent($fail_au,$logs_au),'pendientes' => $this->getPercent($not_yet_au,$logs_au));
            $ejecuciones_au = array('correctas' => $ok_au, 'erróneas' => $fail_au,'pendientes' => $not_yet_au);

        }
        // else{
        //     $porcentajes_au = null;
        //     $ejecuciones_au = null;
        //     $max_logs_au = null;
        // }





        $max_logs_prem = null;
        $max_logs_soporte = null;
        $logs_premium = 0;
        $porcentajes_prem = array('correctas' => 0, 'erróneas' => 0,'pendientes' => 0);
        $porcentajes_sup = array('correctas' => 0, 'erróneas' => 0,'pendientes' => 0);
        $ejecuciones_prem = array('correctas' => 0, 'erróneas' => 0,'pendientes' => 0);
        $ejecuciones_sup = array('correctas' => 0, 'erróneas' => 0,'pendientes' => 0);
        // if( strpos(Auth::user()->group,'GRP-ASG-PREM') !== false)
        // if( strpos(Auth::user()->group,'GRP-ASG-Soporte-DC') !== false )
        $logs_premium = ExecutionLog::where('id_user', '!=', 1)->where('user_group','like','%PREM%')->count();
        $filter_logs_premium = ExecutionLog::select(DB::raw('count(*) as cantidad, status'))->where('id_user', '!=', 1)->where('user_group','like','%PREM%')->groupBy('status')->get();
        $max_logs_prem = ExecutionLog::select(DB::raw('count(*) as cantidad, playbook'))->where('id_user', '!=', 1)->where('user_group','like','%PREM%')->groupBy('playbook')->orderBy('cantidad','DESC')->take(8)->get();

        if($logs_premium > 0){
            $ok=0;
            $fail = 0;
            $not_yet = 0;
            foreach($filter_logs_premium as $filter_log){
                if($filter_log->status >= 1 && $filter_log->status <= 9 ){
                    $ok = $ok+$filter_log->cantidad;
                }elseif($filter_log->status >= 11 && $filter_log->status <= 19 ){
                    $fail = $fail+$filter_log->cantidad;
                }elseif($filter_log->status == 0){
                    $not_yet = $not_yet+$filter_log->cantidad;
                }
            }
            $porcentajes_prem = array('correctas' => $this->getPercent($ok,$logs_premium), 'erróneas' => $this->getPercent($fail,$logs_premium),'pendientes' => $this->getPercent($not_yet,$logs_premium));
            $ejecuciones_prem = array('correctas' => $ok, 'erróneas' => $fail,'pendientes' => $not_yet);
        }



        $logs_soporte = ExecutionLog::where('id_user', '!=', 1)->where('user_group','like','%Soporte-DC%')->count();
        $filter_logs_soporte = ExecutionLog::select(DB::raw('count(*) as cantidad, status'))->where('id_user', '!=', 1)->where('user_group','like','%Soporte-DC%')->groupBy('status')->get();
        $max_logs_soporte = ExecutionLog::select(DB::raw('count(*) as cantidad, playbook'))->where('id_user', '!=', 1)->where('user_group','like','%Soporte-DC%')->groupBy('playbook')->orderBy('cantidad','DESC')->take(8)->get();


        if($logs_soporte > 0){
            $ok=0;
            $fail = 0;
            $not_yet = 0;
            foreach($filter_logs_soporte as $filter_log){
                if($filter_log->status >= 1 && $filter_log->status <= 9 ){
                    $ok = $ok+$filter_log->cantidad;
                }elseif($filter_log->status >= 11 && $filter_log->status <= 19 ){
                    $fail = $fail+$filter_log->cantidad;
                }elseif($filter_log->status == 0){
                    $not_yet = $not_yet+$filter_log->cantidad;
                }
            }
            $porcentajes_sup = array('correctas' => $this->getPercent($ok,$logs_soporte), 'erróneas' => $this->getPercent($fail,$logs_soporte),'pendientes' => $this->getPercent($not_yet,$logs_soporte));
            $ejecuciones_sup = array('correctas' => $ok, 'erróneas' => $fail,'pendientes' => $not_yet);
        }





        $backpack = compact(
            'servers',
            'vservers',
            'awxTemplates',
            'logs',
            'porcentajes',
            'ejecuciones',
            'max_logs',
            'logs_au',
            'porcentajes_au',
            'ejecuciones_au',
            'externalTools',
            'max_logs_au',

            // SOPORTE Y PREMIUM
            'max_logs_prem',
            'max_logs_soporte',
            'porcentajes_sup',
            'porcentajes_prem',
            'ejecuciones_prem',
            'ejecuciones_sup',
            'logs_premium',
            'logs_soporte'
        );



        return view('home',$backpack);


        //dd($max_logs);

    }
    private function getPercent($val, $total)
    {
        $percent = ($val * 100) / $total;
        $percent = number_format($percent,'1','.','');
        return $percent;
    }

    public function files()
    {
        $folder = 'vrt';
        $file = 'SNAP.html';
        return view('test', compact('folder','file'));
    }

}
