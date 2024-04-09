<?php

namespace App\Http\Controllers;

use App\SyncLog;
use App\AwxTemplate;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AwxTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $templates = AwxTemplate::all();
        $log = SyncLog::where('process','sync_templates_awx')->latest()->first('created_at');
        if(!$log){
            $log = 'Nunca';
        }else{
            $log = $log->created_at;
        }
        return view('awxTemplates.index',compact('templates','log'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        ini_set('max_execution_time', 240);

        //AwxTemplate::truncate();
        $client = new \GuzzleHttp\Client();
        $serverURL = env('PROD_SERVER');
        $AuthKey = env('AUTH_KEY');
        $res = $client->request('GET', "http://$serverURL/api/v2/job_templates/", [
            'headers' => [
                'Authorization' => "Basic $AuthKey",
            ],
        ]);

        $response =json_decode($res->getBody()->getContents(),true);
        foreach($response['results'] as $template){
            //dd($host);
            //Validamos si existe el template
            $created = new Carbon($template['created']);
            $updated = new Carbon($template['modified']);
            if(is_null($template['next_job_run'])){
                $schedule = false;
            }else{
                $temp = $template['id'];
                $con = new \GuzzleHttp\Client();
                $serverURL = env('PROD_SERVER');
                $AuthKey = env('AUTH_KEY');
                $link = $con->request('GET', "http://$serverURL/api/v2/job_templates/$temp/schedules/", [
                    'headers' => [
                        'Authorization' => "Basic $AuthKey",
                    ],
                ]);
                $res =json_decode($link->getBody()->getContents(),true);
                if($res['count'] == 0){
                    $schedule = false;
                }else{
                    $schedule = true;
                }
            }
            $awxTemplate = $this->getTemplateById($template['id']);
            if(is_null($awxTemplate)){
                AwxTemplate::create([
                    'id_template' => $template['id'],
                    'name' => $template['name'],
                    'description' => $template['description'],
                    'id_inventory' =>  $template['inventory'],
                    'playbook' =>  $template['playbook'],
                    'limit' =>  $template['limit'],
                    'ask_variables_on_launch' => $template['ask_variables_on_launch'],
                    'ask_limit_on_launch' => $template['ask_limit_on_launch'],
                    'allow_simultaneous' => $template['allow_simultaneous'],
                    'survey_enabled' => $template['survey_enabled'],
                    'job_schedule' => $schedule,
                    'ansible_created_at' => $created->toDateTimeString(),
                    'ansible_updated_at' => $updated->toDateTimeString(),
                ]);
            }else{
                $awxTemplate->update([
                    'name' => $template['name'],
                    'description' => $template['description'],
                    'id_inventory' =>  $template['inventory'],
                    'playbook' =>  $template['playbook'],
                    'limit' =>  $template['limit'],
                    'ask_variables_on_launch' => $template['ask_variables_on_launch'],
                    'ask_limit_on_launch' => $template['ask_limit_on_launch'],
                    'allow_simultaneous' => $template['allow_simultaneous'],
                    'survey_enabled' => $template['survey_enabled'],
                    'job_schedule' => $schedule,
                    'ansible_created_at' => $created->toDateTimeString(),
                    'ansible_updated_at' => $updated->toDateTimeString(),
                ]);
            }

        }
        if($response['next'] != null){
            $i = 2;
            do {
                $client = new \GuzzleHttp\Client();
                $serverURL = env('PROD_SERVER');
                $AuthKey = env('AUTH_KEY');
                $hosts = array();
                $res = $client->request('GET', "http://$serverURL/api/v2/job_templates/?page=$i", [
                    'headers' => [
                        'Authorization' => "Basic $AuthKey",
                    ],
                ]);

                $response =json_decode($res->getBody()->getContents(),true);
                foreach($response['results'] as $template){
                    //dd($host);
                    //Validamos si existe el template
                    $created = new Carbon($template['created']);
                    $updated = new Carbon($template['modified']);
                    if(is_null($template['next_job_run'])){
                        $schedule = false;
                    }else{
                        $temp = $template['id'];
                        $con = new \GuzzleHttp\Client();
                        $serverURL = env('PROD_SERVER');
                        $AuthKey = env('AUTH_KEY');
                        $link = $con->request('GET', "http://$serverURL/api/v2/job_templates/$temp/schedules/", [
                            'headers' => [
                                'Authorization' => "Basic $AuthKey",
                            ],
                        ]);
                        $res =json_decode($link->getBody()->getContents(),true);
                        if($res['count'] == 0){
                            $schedule = false;
                        }else{
                            $schedule = true;
                        }
                    }
                    $awxTemplate = $this->getTemplateById($template['id']);
                    if(is_null($awxTemplate)){
                        AwxTemplate::create([
                            'id_template' => $template['id'],
                            'name' => $template['name'],
                            'description' => $template['description'],
                            'id_inventory' =>  $template['inventory'],
                            'playbook' =>  $template['playbook'],
                            'limit' =>  $template['limit'],
                            'ask_variables_on_launch' => $template['ask_variables_on_launch'],
                            'ask_limit_on_launch' => $template['ask_limit_on_launch'],
                            'allow_simultaneous' => $template['allow_simultaneous'],
                            'survey_enabled' => $template['survey_enabled'],
                            'job_schedule' => $schedule,
                            'ansible_created_at' => $created->toDateTimeString(),
                            'ansible_updated_at' => $updated->toDateTimeString(),
                        ]);
                    }else{
                        $awxTemplate->update([
                            'name' => $template['name'],
                            'description' => $template['description'],
                            'id_inventory' =>  $template['inventory'],
                            'playbook' =>  $template['playbook'],
                            'limit' =>  $template['limit'],
                            'ask_variables_on_launch' => $template['ask_variables_on_launch'],
                            'ask_limit_on_launch' => $template['ask_limit_on_launch'],
                            'allow_simultaneous' => $template['allow_simultaneous'],
                            'survey_enabled' => $template['survey_enabled'],
                            'job_schedule' => $schedule,
                            'ansible_created_at' => $created->toDateTimeString(),
                            'ansible_updated_at' => $updated->toDateTimeString(),
                        ]);
                    }
                }
                $i++;
            } while ($response['next'] != null);

        }
        SyncLog::create([
            'process' => 'sync_templates_awx',
            'comment' => 'N/A',
        ]);

        return redirect()->route('awxTemplates.index')->with('success','Los templates se han sincronizado con éxito');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\AwxTemplate  $awxTemplate
     * @return \Illuminate\Http\Response
     */
    public function show(AwxTemplate $awxTemplate)
    {
        return view('awxTemplates.show',compact('awxTemplate'));
    }

    private function getTemplateById($id)
    {
        return AwxTemplate::where('id_template', $id)->first();

    }

}
