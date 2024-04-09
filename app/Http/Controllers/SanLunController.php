<?php

namespace App\Http\Controllers;

use App\SanLun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SanLunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $query = DB::table('san_luns')->orderBy('service_code');
            return DataTables::queryBuilder($query)->toJson();
        }else{
            #return view('san.inventories.lun.index', compact('items'));
            return view('san.inventories.lun.index');
        }
        //$items = SanLun::orderBy('service_code')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SanLun  $sanLun
     * @return \Illuminate\Http\Response
     */
    public function show(SanLun $sanLun)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SanLun  $sanLun
     * @return \Illuminate\Http\Response
     */
    public function edit(SanLun $sanLun)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SanLun  $sanLun
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SanLun $sanLun)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SanLun  $sanLun
     * @return \Illuminate\Http\Response
     */
    public function destroy(SanLun $sanLun)
    {
        //
    }
}
