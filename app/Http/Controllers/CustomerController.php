<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\customer;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $datos['Customer'] = customer::get();

      Log::info($datos);


        //
        // $vcostumer = vcustomer::all();
        return view('customer.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $datosCustomer = request()->except('_token');
    

    // Validar los datos del formulario
    $request->validate([
        'customerName' => 'required|string|max:255',
        'customerNIT' => 'required|string|max:255',
        'customerState' => 'required|string|max:255',
    ]);

    
    $datosCustomer = customer::create([
        'customerName' => $request->customerName,
        'customerNIT' => $request->customerNIT,
        'customerState' => $request->customerState,
    ]);

    Log::info($datosCustomer);
    // Obtener el ID del cliente recién creado
    $clienteId = $datosCustomer->id;

    // Redireccionar a alguna página después de guardar el cliente
    return redirect()->route('customer.index')->with('success', 'Cliente registrado exitosamente. ID del cliente: ' . $clienteId);
}


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = customer::findOrFail($id); // Encuentra el modelo por su ID
        return view('customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $datosCustomer = request()->except('_token');
    
{
        // Validar los datos del formulario
        $request->validate([
            'customerName' => 'required|string|max:255',
            'customerNIT' => 'required|string|max:255',
            'customerState' => 'required|string|max:255',
        ]);
            return redirect()->route('customer.index')->with(
                'success',
                'El registro con id ' . $id . ' ha sido editado por ' . auth()->user()->name . ' con éxito.');

    }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
     {
        Log::info($id);
        $customer = customer::where('customerID', $id)->delete();
    
        return redirect()->back()->with(
            'success',
            'Registro con id ' . $id . ' ha sido eliminada por ' . auth()->user()->name . ' con éxito.'
        );
     }
}
