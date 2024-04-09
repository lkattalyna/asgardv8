<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\VirtualHost;
use Illuminate\Http\Request;
use App\Http\Resources\V1\VirtualResource;

class VirtualController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$servers = VirtualHost::all();
       // $servers = VirtualHost::where('name','like',"%$server%")->get();

        //return $servers;
        return VirtualResource::collection(VirtualHost::latest()->paginate());
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
     * @param  \App\VirtualHost  $virtualHost
     * @return \Illuminate\Http\Response
     */
    public function show(VirtualHost $virtualHost)
    {
        //
        //$hosts = VirtualHost::where('name','like',"%$virtualHost%")->count();
        //$hosts =  VirtualHost::all();
        //ServerResource::collection($servers);
        return new VirtualResource($virtualHost);
        //return VirtualResource::collection($hosts);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VirtualHost  $virtualHost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VirtualHost $virtualHost)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VirtualHost  $virtualHost
     * @return \Illuminate\Http\Response
     */
    public function destroy(VirtualHost $virtualHost)
    {
        //
    }
}
