<?php
namespace App\Http\Controllers;

Class recursosTecnologicosController extends Controller
{
    function showCargueInsumo(){
        $saludo = 'Hola mundo';
        return view('recursosTecnologicos.cargueInsumo');
    }
}
