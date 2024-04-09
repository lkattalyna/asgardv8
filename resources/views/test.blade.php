@extends('adminlte::page')

@section('content_header')
    <h1>Dashboard</h1><hr>
@stop
@section('content')
    <a href="{{ route('files.get',[$folder, $file]) }}"><button>Archivo</button></a>
@stop
