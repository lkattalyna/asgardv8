@extends('adminlte::page')

@section('content_header')
    <h1>Dashboard</h1><hr>
@stop
@section('plugins.Chartjs', true)
@section('content')
    <p>Bienvenido {{ Auth::user()->email  }}</p>
    <div class="row">

    </div>
@stop
@section('js')
<script>
    var botmanWidget = {
        chatServer: "/asgard/botman",
        frameEndpoint: "botman/chat",
        title: "Chat de ayuda",
        aboutText: 'Claro',
        introMessage: "✋ Hola! Soy Loki y sere tu ayudante dentro del portal de Asgard",
        placeholderText: "Enviar mensaje",
        mainColor: "#DA291C",
        bubbleBackground: "#DA291C"
    };
</script>
<script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>
@stop

