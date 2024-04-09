<?php

namespace App\Http\Controllers;

use App\CloudApiAccount;
use App\Imports\CloudApiAccountImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Traits\ConnectionTrait;

class CloudApiAccountController extends Controller
{
    Use ConnectionTrait;
    private $method = "local";
    //cloud_1OsaQ7iJCCxv6dKtuO1p1giqiGNzUWGjw7QBZHGp
    public function accountAdd()
    {
        return view('cloud.accountAddAPI');
    }
    public function accountAddStore(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file'
        ]);
        $numRows = new CloudApiAccountImport ();
        Excel::import($numRows, $request->file('file'));
        //$numRows->getInsertedId()
        $idTemplate = 20;
        $log = $this->getLog(7,14,$idTemplate,1,0,'172.22.16.179');
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $ids = $numRows->getInsertedId();
        $variables = array("extra_vars" => array("ids" => $ids));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables,'172.22.16.179');
        //dd($resultado);
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
            'result' => $ids,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);
        //return redirect()->route('cloud.accountAdd')->with('success', 'Archivo cargado con éxito, se cargaron '.$numRows->getRowCount().' registros');
    }
    public function show (CloudApiAccount $account){
        return $account;
    }
    public function update(Request $request, CloudApiAccount $account)
    {
        $account->update([
            'id_account' => $request->input('id_account'),
        ]);
        return response()->json($account, 200);
    }


}
