<?php

namespace App\Http\Controllers;

use App\RegServiceLayer;
use App\RegImprovementMin;
use App\RegServiceSegment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegImprovementMinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $improvements = RegImprovementMin::all();
        foreach($improvements as $improvement){
            $improvement->end_month = $this->getMonth($improvement->end_date);
        }
        return view('improvements.min.index',compact('improvements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $segments = RegServiceSegment::orderBy('name')->get(['id','name']);
        return view('improvements.min.create',compact('segments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'segment' => 'required|integer',
            'layer' => 'required|integer',
            'description' => 'required|string|max:200|min:1',
            'name' => 'required|string|max:31|min:1',
            'month' => 'required|integer|min:1|max:12',
        ]);

        $improvement = RegImprovementMin::create([
            'description' => $request->input('description'),
            'playbook_name' => $request->input('name'),
            'end_date' => $request->input('month'),
            'owner_id' => Auth::user()->id,
            'segment_id' => $request->input('segment'),
            'layer_id' => $request->input('layer'),
        ]);
        return  redirect()->route('regImprovementMin.index')->with('success',"Se ha creado la automatización número $improvement->id para su tramite");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RegImprovementMin  $regImprovementMin
     * @return \Illuminate\Http\Response
     */
    public function show(RegImprovementMin $regImprovementMin)
    {
        $regImprovementMin->end_month = $this->getMonth($regImprovementMin->end_date);
        return view('improvements.min.show',compact('regImprovementMin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RegImprovementMin  $regImprovementMin
     * @return \Illuminate\Http\Response
     */
    public function edit(RegImprovementMin $regImprovementMin)
    {
        $segments = RegServiceSegment::orderBy('name')->get(['id','name']);
        $layers = RegServiceLayer::where('segment_id', $regImprovementMin->segment_id )->orderBy('name')->get();
        return view('improvements.min.edit',compact('segments','layers','regImprovementMin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RegImprovementMin  $regImprovementMin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RegImprovementMin $regImprovementMin)
    {
        $this->validate($request, [
            'segment' => 'required|integer',
            'layer' => 'required|integer',
            'description' => 'required|string|max:200|min:1',
            'name' => 'required|string|max:31|min:1',
            'month' => 'required|integer|min:1|max:12',
            'improvement' => 'required|integer',
        ]);

        $regImprovementMin->update([
            'description' => $request->input('description'),
            'playbook_name' => $request->input('name'),
            'owner_id' => Auth::user()->id,
            'segment_id' => $request->input('segment'),
            'layer_id' => $request->input('layer'),
            'end_date' => $request->input('month'),
            'improvement' => $request->input('improvement'),
        ]);
        return  redirect()->route('regImprovementMin.index')->with('success',"Se ha actualizado la automatización número $regImprovementMin->id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RegImprovementMin  $regImprovementMin
     * @return \Illuminate\Http\Response
     */
    public function destroy(RegImprovementMin $regImprovementMin)
    {
        $regImprovementMin->delete();
        return redirect()->route('regImprovementMin.index')->with('error', 'El registro automatización ha sido eliminado con éxito');
    }
    public function getlayers($id)
    {
        $layers = RegServiceLayer::where('segment_id', $id)->orderBy('name')->get(['id','name']);
        return $layers;
    }
    public function getMonth($month)
    {
        $name[0] = 'N/A';
        $name[1] = 'Enero';
        $name[2] = 'Febrero';
        $name[3] = 'Marzo';
        $name[4] = 'Abril';
        $name[5] = 'Mayo';
        $name[6] = 'junio';
        $name[7] = 'Julio';
        $name[8] = 'Agosto';
        $name[9] = 'Septiembre';
        $name[10] = 'Octubre';
        $name[11] = 'Noviembre';
        $name[12] = 'Diciembre';
        return $name[$month];
    }
}
