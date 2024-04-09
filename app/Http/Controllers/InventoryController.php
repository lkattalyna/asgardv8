<?php

namespace App\Http\Controllers;

use App\SyncLog;
use App\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventarios = Inventory::all('id_inventory','name_inventory','id_group','name_group','name_host');
        $log = SyncLog::where('process','sync_inventory_awx')->latest()->first('created_at');
        if(!$log){
            $log = 'Nunca';
        }else{
            $log = $log->created_at;
        }
        return view('inventories.index',compact('inventarios','log'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        ini_set('max_execution_time', 2400);

        Inventory::truncate();
        $client = new \GuzzleHttp\Client();
        $serverURL = env('PROD_SERVER');
        $AuthKey = env('AUTH_KEY');
        $hosts = array();
        $res = $client->request('GET', "http://$serverURL/api/v2/hosts", [
            'headers' => [
                'Authorization' => "Basic $AuthKey",
            ],
        ]);

        $response =json_decode($res->getBody()->getContents(),true);
        foreach($response['results'] as $host){
            if(strlen($host['variables']) > 0){
                $ipv4 = $this->getIp($host['variables']);
                //$ipv4 = "";
            }else{
                $ipv4 = "";
            }
            if($host['summary_fields']['groups']['count'] == 0){
                Inventory::create([
                    'id_inventory' => $host['summary_fields']['inventory']['id'],
                    'name_inventory' => $host['summary_fields']['inventory']['name'],
                    'id_group' =>  NULL,
                    'name_group' =>  NULL,
                    'name_host' =>  $host['name'],
                    'ipv4' => $ipv4,
                ]);
            }elseif($host['summary_fields']['groups']['count'] > 0){
                for($i = 0; $i < $host['summary_fields']['groups']['count']; $i++){
                    Inventory::create([
                        'id_inventory' => $host['summary_fields']['inventory']['id'],
                        'name_inventory' => $host['summary_fields']['inventory']['name'],
                        'id_group' =>  $host['summary_fields']['groups']['results'][$i]['id'],
                        'name_group' =>  $host['summary_fields']['groups']['results'][$i]['name'],
                        'name_host' =>  $host['name'],
                        'ipv4' => $ipv4,
                    ]);
                }
            }
        }
        if($response['next'] != null){
            $i = 2;
            do {
                $client = new \GuzzleHttp\Client();
                $serverURL = env('PROD_SERVER');
                $AuthKey = env('AUTH_KEY');
                $hosts = array();
                $res = $client->request('GET', "http://$serverURL/api/v2/hosts/?page=$i", [
                    'headers' => [
                        'Authorization' => "Basic $AuthKey",
                    ],
                ]);
                if(strlen($host['variables']) > 0){
                    //$ipv4 = "";
                    $ipv4 = $this->getIp($host['variables']);
                }else{
                    $ipv4 = "";
                }
                $response =json_decode($res->getBody()->getContents(),true);
                foreach($response['results'] as $host){

                    if($host['summary_fields']['groups']['count'] == 0){
                        Inventory::create([
                            'id_inventory' => $host['summary_fields']['inventory']['id'],
                            'name_inventory' => $host['summary_fields']['inventory']['name'],
                            'id_group' =>  NULL,
                            'name_group' =>  NULL,
                            'name_host' =>  $host['name'],
                            'ipv4' => $ipv4,
                        ]);
                    }elseif($host['summary_fields']['groups']['count'] > 0){
                        for($val = 0; $val < $host['summary_fields']['groups']['count']; $val++){
                            Inventory::create([
                                'id_inventory' => $host['summary_fields']['inventory']['id'],
                                'name_inventory' => $host['summary_fields']['inventory']['name'],
                                'id_group' =>  $host['summary_fields']['groups']['results'][$val]['id'],
                                'name_group' =>  $host['summary_fields']['groups']['results'][$val]['name'],
                                'name_host' =>  $host['name'],
                                'ipv4' => $ipv4,
                            ]);
                        }
                    }
                }
                $i++;
            } while ($response['next'] != null);

        }
        $i = 1;
        do {
            $client = new \GuzzleHttp\Client();
            $serverURL = env('PROD_SERVER');
            $AuthKey = env('AUTH_KEY');
            $res = $client->request('GET', "http://$serverURL/api/v2/groups/?page=$i", [
                'headers' => [
                    'Authorization' => "Basic $AuthKey",
                ],
            ]);

            $response =json_decode($res->getBody()->getContents(),true);
            foreach($response['results'] as $group){
                if(!$this->groupExist($group['id'],$group['inventory'])){
                    Inventory::create([
                        'id_inventory' => $group['summary_fields']['inventory']['id'],
                        'name_inventory' => $group['summary_fields']['inventory']['name'],
                        'id_group' =>  $group['id'],
                        'name_group' =>  $group['name'],
                    ]);
                }
            }
            $i++;
        } while ($response['next'] != null);

        SyncLog::create([
            'process' => 'sync_inventory_awx',
            'comment' => 'N/A',
        ]);

        return redirect()->route('inventories.index')->with('success','El inventario se ha sincronizado con éxito');

    }

    private function groupExist($idGroup, $idInventory)
    {
        $exist = Inventory::where('id_group', $idGroup)->where('id_inventory',$idInventory)->count();
        if($exist == 0){
            return false;
        }else{
            return true;
        }
    }
    private function getIp($string)
    {
        //dd($string);
        $pos = stripos($string, 'ansible_host');
        if ($pos !== false) {
            $split = substr($string, $pos, $pos+30);
            $split = explode(" ",$split);
            $split = $split[1];
            $split = str_replace(['"','}', 'ans'],"",$split);
            $split = explode(" ",$split);
            $send = $split[0];
        }else{
            $send = '';
        }
        return $send;
    }

}
