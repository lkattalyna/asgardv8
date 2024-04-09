<?php

namespace App\Http\Controllers;

use App\DevRequest;
use App\DevRequestHistory;
use App\DevState;
use App\DevTask;
use App\RegImprovement;
use App\RegImprovementHistory;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DevRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $reqs = DevRequest::where('client_id',Auth::user()->id)->get();
        return view('dev.requests.index',compact('reqs'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexAdmin()
    {

        // $grupos = explode(";",Auth::user()->group);


        // if(Auth::user()->group == 'GRP-ASG-Admin-Master'){
        if( strpos(Auth::user()->group,'GRP-ASG-Admin-Master') !== false ){
            $toDoReqs = DevRequest::where('state_id',1)->get();
            $assignReqs = DevRequest::where('owner_id',Auth::user()->id)->get();
            return view('dev.requests.indexAdmin',compact('toDoReqs','assignReqs'));
        }else{
            $assignReqs = DevRequest::where('owner_id',Auth::user()->id)->get();
            return view('dev.requests.indexAdmin',compact('assignReqs'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $regImprovement = 0;
        $tasks = DevTask::orderBy('name')->get();
        return view('dev.requests.create',compact('tasks','regImprovement'));
    }
    public function createWithImprovement(RegImprovement $regImprovement)
    {
        $regImprovement = $regImprovement->id;
        $tasks = DevTask::orderBy('name')->get();
        return view('dev.requests.create',compact('tasks','regImprovement'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'template' => 'required|integer|min:0|max:32767',
            'inventory' => 'required|integer|min:0|max:32767',
            'title' => 'required|string|max:100|min:1',
            'menu' => 'required|string|max:30|min:1',
            'success' => 'required|integer|max:10|min:1',
            'bad' => 'required|integer|max:20|min:11',
            'term' => 'required|boolean',
            'task' => 'required|integer',
            'improvement' => 'required|integer',
        ]);
        $req = DevRequest::create([
            'template_id' => $request->template,
            'inventory_id' => $request->inventory,
            'description' => $request->description,
            'title' => $request->title,
            'title_menu' => $request->menu,
            'success_id' => $request->success,
            'error_id' => $request->bad,
            'read_terms' => $request->term,
            'state_id' => 1,
            'task_id' => $request->task,
            'client_id' => Auth::user()->id,
            'owner_id' => 1,
            'improvement_id' => $request->input('improvement'),
        ]);
        if($request->input('improvement') != 0){
            RegImprovementHistory::create([
                'improvement_id' => $request->input('improvement'),
                'user_id' => Auth::user()->id,
                'comment' => "Se crea el requerimiento de desarrollo número $req->id para la automatización",
                'evidence' => 'N/A',
                'type' => 'dev',
            ]);
        }
        return  redirect()->route('devRequestFields.index',$req->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DevRequest  $devRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(DevRequest $devRequest)
    {
        return view('dev.requests.show',compact('devRequest'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DevRequest  $devRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, DevRequest $devRequest)
    {
        $oldTasks = DevRequest::where('state_id',1)->orWhere('state_id',2)->get();
        if($devRequest->fields()->count() <= 5){
            $time = $devRequest->task->min_time;
        }else{
            $time = $devRequest->task->max_time;
        }
        if(!is_null($oldTasks)){
            foreach($oldTasks as $oldTask){
                if($oldTask->fields()->count() <= 5){
                    $time = $time + $oldTask->task->min_time;
                }else{
                    $time = $time + $oldTask->task->max_time;
                }
            }
        }
        $time = $time + 360;
        $days = ($time / 60) / 8;
        $days = (int) $days;
        if ($days == 0 ){
            $days = 1;
        }
        $endDate = $this->sumarDias($devRequest->created_at, $days);
        $devRequest->update([
            'expiration_date' => $endDate,
            'total_time' => $time,
        ]);
        DevRequestHistory::create([
            'request_id' => $devRequest->id,
            'user_id' => $devRequest->client_id,
            'state_id' => 1,
            'comment' => 'Requerimiento creado',
        ]);
        return  redirect()->route('devRequests.index')
            ->with('success', "El requerimiento esta listo para ser asignado, la fecha de solución aproximada es: $endDate");
    }

    public function assign(DevRequest $devRequest)
    {
        $users = User::where('developer',1)->get();
        return view('dev.requests.assign',compact('users','devRequest'));
    }
    public function assignStore(DevRequest $devRequest, Request $request)
    {
        $devRequest->update([
            'owner_id' => $request->owner,
            'state_id' => 2,
        ]);
        DevRequestHistory::create([
            'request_id' => $devRequest->id,
            'user_id' => Auth::user()->id,
            'state_id' => 2,
            'comment' => 'Requerimiento asignado a un nuevo responsable',
        ]);


        // if(Auth::user()->group == 'GRP-ASG-Admin-Master'){
        if(strpos(Auth::user()->group,'GRP-ASG-Admin-Master') !== false){
            $toDoReqs = DevRequest::where('state_id',1)->get();
            $assignReqs = DevRequest::where('owner_id',Auth::user()->id)->get();
            return view('dev.requests.indexAdmin',compact('toDoReqs','assignReqs'));
        }else{
            $assignReqs = DevRequest::where('owner_id',Auth::user()->id)->get();
            return view('dev.requests.indexAdmin',compact('assignReqs'));
        }
    }

    public function change(DevRequest $devRequest)
    { //dd($devRequest->all());
        if($devRequest->state_id == 2 || $devRequest->state_id == 3 ){
            $states = DevState::where('id',$devRequest->state_id+1)->orWhere('id',6)->get();
        }elseif ($devRequest->state_id == 4){
            if($devRequest->improvement_id == 0){
                $states = DevState::where('id','>',5)->get();
            }else{
                if($devRequest->improvement->documentation->approval_status == 1){
                    $states = DevState::where('id','>',5)->get();
                }else{
                    $states = DevState::where('id',5)->orWhere('id',6)->get();
                }
            }
        }elseif ($devRequest->state_id == 5) {
            if ($devRequest->improvement_id == 0) {
                $states = DevState::where('id', 7)->get();
            } else {
                $states = DevState::where('id', '>=', 6)->get();
            }
        }
        return view('dev.requests.change',compact('states','devRequest'));
    }
    public function changeStore(DevRequest $devRequest, Request $request)
    {
        if($request->state == 6 || $request->state == 7){
            if($devRequest->improvement_id == 0){
                $devRequest->update([
                    'state_id' => $request->state,
                    'comment' => $request->comment,
                    'solved_at' => Carbon::now(),
                ]);
            }else{
                if($request->state == 7 && $devRequest->improvement->documentation->approval_status == 0){
                    return redirect()->back()->with('error','No se puede finalizar el requerimiento sin documentar');
                }else{
                    $devRequest->update([
                        'state_id' => $request->state,
                        'comment' => $request->comment,
                        'solved_at' => Carbon::now(),
                    ]);
                    if($request->state == 7){
                        RegImprovementHistory::create([
                            'improvement_id' => $devRequest->improvement_id,
                            'user_id' => Auth::user()->id,
                            'comment' => "Se finaliza el requerimiento de desarrollo número $devRequest->id para la automatización",
                            'evidence' => 'N/A',
                            'type' => 'dev',
                        ]);
                    }elseif ($request->state == 6){
                        RegImprovementHistory::create([
                            'improvement_id' => $devRequest->improvement_id,
                            'user_id' => Auth::user()->id,
                            'comment' => "Se canceló el requerimiento de desarrollo número $devRequest->id para la automatización",
                            'evidence' => 'N/A',
                            'type' => 'dev',
                        ]);
                    }
                }
            }
        }else{
            $devRequest->update([
                'state_id' => $request->state,
            ]);
        }
        DevRequestHistory::create([
            'request_id' => $devRequest->id,
            'user_id' => Auth::user()->id,
            'state_id' => $request->state,
            'comment' =>  $request->comment,
        ]);
        return redirect()->route('devRequests.indexAdmin')->with('success', "Se cambio el estado del requerimiento # $devRequest->id");
    }

    private function sumarDias($fecha, $dias)
    {
        $nuevafecha = strtotime("+$dias day", strtotime($fecha));
        $nuevafecha = date('Y-m-d', $nuevafecha);
        return $nuevafecha;
    }

}
