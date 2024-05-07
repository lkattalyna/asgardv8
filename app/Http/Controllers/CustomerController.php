<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\customer_vcenter;
use App\Models\Customer; 
use App\Models\vcenter;
use App\Segment;
use App\Models\roles;
use Illuminate\Http\RedirectResponse;



class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datos['Customer'] = Customer::get();
       // Log::info($datos);

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
        // Validar los datos del formulario
        $request->validate([
            'customerName' => 'required|string|max:255',
            'customerNIT' => 'required|string|max:255',
            'customerState' => 'required|string|max:255',
        ]);
    
        // Verificar si el NIT ya existe
        $existingCustomer = Customer::where('customerNIT', $request->customerNIT)->exists();
    
        if ($existingCustomer) {
            return redirect()->back()->withInput()->withErrors(['customerNIT' => 'El NIT ingresado ya existe en nuestros registros.']);
        }
    
        // Si el NIT no existe, proceder con el guardado del cliente
        $customer = new Customer();
        $customer->customerName = $request->customerName;
        $customer->customerNIT = $request->customerNIT;
        $customer->customerState = $request->customerState;
        $customer->save();
    
        // Obtener el ID del cliente recién creado
        $customerID = $customer->customerID;
    
        // Redireccionar a alguna página después de guardar el cliente
        return redirect()->route('customer.index')->with('success', 'Cliente registrado exitosamente. ID del cliente: ' . $customerID);
    }
    public function edit($customerID)
    {
        $customer = Customer::where('customerID', $customerID)->firstOrFail();
        return view('customer.edit', compact('customer'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $customerID)
    {
        $request->validate([
            'customerName' => 'required|string|max:255',
            'customerNIT' => 'required|string|max:255',
            'customerState' => 'required|string|max:255',
        ]);

        $customer = Customer::where('customerID', $customerID)->firstOrFail(); // Aquí también ajustamos a customerID
        $customer->customerName = $request->customerName;
        $customer->customerNIT = $request->customerNIT;
        $customer->customerState = $request->customerState;
        $customer->save();

        // Obtener el ID del cliente recién creado
        $customerID = $customer->customerID;

        return redirect()->route('customer.index')->with(
            'success',
            'Cliente con id ' . $customerID . ' actualizado correctamente por '  . auth()->user()->name
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       // Log::info($id);
        $customer = Customer::where('customerID', $id)->delete();

        return redirect()->back()->with(
            'success',
            'Registro con id ' . $id . ' ha sido eliminado por ' . auth()->user()->name . ' con éxito.'
        );
    }
    /**
     * Show the form for editing the specified resource.
     *0
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show(Request $request, $customerID)
    {
        $Vcenter = vcenter::get();

        foreach ($Vcenter as $vcenter) {
            $segment = Segment::find($vcenter->fk_segmentID);
            $roles = roles::find($vcenter->rolesID);
            $vcenter->segment = $segment;
            $vcenter->roles = $roles;
        }
        
        $CustomerVcenters = customer_vcenter::where('fk_customerID', $customerID)->get();
        
        foreach ($CustomerVcenters as $vcenter) {
            $vcenterData = vcenter::where('vcenterID', $vcenter->fk_vcenterID)->firstOrFail();
            $vcenter->vcenterData = $vcenterData;
        }


        return view('customer.show', compact('Vcenter', 'customerID', 'CustomerVcenters'));
    }
    public function checkNit(Request $request)
    {
        $nit = $request->input('nit');

        $exists = Customer::where('customerNIT', $nit)->exists();

        return response()->json(['exists' => $exists]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response

     */
    public function guardarInformacion(Request $request, $customerID)
    {
        $vcenter_agregados = $request->input('vcenter_agregados');
        
        Log::Info($vcenter_agregados);

        if ($vcenter_agregados != null) 
        {
            foreach ($vcenter_agregados as $vcenter) {

                $exists = customer_vcenter::where('fk_customerID', $customerID)
                    ->where('fk_vcenterID', $vcenter['id'])->exists();

                if (!$exists)
                {
                    customer_vcenter::create([
                        'fk_customerID' => $customerID,
                        'fk_vcenterID' => $vcenter['id']
                    ]);
                }
                
            }
        }

        return redirect()->route('customer.index')->with(
            'success',
            'Se ha completado la segregación del id ' . $customerID . ' ejecutado por '  . auth()->user()->name
        );
    }
}