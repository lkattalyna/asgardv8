<?php

namespace App\Http\Controllers;

use App\SomUser;
use Illuminate\Http\Request;
use App\Http\Traits\ConnectionTrait;
use Illuminate\Support\Facades\View;

class SomController extends Controller
{
    Use ConnectionTrait;

    public function reportesom(Request $request)
    {
        $customers = SomUser::distinct('loginname')->get('loginname');
        //dd($customers);
        $view =  view('som.reportesom',compact('customers'));
        if($request->ajax()){
            if ($request->has("customer") && $request->has("f_ini") && $request->has("f_fin")){
                if($request->input('customer') == 'todos'){
                    $logs = SomUser::whereBetween('ing_date',[$request->input('f_ini'),$request->input('f_fin')])->get();
                }else{
                    $logs = SomUser::where('loginname',$request->input('customer'))->whereBetween('ing_date',[$request->input('f_ini'),$request->input('f_fin')])->get();
                }
                $view = View::make('som.reportesomRs',compact('logs'));
                $sections = $view->renderSections();
                return response()->json($sections['contentPanel']);
            }
        }else return $view;
    }

    public function checkmaquinavirtual(Request $request)
    {
        $view =  view('virtualizations.diagnostic');
        if($request->ajax()){
            if ($request->has("cod")){
                $hosts = VirtualHost::where('name','like',"%$request->cod%")->get();
                $view = View::make('virtualizations.table',compact('hosts'));
                $sections = $view->renderSections();
                return response()->json($sections['contentPanel']);
            }
        }else return $view;
    }
}
