<?php

namespace App\Http\Controllers;

use App\Models\Initiative;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\VirtualHost;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ConnectionTrait;
//use DB;
use Illuminate\Support\Facades\Log;
use App\RegServiceSegment;
use App\User;
use App\Models\initiative_criteria;
use App\RegServiceLayer;
use App\Models\initiative_states;
//LIBRERIA PARA GUARDAR ARCHIVOS
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class InitiativeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        // Obtener los datos guardados en 'initiatives'
        $initiativeData = Initiative::first(); // Suponiendo que solo hay un registro por ahora
        Log::info('estoy en initiative.index');
        $datos['Initiative'] = Initiative::get();

        foreach ($datos['Initiative'] as $initiative) {
            $segment = RegServiceSegment::find($initiative->segment_id);
            $service_layer = RegServiceLayer::find($initiative->service_layer_id);
            $initiative_state = initiative_states::find($initiative->state);
            $initiative->segment = $segment; // Agregar el segmento a cada iniciativa
            $initiative->service_layer = $service_layer; // Agregar torre a cada iniciativa
            $initiative->initiative_state = $initiative_state;
        }
        Log::info($datos);
        //$segment = RegServiceSegment::where('id', $datos['Initiative']->segment_id)->first();
        //$service_layer = RegServiceLayer::where('id', $datos['Initiative']->service_layer_id)->first();
        return view('initiative.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Log::info('initiative.create');
        $segments = RegServiceSegment::orderBy('name')->get();
        $service_layers = RegServiceLayer::orderBy('name')->get();
        $initiative_states = initiative_states::orderBy('status_name')->get();
        return view('initiative.create', compact('segments', 'service_layers', 'initiative_states'));

        //return view('initiative.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::info($request);
        //token
        $datosInitiative = request()->except('_token');

        $request->validate([
            'initiativeName' => 'required|string|max:100',
            'segment' => 'required',
            'execution_time_manual' => 'numeric',
            // Agregar aquí las validaciones para los demás campos
        ]);

        $user = Auth::user(); // Obtener el usuario autenticado
        $datosInitiative = Initiative::create([
            'initiative_name' => $request->initiativeName,
            'segment_id' => $request->segment,
            'service_layer_id' => $request->service_layer,
            'how' => $request->how,
            'want' => $request->want,
            'for' => $request->for,
            'task_type' => $request->task_type,
            'automation_type' => $request->automation_type,
            'general_description' => $request->general_description,
            'execution_time_manual' => $request->execution_time_manual,
            'advantages' => $request->advantages,
            'attachments' => '',
            'owner_id' => Auth::user()->id,
            'state' => 1  // estado registrado,

        ]);

        //GUARDA EL ARCHIVO ADJUNTO
        $file = $request->file('attachments');

        if ($file != null) {
            $fileName = 'Iniciativa' . $datosInitiative->id . '.pdf';
            $file->storeAs('docs/initiatives', $fileName);

            Initiative::where('id', '=', $datosInitiative->id)->update([
                'attachments' => $fileName
            ]);
        }

        //Guardar criterios de acceptacion
        $acceptanceCriteria = $request->input('acceptance_criteria');

        if ($acceptanceCriteria != null) {
            foreach ($acceptanceCriteria as $criteria) {
                foreach ($criteria as $id_criteria => $criterio) {
                    // Hacer algo con cada clave y valor
                    initiative_criteria::create([
                        'criterio' => $criterio,
                        'initiative_id' => $datosInitiative->id
                    ]);
                }
            }
        }

        $message = "La iniciativa '" . $request->initiativeName . "' ha sido creada exitosamente por " . $user->name;
        return redirect()->route('initiative.index')->with('success', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Initiative  $initiative
     * @return \Illuminate\Http\Response
     */
    // 
    public function show($id)
    {
        Log::info('show');
        $initiative = Initiative::findOrFail($id);
        $criterias = initiative_criteria::where('initiative_id', $id)->get();
        $segment = RegServiceSegment::where('id', $initiative->segment_id)->first();
        $service_layer = RegServiceLayer::where('id', $initiative->service_layer_id)->first();
        $initiative_state = initiative_states::where('id', $initiative->state)->first();
        // MUESTRA EL USUARIO QUE CREA EL REGISTRO
        $user = User::where('id', $initiative->owner_id)->first();
        Log::info($segment);
        return view('initiative.show', compact('initiative', 'user', 'criterias', 'segment', 'service_layer', 'initiative_state'));
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Initiative  $initiative
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Obtener datos de la iniciativa
        $datosInitiative = Initiative::findOrFail($id);

        // Obtener segmentos y capas de servicio
        $segments = RegServiceSegment::orderBy('name')->get();
        $criterias = initiative_criteria::where('initiative_id', $id)->get();

        //Obtener las capas de servicio del segmento seleccionado
        $service_layers = RegServiceLayer::orderBy('name')->where('segment_id', $datosInitiative->segment_id)->get();

        // Pasar los datos a la vista
        return view('initiative.edit', compact('datosInitiative', 'segments', 'criterias', 'service_layers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Initiative  $initiative
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Log::info($request);
        $datosInitiative = $request->except(['_token', '_method']);

        Initiative::where('id', '=', $id)->update([
            'initiative_name' => $request->initiativeName,
            'segment_id' => $request->segment,
            'service_layer_id' => $request->service_layer,
            'how' => $request->how,
            'want' => $request->want,
            'for' => $request->for,
            'task_type' => $request->task_type,
            'automation_type' => $request->automation_type,
            'general_description' => $request->general_description,
            'execution_time_manual' => $request->execution_time_manual,
            'advantages' => $request->advantages,
            'owner_id' => Auth::user()->id
        ]);

        if ($request->attachments != null) {
            // GUARDA EL ARCHIVO ADJUNTO
            $fileName = 'Iniciativa' . $id . '.pdf';
            Log::info($fileName);
            $file = $request->file('attachments');
            Log::info($file);
            $file->storeAs('docs/initiatives', $fileName);
            Initiative::where('id', '=', $id)->update([
                'attachments' => $fileName
            ]);
        }

        $acceptanceCriteria = $request->input('acceptance_criteria');

        if ($acceptanceCriteria != null) {
            foreach ($acceptanceCriteria as $criteria) {
                foreach ($criteria as $id_criteria => $criterio) {
                    // Hacer algo con cada clave y valor
                    if ($id_criteria != 0) {
                        initiative_criteria::where('id', '=', $id_criteria)->update([
                            'criterio' => $criterio,
                            'initiative_id' => $id
                        ]);
                    } else {
                        initiative_criteria::create([
                            'criterio' => $criterio,
                            'initiative_id' => $id
                        ]);
                    }
                }
            }
        }

        return redirect()->route('initiative.index')->with(
            'success',
            'Iniciativa con id ' . $id . ' ha sido editada por ' .
                auth()->user()->name . ' con éxito.'
        );
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Initiative  $initiative
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $initiative = Initiative::findOrFail($id);
        $initiative->delete();
        return redirect()->back()->with(
            'success',
            'Iniciativa con id ' . $id . ' ha sido eliminada por ' . auth()->user()->name . ' con éxito.'
        );
    }
    public function file($attachments)
    {
        return response()->file(storage_path("app/public/docs/initiatives/$attachments"));
    }


    //VALIDACION DE ADMINISTRADOR PARA PERMISOS DE EDICION Y ELIMINACION DE INICIATIVA
    public function getlayers($id)
    {
        $layers = RegServiceLayer::where('segment_id', $id)->orderBy('name')->get(['id', 'name']);
        return $layers;
    }
}