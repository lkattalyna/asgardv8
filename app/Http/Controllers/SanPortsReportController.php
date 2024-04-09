<?php

namespace App\Http\Controllers;

use App\SanPortsReport;
use Illuminate\Http\Request;

class SanPortsReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = SanPortsReport::distinct()->get(['created_at','id_report']);
        //dd($reports);
        return view('san.admin.portsReport', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = file_get_contents(app_path() . "\scripts\SAN\settings_ports_report.json");
        $data = json_decode($data, true);
        //dd($data);
        $day = substr($request->input('report'),0,2);
        $hour = substr($request->input('report'),2,2);
        if($hour == 00){
            if($day == '01'){
                $day = '30';
            }else{
                $day = intval($day) - 1;
            }
            $day = str_pad($day, 2, "0", STR_PAD_LEFT);
            $hour = '23';
        }else{
            $hour = intval($hour) - 1;
            $hour = str_pad($hour, 2, "0", STR_PAD_LEFT);
        }
        $rep = $day.$hour;

        $alerts = array();
        $reports = SanPortsReport::where('id_report', $request->input('report'))->get();
        foreach($reports as $report){
            //dd($report);
            $rep_old = SanPortsReport::where('id_report', $rep)->where('port', $report->port)->first();
            //dd($rep_old);
            $start_date = $report->created_at;
            $end_date = $rep_old->created_at;
            $frames_tx_val = $this->clearVal($report->frames_tx) - $this->clearVal($rep_old->frames_tx);
            $frames_rx_val = $this->clearVal($report->frames_rx) - $this->clearVal($rep_old->frames_rx);
            $enc_in_val = $this->clearVal($report->enc_in) - $this->clearVal($rep_old->enc_in);
            $crc_err_val = $this->clearVal($report->crc_err) - $this->clearVal($rep_old->crc_err);
            $crc_g_eof_val = $this->clearVal($report->crc_g_eof) - $this->clearVal($rep_old->crc_g_eof);
            $too_shrt_val = $this->clearVal($report->too_shrt) - $this->clearVal($rep_old->too_shrt);
            $too_long_val = $this->clearVal($report->too_long) - $this->clearVal($rep_old->too_long);
            $bad_eof_val = $this->clearVal($report->bad_eof) - $this->clearVal($rep_old->bad_eof);
            $enc_out_val = $this->clearVal($report->enc_out) - $this->clearVal($rep_old->enc_out);
            $disc_c3_val = $this->clearVal($report->disc_c3) - $this->clearVal($rep_old->disc_c3);
            $link_fail_val = $this->clearVal($report->link_fail) - $this->clearVal($rep_old->link_fail);
            $loss_sync_val = $this->clearVal($report->loss_sync) - $this->clearVal($rep_old->loss_sync);
            $loss_sig_val = $this->clearVal($report->loss_sig) - $this->clearVal($rep_old->loss_sig);
            $frjt_val = $this->clearVal($report->frjt) - $this->clearVal($rep_old->frjt);
            $fbsy_val = $this->clearVal($report->fbsy) - $this->clearVal($rep_old->fbsy);
            $c3_timeout_tx_val = $this->clearVal($report->c3_timeout_tx) - $this->clearVal($rep_old->c3_timeout_tx);
            $c3_timeout_rx_val = $this->clearVal($report->c3_timeout_rx) - $this->clearVal($rep_old->c3_timeout_rx);
            $pcs_err_val = $this->clearVal($report->pcs_err) - $this->clearVal($rep_old->pcs_err);
            $uncor_err_val = $this->clearVal($report->uncor_err) - $this->clearVal($rep_old->uncor_err);
            $flag = 0;
            if($enc_in_val > $data['enc_in']){
                $flag = 1;
            }
            if($crc_err_val > $data['crc_err']){
                $flag = 1;
            }
            if($crc_g_eof_val > $data['crc_g_eof']){
                $flag = 1;
            }
            if($too_shrt_val > $data['too_shrt']){
                $flag = 1;
            }
            if($too_long_val > $data['too_long']){
                $flag = 1;
            }
            if($bad_eof_val > $data['bad_eof']){
                $flag = 1;
            }
            if($enc_out_val > $data['enc_out']){
                $flag = 1;
            }
            if($disc_c3_val > $data['disc_c3']){
                $flag = 1;
            }
            if($link_fail_val > $data['link_fail']){
                $flag = 1;
            }
            if($loss_sync_val > $data['loss_sync']){
                $flag = 1;
            }
            if($loss_sig_val > $data['loss_sig']){
                $flag = 1;
            }
            if($frjt_val > $data['frjt']){
                $flag = 1;
            }
            if($fbsy_val > $data['fbsy']){
                $flag = 1;
            }
            if($pcs_err_val > $data['pcs_err']){
                $flag = 1;
            }
            if($uncor_err_val > $data['uncor_err']){
                $flag = 1;
            }
            if($flag == 1){
                $data = array(
                    'switch' => $report->getSwitch->sw,
                    'port' => $report->port,
                    'frames_tx' => $frames_tx_val,
                    'frames_rx' => $frames_rx_val,
                    'enc_in' => $enc_in_val,
                    'crc_err' => $crc_err_val,
                    'crc_g_eof' => $crc_g_eof_val,
                    'too_shrt' => $too_shrt_val,
                    'too_long' => $too_long_val,
                    'bad_eof' => $bad_eof_val,
                    'enc_out' => $enc_out_val,
                    'disc_c3' => $disc_c3_val,
                    'link_fail' => $link_fail_val,
                    'loss_sync' => $loss_sync_val,
                    'loss_sig' => $loss_sig_val,
                    'frjt' => $frjt_val,
                    'fbsy' => $fbsy_val,
                    'c3_timeout_tx' => $c3_timeout_tx_val,
                    'c3_timeout_rx' => $c3_timeout_rx_val,
                    'pcs_err' => $pcs_err_val,
                    'uncor_err' => $uncor_err_val
                );
                array_push($alerts, $data);
            }
        }
        //dd($alerts);
        return view('san.admin.portsReportRs', compact('alerts'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SanPortsReport  $sanPortsReport
     * @return \Illuminate\Http\Response
     */
    public function show(SanPortsReport $sanPortsReport)
    {
        $reports = SanPortsReport::where('id_switch', $sanPortsReport->id_switch)->where('port', $sanPortsReport->port)->get();
        return view('san.admin.portsReportShow', compact('reports'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SanPortsReport  $sanPortsReport
     * @return \Illuminate\Http\Response
     */
    public function edit(SanPortsReport $sanPortsReport)
    {
        $data = file_get_contents(app_path() . "\scripts\SAN\settings_ports_report.json");
        //dd($data);
        $data = json_decode($data);
        //dd($data);
        return view('san.admin.portsReportSettings', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SanPortsReport  $sanPortsReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            "frames_tx" =>  'required|integer|min:1',
            "frames_rx" =>  'required|integer|min:1',
            "enc_in" =>  'required|integer|min:1',
            "crc_err" =>  'required|integer|min:1',
            "crc_g_eof" =>  'required|integer|min:1',
            "too_shrt" =>  'required|integer|min:1',
            "too_long" =>  'required|integer|min:1',
            "bad_eof" =>  'required|integer|min:1',
            "enc_out" =>  'required|integer|min:1',
            "disc_c3" =>  'required|integer|min:1',
            "link_fail" =>  'required|integer|min:1',
            "loss_sync" =>  'required|integer|min:1',
            "loss_sig" =>  'required|integer|min:1',
            "frjt" =>  'required|integer|min:1',
            "fbsy" =>  'required|integer|min:1',
            "c3_timeout_tx" =>  'required|integer|min:1',
            "c3_timeout_rx" =>  'required|integer|min:1',
            "pcs_err" =>  'required|integer|min:1',
            "uncor_err" =>  'required|integer|min:1',
        ]);
        $data = array(
            'frames_tx' => $request->input('frames_tx'),
            'frames_rx' => $request->input('frames_rx'),
            'enc_in' => $request->input('enc_in'),
            'crc_err' => $request->input('crc_err'),
            'crc_g_eof' => $request->input('crc_g_eof'),
            'too_shrt' => $request->input('too_shrt'),
            'too_long' => $request->input('too_long'),
            'bad_eof' => $request->input('bad_eof'),
            'enc_out' => $request->input('enc_out'),
            'disc_c3' => $request->input('disc_c3'),
            'link_fail' => $request->input('link_fail'),
            'loss_sync' => $request->input('loss_sync'),
            'loss_sig' => $request->input('loss_sig'),
            'frjt' => $request->input('frjt'),
            'fbsy' => $request->input('fbsy'),
            'c3_timeout_tx' => $request->input('c3_timeout_tx'),
            'c3_timeout_rx' => $request->input('c3_timeout_rx'),
            'pcs_err' => $request->input('pcs_err'),
            'uncor_err' => $request->input('uncor_err')
        );
        $data = json_encode($data);
        //dd($data);
        file_put_contents(app_path() . "\scripts\SAN\settings_ports_report.json", $data);
        return redirect()->route('san.configPortReport')->with('success', 'Se actualizo la configuración correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SanPortsReport  $sanPortsReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(SanPortsReport $sanPortsReport)
    {
        //
    }
    private function clearVal ($val){
        if(substr($val,-1, 1) == 'k'){
            return substr($val, 0, -1);
        }elseif(substr($val,-1, 1) == 'm'){
            return substr($val, 0, -1)*1000;
        }elseif(substr($val,-1, 1) == 'g'){
            return substr($val, 0, -1)*1000000;
        }else{
            return $val;
        }
    }
}
