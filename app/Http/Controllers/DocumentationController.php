<?php

namespace App\Http\Controllers;

use App\DevRequest;
use App\DevRequestHistory;
use App\Documentation;
use App\RegConsumedService;
use App\RegImprovement;
use App\RegImprovementHistory;
use App\RegServiceLayer;
use App\RegServiceSegment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class DocumentationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // if(Auth::user()->group == 'GRP-ASG-Admin-Master'){
        if(strpos(Auth::user()->group,'GRP-ASG-Admin-Master') !== false ) {
            $docs = Documentation::all();
        }
        // elseif(Auth::user()->group != 'GRP-ASG-Admin-Master' && $this->isBoss(Auth::user()->id)){
        elseif( strpos(Auth::user()->group,'GRP-ASG-Admin-Master' === false ) && $this->isBoss(Auth::user()->id)){
            $ids = $this->getBossIds(Auth::user()->id);
            $docs = Documentation::whereIn('improvement_id',$this->getImprovementsByLayer($ids))->orWhere('owner_id', Auth::user()->id )->get();
        }else{
            $docs = Documentation::where('owner_id', Auth::user()->id )->get();
        }

        return view('documentations.index',compact('docs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(RegImprovement $regImprovement)
    {

        $documentation = Documentation::where('improvement_id',$regImprovement->id)->first();
        if(is_null($documentation)){
            $consumedServices = RegConsumedService::orderBy('name')->get();
            return view('documentations.create',compact('consumedServices', 'regImprovement'));
        }else{
            return view('documentations.show',compact('documentation'));
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, RegImprovement $regImprovement)
    {
        $this->validate($request, [
            'result' => 'required|string|max:200|min:1',
            'components' => 'required|string|max:200|min:1',
            'consumedService' => 'required|string|max:200|min:1',
            'unrelated' => 'required|string|max:200|min:1',
            'parameterFlag' => 'required|integer|min:0|max:1',
            'docFlag' => 'required|integer|min:0|max:1',
        ]);
        if($request->input('parameterFlag')){
            $this->validate($request, [
                'parameters' => 'required|string|max:100|min:1',
            ]);
            $parameters = $request->input('parameters');
        }else{
            $parameters = 'N/A';
        }
        $doc = Documentation::create([
            'result' => $request->input('result'),
            'components' => $request->input('components'),
            'unrelated_layers' => $request->input('unrelated'),
            'parameters_flag' => $request->input('parameterFlag'),
            'parameters' => $parameters,
            'tech_manual' => $request->input('docFlag'),
            'consumed_service_id' => $request->input('consumedService'),
            'improvement_id' => $regImprovement->id,
            'owner_id' => Auth::user()->id,
        ]);
        RegImprovementHistory::create([
            'improvement_id' => $regImprovement->id,
            'user_id' => Auth::user()->id,
            'comment' => "Se genera la documentación con id $doc->id para la automatización",
            'evidence' => 'N/A',
            'type' => 'documentation',
        ]);
        return  redirect()->route('documentations.index')->with('success',"Se ha creado la documentación número $doc->id para su aprobación");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Documentation  $documentation
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Documentation $documentation)
    {
        Log::info($documentation);
        return view('documentations.show',compact('documentation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Documentation  $documentation
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Documentation $documentation)
    {
        $consumedServices = RegConsumedService::orderBy('name')->get();
        return view('documentations.edit',compact('consumedServices', 'documentation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Documentation  $documentation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Documentation $documentation)
    {
        $this->validate($request, [
            'result' => 'required|string|max:200|min:1',
            'components' => 'required|string|max:200|min:1',
            'consumedService' => 'required|string|max:200|min:1',
            'unrelated' => 'required|string|max:200|min:1',
            'parameterFlag' => 'required|integer|min:0|max:1',
        ]);
        if($documentation->approval_status == 0){
            $this->validate($request, [
                'docFlag' => 'required|integer|min:0|max:1',
            ]);
            $docFlag = $request->input('docFlag');
        }else{
            $docFlag = $documentation->tech_manual;
        }
        if($request->input('parameterFlag')){
            $this->validate($request, [
                'parameters' => 'required|string|max:100|min:1',
            ]);
            $parameters = $request->input('parameters');
        }else{
            $parameters = 'N/A';
        }
        if($request->input('docFlag') && $request->file('docFile')->isValid()){
            $this->validate($request, [
                'docFile' => 'required|mimes:pdf|min:1|max:4096',
            ]);
            $fileName = 'Manual_'.$documentation->id.'_aut_'.$documentation->improvement_id.'.pdf';
            //Validamos si existe un archivo y lo borramos
            if(Storage::disk('local')->exists("docs/tech/$fileName")){
                Storage::delete("docs/tech/$fileName");
            }
            // Almacenamos el archivo
            $request->file('docFile')->storeAs('docs/tech', $fileName);
        }else{
            if(!$request->input('docFlag')){
                $fileName = 'Manual_'.$documentation->id.'_aut_'.$documentation->improvement_id.'.pdf';
                //Validamos si existe un archivo y lo borramos
                if(Storage::disk('local')->exists("docs/tech/$fileName")){
                    Storage::delete("docs/tech/$fileName");
                }
                $fileName = 'N/A';
            }else{
                $fileName = $documentation->tech_manual_link;
            }

        }

        $documentation->update([
            'result' => $request->input('result'),
            'components' => $request->input('components'),
            'unrelated_layers' => $request->input('unrelated'),
            'parameters_flag' => $request->input('parameterFlag'),
            'parameters' => $parameters,
            'tech_manual' => $docFlag,
            'tech_manual_link' => $fileName,
            'consumed_service_id' => $request->input('consumedService'),
            'improvement_id' => $documentation->regImprovement->id,
        ]);
        RegImprovementHistory::create([
            'improvement_id' => $documentation->regImprovement->id,
            'user_id' => Auth::user()->id,
            'comment' => "Se actualizo la documentación con id $documentation->id",
            'evidence' => 'N/A',
            'type' => 'documentation',
        ]);
        return  redirect()->route('documentations.index')->with('success',"Se ha actualizado la documentación número $documentation->id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Documentation  $documentation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Documentation $documentation)
    {
        $documentation->delete();
        return redirect()->route('documentations.index')->with('error', 'La documentación de la automatización ha sido eliminada con éxito');
    }
    public function approval(Documentation $documentation)
    {
        if(Auth::user()->id == $documentation->regImprovement->serviceLayer->leader_id || Auth::user()->id == $documentation->regImprovement->serviceLayer->coordinator_id){
            if($documentation->regImprovement->asgard){
                $devRequest = DevRequest::where('id_improvement',$documentation->improvement_id)->first();
                $devRequest->update([
                    'documented' => 1,
                ]);
                DevRequestHistory::create([
                    'request_id' => $devRequest->id,
                    'user_id' => Auth::user()->id,
                    'state_id' => $devRequest->state_id,
                    'comment' =>  'Se ha aprobado la documentación',
                ]);
            }
            $documentation->update([
                'approval_status' => 1,
                'approver_id' => Auth::user()->id,
                'approval_date' => now(),
            ]);
            RegImprovementHistory::create([
                'improvement_id' => $documentation->improvement_id,
                'user_id' => Auth::user()->id,
                'comment' => "Se aprobó la documentación de la automatización",
                'evidence' => 'N/A',
                'type' => 'documentation',
            ]);

            return redirect()->route('documentations.index')->with('success','Se ha aprobado la documentación');
        }else{
            return redirect()->route('documentations.index')->with('error','Su usuario no tiene permitido aprobar la documentación');
        }

    }
    public function uploadForm(Documentation $documentation)
    {
        return view('documentations.upload',compact( 'documentation'));
    }
    public function upload(Request $request, Documentation $documentation)
    {

        $this->validate($request, [
            'docFile' => 'required|mimes:pdf|min:1|max:4096',
        ]);
        $fileName = 'UManual_'.$documentation->id.'_aut_'.$documentation->improvement_id.'.pdf';
        //Validamos si existe un archivo y lo borramos
        if(Storage::disk('local')->exists("docs/user/$fileName")){
            Storage::delete("docs/user/$fileName");
        }
        // Almacenamos el archivo
        $request->file('docFile')->storeAs('docs/user', $fileName);

        $documentation->update([
            'user_manual_link' => $fileName,
        ]);
        RegImprovementHistory::create([
            'improvement_id' => $documentation->regImprovement->id,
            'user_id' => Auth::user()->id,
            'comment' => "Se agrego el manual de usuario para la documentación con id $documentation->id",
            'evidence' => 'N/A',
            'type' => 'documentation',
        ]);
        return  redirect()->route('documentations.index')->with('success',"Se ha actualizado la documentación número $documentation->id");
    }
    private function isBoss($id)
    {
        $boss = RegServiceLayer::where('leader_id',$id)->orWhere('coordinator_id',$id)->get();
        if(is_null($boss)){
            return false;
        }else{
            return true;
        }
    }
    private function  getBossIds($id)
    {
        $ids = RegServiceLayer::where('leader_id',$id)->orWhere('coordinator_id',$id)->get('id');
        return $ids;
    }
    private function getImprovementsByLayer($ids){
        $improvements = RegImprovement::whereIn('layer_id',$ids)->get('id');
        return $improvements;
    }
}
