@extends('adminlte::page')
@section('content_header')
    <h1 class="content-max-width">Reporte de actualizaciones</h1>
    <hr>
@stop
@section('content')
    @can('recursos-run')
    <div class="card card-default">
        <div class="card-body"></div>
    </div>
    @include('layouts.formError')
    <form action="{{ route('updatePacks.result') }}" method="POST" class="form-horizontal">
        {!! csrf_field() !!}
        <div class="card card-default">
            <div class="card-header with-border">
                <h3 class="card-title">Criterio de búsqueda</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="buscar" class="col-sm-2 control-label">Buscar por:</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="buscar" id="buscar" required>
                            <option disabled selected>--Seleccione--</option>
                            <option value="1">Código de servicio</option>
                            <option value="2">Fabricante</option>
                            <option value="3">Modelo de servidor</option>
                            <option value="4">Serie de servidor</option>
                            <option value="5">Clientes</option>
                            <option value="6">Servidores</option>
                        </select>
                    </div>
                </div>
                <div class="form-group" id="divCodServicio" style="display: none;">
                    <label for="cod_servicio" class="col-sm-2 control-label">Código de servicio:</label>
                    <div class="col-sm-10">
                        <input class="form-control" id="cod_servicio" name="cod_servicio" type="text" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" value="{{ old('cod_servicio') }}" disabled maxlength="20" required/>
                    </div>
                </div>
                <div class="form-group" id="divFabricante" style="display: none;">
                    <label for="fabricante" class="col-sm-2 control-label">Fabricante:</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="fabricante" id="fabricante" disabled required>
                            @foreach ($fabricantes as $fabricante)
                                <option value="{{ $fabricante->id }}">{{ $fabricante->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group" id="divSerie" style="display: none;">
                    <label for="serie" class="col-sm-2 control-label">Serie del servidor:</label>
                    <div class="col-sm-10">
                        <input class="form-control" id="serie" name="serie" type="text" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" value="{{ old('serie') }}" disabled maxlength="25" required/>
                    </div>
                </div>
                <div class="form-group" id="divModelo" style="display: none;">
                    <label for="modelo" class="col-sm-2 control-label">Modelo del servidor:</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="modelo" id="modelo" disabled required>
                            @foreach ($modelos as $modelo)
                                <option value="{{ $modelo->id }}">{{ $modelo->marca->nombre }} - {{ $modelo->modelo }} - {{ $modelo->generacion }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group" id="divCliente" style="display: none;">
                    <label for="cliente" class="col-sm-2 control-label">Clientes:</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="cliente" id="cliente" disabled required>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group" id="divServidores" style="display: none;">
                    <label for="cliente" class="col-sm-2 control-label">Servidores:</label>
                    <div class="col-sm-10">
                        <input class="form-control" id="servidores" name="servidores" type="text" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" value="" disabled maxlength="25"/>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-sm btn-danger">
                    <i class="fa fa-search"></i> Buscar
                </button>
            </div>
        </div>
    </form>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    <script>
        $(document).ready(function(){
            //$('#modelo').select2();
            $('#buscar').on('change', function(){
                var selectValue = $(this).val();
                switch (selectValue) {
                    case "1":
                    $("#divCodServicio").show();
                    $("#cod_servicio" ).prop( "disabled", false );
                    $("#divFabricante").hide();
                    $("#fabricante").prop( "disabled", true );
                    $("#divSerie").hide();
                    $("#serie").prop( "disabled", true );
                    $("#divModelo").hide();
                    $("#modelo").prop( "disabled", true );
                    $("#divCliente").hide();
                    $("#cliente").prop( "disabled", true );
                    $("#divServidores").hide();
                    $("#servidores").prop( "disabled", true );
                    break;
                    case "2":
                    $("#divCodServicio").hide();
                    $("#cod_servicio" ).prop( "disabled", true );
                    $("#divFabricante").show();
                    $("#fabricante").prop( "disabled", false );
                    $("#divSerie").hide();
                    $("#serie").prop( "disabled", true );
                    $("#divModelo").hide();
                    $("#modelo").prop( "disabled", true );
                    $("#divCliente").hide();
                    $("#cliente").prop( "disabled", true );
                    $("#divServidores").hide();
                    $("#servidores").prop( "disabled", true );
                    break;
                    case "3":
                    $("#divCodServicio").hide();
                    $("#cod_servicio" ).prop( "disabled", true );
                    $("#divFabricante").hide();
                    $("#fabricante").prop( "disabled", true );
                    $("#divSerie").hide();
                    $("#serie").prop( "disabled", true );
                    $("#divModelo").show();
                    $("#modelo").prop( "disabled", false );
                    $("#divCliente").hide();
                    $("#cliente").prop( "disabled", true );
                    $("#divServidores").hide();
                    $("#servidores").prop( "disabled", true );
                    break;
                    case "4":
                    $("#divCodServicio").hide();
                    $("#cod_servicio" ).prop( "disabled", true );
                    $("#divFabricante").hide();
                    $("#fabricante").prop( "disabled", true );
                    $("#divSerie").show();
                    $("#serie").prop( "disabled", false );
                    $("#divModelo").hide();
                    $("#modelo").prop( "disabled", true );
                    $("#divCliente").hide();
                    $("#cliente").prop( "disabled", true );
                    $("#divServidores").hide();
                    $("#servidores").prop( "disabled", true );
                    break;
                    case "5":
                    $("#divCodServicio").hide();
                    $("#cod_servicio" ).prop( "disabled", true );
                    $("#divFabricante").hide();
                    $("#fabricante").prop( "disabled", true );
                    $("#divSerie").hide();
                    $("#serie").prop( "disabled", true );
                    $("#divModelo").hide();
                    $("#modelo").prop( "disabled", true );
                    $("#divCliente").show();
                    $("#cliente").prop( "disabled", false );
                    $("#divServidores").hide();
                    $("#servidores").prop( "disabled", true );
                    break;
                    case "6":
                    $("#divCodServicio").hide();
                    $("#cod_servicio" ).prop( "disabled", true );
                    $("#divFabricante").hide();
                    $("#fabricante").prop( "disabled", true );
                    $("#divSerie").hide();
                    $("#serie").prop( "disabled", true );
                    $("#divModelo").hide();
                    $("#modelo").prop( "disabled", true );
                    $("#divCliente").hide();
                    $("#cliente").prop( "disabled", true );
                    $("#divServidores").show();
                    $("#servidores").prop( "disabled", true );
                    break;

                }
            });
        });
    </script>
@stop
