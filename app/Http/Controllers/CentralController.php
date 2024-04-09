<?php

namespace App\Http\Controllers;

use App\Central;
use Illuminate\Http\Request;
use App\Http\Traits\ConnectionTrait;
use Illuminate\Support\Facades\View;


class CentralController extends Controller
{
    //
    Use ConnectionTrait;

    public function commvault(Request $request){

        $customers = Central::distinct('commvaultClientName')->get('commvaultClientName');
        //dd($customers);
        $view =  view('analytics.central',compact('customers'));
        if($request->ajax()){
            if ($request->has("customer") && $request->has("f_ini") && $request->has("f_fin")){
                if($request->input('customer') == 'todos'){
                    $logs = Central::whereBetween('commvaultStartDate',[$request->input('f_ini'),$request->input('f_fin')])->get();
                }else{
                    $logs = Central::where('commvaultClientName',$request->input('customer'))->whereBetween('commvaultStartDate',[$request->input('f_ini'),$request->input('f_fin')])->get();
                }
                $view = View::make('analytics.centralRs',compact('logs'));
                $sections = $view->renderSections();
                return response()->json($sections['contentPanel']);
            }
        }else return $view;

    }
}
