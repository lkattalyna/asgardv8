<?php

namespace App\Http\Controllers;

use App\OsGroup;
use Illuminate\Http\Request;
use App\Http\Traits\ConnectionTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\File;


class ManagedSecurityController extends Controller
{
    Use ConnectionTrait;
    private $method = "local";

    public function instAVDSUnix()
    {
        $inventario = 16;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('managedSecurity.instAVDSUnix',compact('groups','inventario'));
    }


    public function instAVDSUnixStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'op' => 'required',
        ]);
        $idTemplate = 156;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "opcion" => $request->op));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);*/
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
    public function instAVDSWin()
    {
        $inventario = 17;
        $groups = $this->getGroups($inventario,$this->method);;
        return view('managedSecurity.instAVDSWin',compact('groups','inventario'));
    }


    public function instAVDSWinStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'op' => 'required',
        ]);
        $idTemplate = 158;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        $variables = array("extra_vars" => array("HOST" => $request->host, "opcion" => $request->op));
        //dd(json_encode($variables));
        $resultado = $this->runPlaybook($idTemplate,$variables);
        //dd($resultado);*/
        $resultado = $resultado['job'];
        //dd($resultado);
        $log->update([
            'id_job' => $resultado,
        ]);
        return redirect()->route('executionLogs.show',$id_asgard);

    }
    public function blacklistNotVdom()
    {
        $inventario = 93;
        $groups = $this->getGroups($inventario,$this->method);
        return view('managedSecurity.blacklistNotVdom',compact('groups','inventario'));
    }


    public function blacklistNotVdomStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'op' => 'required',
        ]);
        $idTemplate = 401;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        //dd($request->op);
        if ($request->op == "1" ) {
            # code...
            $sHost = $request->host;
            foreach($sHost as $host){
                $cadena = $host;
            }
            $variables = array("extra_vars" => array("host" => $cadena, "addr" => $request->ip ));
            //$request->input('option')
            //dd(json_encode($variables));
            $resultado = $this->runPlaybook($idTemplate,$variables);
            //dd($resultado);*/
            $resultado = $resultado['job'];
            //dd($resultado);
            $log->update([
                'id_job' => $resultado,
            ]);
            return redirect()->route('executionLogs.show',$id_asgard);
        }
        else {
            # Subiendo y leyendo el archivo plano separado por comas
            $files = Storage::allFiles('SECURITY');
            Storage::delete($files);
            $file = $request->file("report");
            $file->storeAs('SECURITY',$file->getClientOriginalName());

            $contenido = file_get_contents($file);
            //dd($contenido);
            $sHost = $request->host;
            foreach($sHost as $host){
                $cadena = $host;
            }
            $variables = array("extra_vars" => array("host" => $cadena, "addr" => $contenido ));
            //dd(json_encode($variables));
            $resultado = $this->runPlaybook($idTemplate,$variables);
            //dd($resultado);*/
            $resultado = $resultado['job'];
            //dd($resultado);
            $log->update([
                'id_job' => $resultado,
            ]);
            return redirect()->route('executionLogs.show',$id_asgard);
        }
    }
    public function blacklistVdom()
    {
        $inventario = 92;
        $groups = $this->getGroups($inventario,$this->method);
        return view('managedSecurity.blacklistVdom',compact('groups','inventario'));
    }


    public function blacklistVdomStore(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'vdom' => 'required',
            'op' => 'required',
        ]);
        $idTemplate = 403;
        $log = $this->getLog(3,13,$idTemplate);
        $id_asgard = $log->id;
        //$id_asgard = 1;
        //dd($request->op);
        if ($request->op == "1" ) {
            # code...
            $sHost = $request->host;
            foreach($sHost as $host){
                $cadena = $host;
            }
            $variables = array("extra_vars" => array("host" => $cadena,"vdom" => $request->vdom, "addr" => $request->ip ));
            //dd(json_encode($variables));
             $resultado = $this->runPlaybook($idTemplate,$variables);
            //dd($resultado);*/
            $resultado = $resultado['job'];
            //dd($resultado);
            $log->update([
                'id_job' => $resultado,
            ]);
            return redirect()->route('executionLogs.show',$id_asgard);
        }
        else {
            # Subiendo y leyendo el archivo plano separado por comas
            $files = Storage::allFiles('SECURITY');
            Storage::delete($files);
            $file = $request->file("report");
            $file->storeAs('SECURITY',$file->getClientOriginalName());

            $contenido = file_get_contents($file);
            //dd($contenido);
            $sHost = $request->host;
            foreach($sHost as $host){
                $cadena = $host;
            }
            $variables = array("extra_vars" => array("host" => $cadena, "addr" => $contenido ));
            //dd(json_encode($variables));
            $resultado = $this->runPlaybook($idTemplate,$variables);
            //dd($resultado);*/
            $resultado = $resultado['job'];
            //dd($resultado);
            $log->update([
                'id_job' => $resultado,
            ]);
            return redirect()->route('executionLogs.show',$id_asgard);
        }

    }
}
