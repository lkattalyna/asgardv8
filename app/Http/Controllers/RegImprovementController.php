<?php

namespace App\Http\Controllers;

use App\RegCustomerLevel;
use App\RegImprovement;
use App\RegImprovementHistory;
use App\RegQuarter;
use App\RegServiceLayer;
use App\RegServiceSegment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ImprovementProgressTrait;
use Illuminate\Support\Facades\Log;

class RegImprovementController extends Controller
{
    use ImprovementProgressTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        // if(Auth::user()->group == 'GRP-ASG-Admin-Master' || Auth::user()->group == 'GRP-ASG-DES'){
        // dd(Auth::user()->group);
        if( strpos(Auth::user()->group,'GRP-ASG-Admin-Master') !== false ||
            strpos(Auth::user()->group,'GRP-ASG-DES') !== false
        ){
            $improvements = RegImprovement::all();
        }
        // elseif(Auth::user()->group != 'GRP-ASG-Admin-Master' && $this->isBoss(Auth::user()->id)){
        elseif( strpos(Auth::user()->group,'GRP-ASG-Admin-Master') === false   && $this->isBoss(Auth::user()->id)){
            $ids = $this->getBossIds(Auth::user()->id);
            $improvements = RegImprovement::whereIn('id',$this->getImprovementsByLayer($ids))->orWhere('owner_id', Auth::user()->id )->get();
        }else{
            $improvements = RegImprovement::where('owner_id', Auth::user()->id )->get();
        }

        foreach ($improvements as $improvement){
            $progress = $this->getProgress($improvement);
            $improvement['total'] = $progress['total'];
            $improvement['test'] = $progress['test'];
            $improvement['tracing'] = $progress['tracing'];
         }
		 
		 //dd($improvement);
        return view('improvements.index',compact('improvements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $qs = RegQuarter::orderBy('name')->get();
        $segments = RegServiceSegment::orderBy('name')->get(['id','name']);
        $layers = RegServiceLayer::orderBy('name')->get();
        $levels = RegCustomerLevel::orderBy('name')->get();
        $improvements = RegImprovement::where('dependence',0)->orderBy('playbook_name')->get(['id','playbook_name']);
        return view('improvements.create',compact('qs','segments','layers','levels','improvements'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Log::info($request);
        $this->validate($request, [
            'segment' => 'required|integer',
            'layer' => 'required|integer',
            'asgard' => 'required|integer|min:0|max:1',
            'description' => 'required|string|max:200|min:1',
            'scope' => 'required|string|max:200|min:1',
            'objetive' => 'required|string|max:200|min:1',
            'dependence' => 'required|integer',
            'task' => 'required|string|max:20|min:1',
            'tAut' => 'required|string|max:15|min:1',
            'frequency' => 'required|string|max:15|min:1',
            'fq' => 'required|integer|min:1|max:32767',
            'deliverable' => 'required|string|max:80|min:1',
            'name' => 'required|string|max:31|min:1',
            'customerLevel' => 'required|integer',
            'minB' => 'required|integer|min:1|max:32767',
            'minA' => 'required|integer|min:1|max:32767',
            'minT' => 'required|integer|min:1|max:32767',
            'customerLevelPost' => 'required|integer',
            'goal' => 'required|integer|min:1|max:32767',
            'start' => 'required|date',
            'end' => 'required|date',
        ]);

        $improvement = RegImprovement::create([
            'asgard_view' => $request->input('asgard'),
            'description' => $request->input('description'),
            'deliverable' => $request->input('deliverable'),
            'scope' => $request->input('scope'),
            'objetive' => $request->input('objetive'),
            'dependence' => $request->input('dependence'),
            'task_type' => $request->input('task'),
            'aut_type' => $request->input('tAut'),
            'frequency' => $request->input('frequency'),
            'frequency_times' => $request->input('fq'),
            'ci_goal' => $request->input('goal'),
            'minutes_before' => $request->input('minB'),
            'minutes_after' => $request->input('minA'),
            'minutes_total' => $request->input('minT'),
            'playbook_name' => $request->input('name'),
            'owner_id' => Auth::user()->id,
            'customer_level_id' => $request->input('customerLevel'),
            'customer_level_post_id' => $request->input('customerLevelPost'),
            'segment_id' => $request->input('segment'),
            'layer_id' => $request->input('layer'),
            'start_date' => $request->input('start'),
            'end_date' => $request->input('end'),
        ]);
        $progress = $this->getProgress($improvement);
        RegImprovementHistory::create([
            'improvement_id' => $improvement->id,
            'user_id' => Auth::user()->id,
            'comment' => 'Se crea la automatización',
            'progress' => $progress['total'],
            'evidence' => 'N/A',
            'type' => 'register',
        ]);
        return  redirect()->route('improvements.index')->with('success',"Se ha creado la automatización número $improvement->id para su tramite");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RegImprovement  $improvement
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(RegImprovement $improvement)
    {
        $progress = $this->getProgress($improvement);
        return view('improvements.show',compact('improvement','progress'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RegImprovement  $improvement
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(RegImprovement $improvement)
    {

        $qs = RegQuarter::orderBy('name')->get();
        $segments = RegServiceSegment::orderBy('name')->get(['id','name']);
        $layers = RegServiceLayer::where('segment_id', $improvement->segment_id )->orderBy('name')->get();
        $levels = RegCustomerLevel::orderBy('name')->get();
        $regImprovements = RegImprovement::where('dependence',0)->orderBy('playbook_name')->get(['id','playbook_name']);
        return view('improvements.edit',compact('qs','segments','layers','levels','regImprovements','improvement'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RegImprovement  $improvement
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, RegImprovement $improvement)
    {
        $this->validate($request, [
            'segment' => 'required|integer',
            'layer' => 'required|integer',
            'asgard' => 'required|integer|min:0|max:1',
            'description' => 'required|string|max:200|min:1',
            'scope' => 'required|string|max:200|min:1',
            'objetive' => 'required|string|max:200|min:1',
            'dependence' => 'required|integer',
            'task' => 'required|string|max:20|min:1',
            'tAut' => 'required|string|max:15|min:1',
            'frequency' => 'required|string|max:15|min:1',
            'fq' => 'required|integer|min:1|max:32767',
            'deliverable' => 'required|string|max:80|min:1',
            'name' => 'required|string|max:31|min:1',
            'customerLevel' => 'required|integer',
            'minB' => 'required|integer|min:1|max:32767',
            'minA' => 'required|integer|min:1|max:32767',
            'minT' => 'required|integer|min:1|max:32767',
            'customerLevelPost' => 'required|integer',
            'goal' => 'required|integer|min:1|max:32767',
            'start' => 'required|date',
            'end' => 'required|date',
        ]);

        $improvement->update([
            'asgard_view' => $request->input('asgard'),
            'description' => $request->input('description'),
            'deliverable' => $request->input('deliverable'),
            'scope' => $request->input('scope'),
            'objetive' => $request->input('objetive'),
            'dependence' => $request->input('dependence'),
            'task_type' => $request->input('task'),
            'aut_type' => $request->input('tAut'),
            'frequency' => $request->input('frequency'),
            'frequency_times' => $request->input('fq'),
            'ci_goal' => $request->input('goal'),
            'minutes_before' => $request->input('minB'),
            'minutes_after' => $request->input('minA'),
            'minutes_total' => $request->input('minT'),
            'playbook_name' => $request->input('name'),
            'customer_level_id' => $request->input('customerLevel'),
            'customer_level_post_id' => $request->input('customerLevelPost'),
            'segment_id' => $request->input('segment'),
            'layer_id' => $request->input('layer'),
            'start_date' => $request->input('start'),
            'end_date' => $request->input('end'),
        ]);
        $progress = $this->getProgress($improvement);
        RegImprovementHistory::create([
            'improvement_id' => $improvement->id,
            'user_id' => Auth::user()->id,
            'comment' => 'Se actualizó la automatización',
            'progress' => $progress['total'],
            'evidence' => 'N/A',
            'type' => 'register',
        ]);
        return  redirect()->route('improvements.index')->with('success',"Se ha actualizado la automatización número $improvement->id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RegImprovement  $improvement
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(RegImprovement $improvement)
    {
        $improvement->delete();
        return redirect()->route('improvements.index')->with('error', 'El registro automatización ha sido eliminado con éxito');
    }

    public function getlayers($id)
    {
        $layers = RegServiceLayer::where('segment_id', $id)->orderBy('name')->get(['id','name']);
        return $layers;
    }
    public function approval(RegImprovement $improvement)
    {
        if(Auth::user()->id == $improvement->serviceLayer->leader_id || Auth::user()->id == $improvement->serviceLayer->coordinator_id){
            $improvement->update([
                'approval_status' => 1,
                'approver_id' => Auth::user()->id,
            ]);
            $progress = $this->getProgress($improvement);
            RegImprovementHistory::create([
                'improvement_id' => $improvement->id,
                'user_id' => Auth::user()->id,
                'comment' => "Se aprobó la automatización para su implementación",
                'progress' => $progress['total'],
                'evidence' => 'N/A',
                'type' => 'register',
            ]);

            return redirect()->route('improvements.index')->with('success','Se ha aprobado la automatización');
        }else{
            return redirect()->route('improvements.index')->with('error','Su usuario no tiene permitido aprobar la automatización');
        }

    }
    public function deny(RegImprovement $improvement)
    {
        if(Auth::user()->id == $improvement->serviceLayer->leader_id || Auth::user()->id == $improvement->serviceLayer->coordinator_id){
            $improvement->update([
                'approval_status' => 2,
                'approver_id' => Auth::user()->id,
            ]);
            $progress = $this->getProgress($improvement);
            RegImprovementHistory::create([
                'improvement_id' => $improvement->id,
                'user_id' => Auth::user()->id,
                'comment' => "Se denegó la automatización para su implementación",
                'progress' => $progress['total'],
                'evidence' => 'N/A',
                'type' => 'register',
            ]);

            return redirect()->route('improvements.index')->with('error','Se ha denegado la automatización');
        }else{
            return redirect()->route('improvements.index')->with('error','Su usuario no tiene permitido denegar la automatización');
        }

    }
    public function testApproval(RegImprovement $improvement)
    {
        if(Auth::user()->id == $improvement->serviceLayer->leader_id || Auth::user()->id == $improvement->serviceLayer->coordinator_id){
            $improvement->update([
                'test_approval_status' => 1,
                'test_approver_id' => Auth::user()->id,
            ]);
            $progress = $this->getProgress($improvement);
            RegImprovementHistory::create([
                'improvement_id' => $improvement->id,
                'user_id' => Auth::user()->id,
                'comment' => "Se aprobaron las pruebas funcionales de la automatización para su implementación",
                'progress' => $progress['total'],
                'evidence' => 'N/A',
                'type' => 'register',
            ]);

            return redirect()->route('improvements.index')->with('success','Se han aprobado las pruebas la automatización');
        }else{
            return redirect()->route('improvements.index')->with('error','Su usuario no tiene permitido aprobar las pruebas de la automatización');
        }

    }
    public function showProgress(RegImprovement $improvement)
    {
        dd($this->getProgress($improvement));
    }
    public function progressEdit(RegImprovement $improvement)
    {
        $advance = $this->getProgress($improvement);
        $progress['ci'] = $advance['ci'];
        $progress['dev'] = $advance['dev'];
        $progress['int'] = $advance['int'];
        $progress['test'] = $advance['test'];
        $progress['tracing'] = $advance['tracing'];
        return view('improvements.progressEdit',compact('improvement','progress'));
    }
    public function progressUpdate(RegImprovement $improvement, Request $request)
    {
        $this->validate($request, [
            'service' => 'required|integer|min:1|max:4',
            'progress' => 'required|integer',
        ]);

        switch ($request->input('service')){
            case 1:
                $max = $improvement->ci_goal - $improvement->ci_progress;
                if($request->input('progress') <= $max ){
                    $newProgress = $improvement->ci_progress + $request->input('progress');
                    $improvement->update([
                        'ci_progress' => $newProgress,
                    ]);
                    $progress = $this->getProgress($improvement);
                    RegImprovementHistory::create([
                        'improvement_id' => $improvement->id,
                        'user_id' => Auth::user()->id,
                        'comment' => "Se actualizó el avance de CI's en ".$request->input('progress')." para in total de $newProgress",
                        'progress' => $progress['total'],
                        'evidence' => 'N/A',
                        'type' => 'progress',
                    ]);
                    return redirect()->route('improvements.progressEdit',$improvement->id)
                        ->with('success',"Se actualizo el progreso de CI's para la automatización $improvement->id");
                }else{
                    return redirect()->route('improvements.progressEdit',$improvement->id)
                        ->with('error',"No es posible avanzar en ".$request->input('progress')." cuando el maximo permitido es de $max CI's para la automatización $improvement->id");
                }
                break;
            case 2:
                $max = 100 - $improvement->dev_progress;
                if($request->input('progress') <= $max ){
                    $newProgress = $improvement->dev_progress + $request->input('progress');
                    $improvement->update([
                        'dev_progress' => $newProgress,
                    ]);
                    $progress = $this->getProgress($improvement);
                    RegImprovementHistory::create([
                        'improvement_id' => $improvement->id,
                        'user_id' => Auth::user()->id,
                        'comment' => "Se actualizó el avance de Desarrollo o Programación en ".$request->input('progress')." para in total de $newProgress",
                        'progress' => $progress['total'],
                        'evidence' => 'N/A',
                        'type' => 'progress',
                    ]);
                    return redirect()->route('improvements.progressEdit',$improvement->id)
                        ->with('success',"Se actualizo el progreso de Desarrollo o Programación para la automatización $improvement->id");
                }else{
                    return redirect()->route('improvements.progressEdit',$improvement->id)
                        ->with('error',"No es posible avanzar en ".$request->input('progress')." cuando el maximo permitido es de $max para la automatización $improvement->id");
                }
                break;
            case 3:
                $max = 100 - $improvement->int_progress;
                if($request->input('progress') <= $max ){
                    $newProgress = $improvement->int_progress + $request->input('progress');
                    $improvement->update([
                        'int_progress' => $newProgress,
                    ]);
                    $progress = $this->getProgress($improvement);
                    RegImprovementHistory::create([
                        'improvement_id' => $improvement->id,
                        'user_id' => Auth::user()->id,
                        'comment' => "Se actualizó el avance de Integración en ".$request->input('progress')." para in total de $newProgress",
                        'progress' => $progress['total'],
                        'evidence' => 'N/A',
                        'type' => 'progress',
                    ]);
                    return redirect()->route('improvements.progressEdit',$improvement->id)
                        ->with('success',"Se actualizo el progreso de Integración para la automatización $improvement->id");
                }else{
                    return redirect()->route('improvements.progressEdit',$improvement->id)
                        ->with('error',"No es posible avanzar en ".$request->input('progress')." cuando el maximo permitido es de $max para la automatización $improvement->id");
                }
                break;
            case 4:
                $max = 100 - $improvement->test_progress;
                if($request->input('progress') <= $max ){
                    $newProgress = $improvement->test_progress + $request->input('progress');
                    $improvement->update([
                        'test_progress' => $newProgress,
                    ]);
                    $progress = $this->getProgress($improvement);
                    RegImprovementHistory::create([
                        'improvement_id' => $improvement->id,
                        'user_id' => Auth::user()->id,
                        'comment' => "Se actualizó el avance de Pruebas en ".$request->input('progress')." para in total de $newProgress",
                        'progress' => $progress['total'],
                        'evidence' => 'N/A',
                        'type' => 'progress',
                    ]);
                    return redirect()->route('improvements.progressEdit',$improvement->id)
                        ->with('success',"Se actualizo el progreso de Pruebas para la automatización $improvement->id");
                }else{
                    return redirect()->route('improvements.progressEdit',$improvement->id)
                        ->with('error',"No es posible avanzar en ".$request->input('progress')." cuando el maximo permitido es de $max para la automatización $improvement->id");
                }
                break;
        }
    }
    public function progressService(RegImprovement $improvement, $service)
    {
        return view('improvements.progressService',compact('improvement','service'));
    }
    public function history(RegImprovement $improvement)
    {
        return view('improvements.history',compact('improvement'));
    }
    public function temp()
    {
        return view('improvements.temp');
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
