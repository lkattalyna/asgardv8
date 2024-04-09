<?php

namespace App\Http\Controllers;

use App\TelLogUser;
use Illuminate\Http\Request;
use App\Http\Traits\ConnectionTrait;
use Illuminate\Support\Facades\View;

class TelephonyController extends Controller
{
    Use ConnectionTrait;

    public function logUserAvaya(Request $request)
    {
        $customers = TelLogUser::distinct('loginname')->get('loginname');
        //dd($customers);
        $view =  view('telephony.logUserAvaya',compact('customers'));
        if($request->ajax()){
            if ($request->has("customer") && $request->has("f_ini") && $request->has("f_fin")){
                if($request->input('customer') == 'todos'){
                    $logs = TelLogUser::whereBetween('ing_date',[$request->input('f_ini'),$request->input('f_fin')])->get();
                }else{
                    $logs = TelLogUser::where('loginname',$request->input('customer'))->whereBetween('ing_date',[$request->input('f_ini'),$request->input('f_fin')])->get();
                }
                $view = View::make('telephony.logUserAvayaRs',compact('logs'));
                $sections = $view->renderSections();
                return response()->json($sections['contentPanel']);
            }
        }else return $view;
    }
}
