<?php

namespace App\Http\Controllers;

use App\OsGroup;
use App\Inventory;
use Illuminate\Http\Request;
use App\Http\Traits\ConnectionTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OperatorController extends Controller
{
    Use ConnectionTrait;
    private $method = "local";

    private function checkExtension($extension)
    {
        //aqui podemos añadir las extensiones que deseemos permitir
        $extensiones = array("csv");
        if (in_array(strtolower($extension), $extensiones)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function opeReport()
    {
        return view('operators.opeReport');
    }
    public function opeReportStore(Request $request)
    {
        $this->validate($request, [
            'report' => 'required|file|max:7000',
        ]);
        $file = $request->file("report");
        // dd($file); CHECK
        $tam=$file->getSize();
        // dd("DEBUG 1",$tam); CHECK
        //indicamos que queremos guardar un nuevo archivo en el disco local
        $ext = $file->getClientOriginalExtension();
        // dd("DEBUG 2",$ext); //CHECK
        if($this->checkExtension($ext) && $tam < 6000000){
            $files = Storage::allFiles('IRE_DATA');
            Storage::delete($files);
            $file->storeAs('IRE_DATA',$file->getClientOriginalName());
        }else{
            return redirect()->back()
                ->with('error','Tamaño o extensión de archivo reporte invalida');
        }
        $log = $this->getExternalToolLog('ReporteOperadoresIRE');
        $results = shell_exec(app_path() . "\scripts\IRE\InformesOperadores.bat");
        //dd($results);
        if(!Storage::exists('IRE_DATA\Informe.docx')){
            $log->update([
                'd_end_script' => date("Y-m-d H:i:s"),
                'status' => 12,
                'result' => "Fallo en la ejecución",
            ]);
            return redirect()->route('operators.opeReport')->with('error','Ha ocurrido un error al ejecutar el comando, por favor intente de nuevo o contacte al administrador');
        }else{
            $log->update([
                'd_end_script' => date("Y-m-d H:i:s"),
                'status' => 2,
                'result' => "Ejecución realizada exitosamente",
            ]);
            return view("operators.opeReportRs");
        }
    }
}
