@extends('adminlte::page')
@section('content_header')
    <h1>Formulario de corecciones de check paso a operación {{ $type->type }}</h1><hr>
@stop
@section('plugins.Sweetalert2', true)
@section('content')
    @can('virtualization-run')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('virtualization.checkVMRepairSearch')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{route('virtualization.checkVMRepairStore') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de corecciones de check paso a operación {{ $type->type }}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>
                                <label class="text-md-right">Nombre del proceso</label>
                            </th>
                            <th>
                                <label class="text-md-right">Estado</label>
                            </th>
                            <th>
                                <label for="repair" class="text-md-right">Corrregir</label>
                            </th>
                        </tr>
                        @foreach ($items as $item)
                            <tr>
                                <td>
                                    {{ $item->description }}
                                </td>
                                <td
                                @if($item->status == 0)
                                    @if($item->item == 2 || $item->item == 3 || $item->item == 4 )
                                        class="bg-danger"
                                    @else
                                        class="bg-warning"
                                    @endif
                                @elseif($item->status == 1)
                                    class="bg-success"
                                @endif>
                                    @if($item->status == 0)
                                        @if($item->item == 2 || $item->item == 3 || $item->item == 4 )
                                            Pendiente por corregir (Requiere reinicio)
                                        @else
                                            Pendiente por corregir
                                        @endif
                                    @elseif($item->status == 1)
                                        Corregido
                                    @endif
                                </td>
                                <td>
                                    @if($item->status == 0)
                                        <input type="checkbox" name="repair[]" id="repair-{{ $item->item }}"  value="{{ $item->id }}" >
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        <input type="hidden" name="type" id="type" value="{{ $type->type }}">
                        <input type="hidden" name="id" id="id" value="{{ $id_asgard }}">
                        <input type="hidden" name="name" id="name" value="{{ $name }}">
                    </table>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-sm btn-danger" id="sendForm">
                        <i class="fa fa-terminal"></i> Ejecutar
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
        $(document).ready(function () {
            $('#formfield').keypress(function(e) {
                if (e.which == 13) {
                    return false;
                }
            });
            $('#sendForm').on('click', function(){
                swal({
                    title: "¿Esta seguro?",
                    text: "Esta completamente seguro de ejecutar la tarea con los parametros seleccionados",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    buttons: ["Cancelar", "Si, estoy seguro"],
                }).then((seguro) => {
                    if (seguro) {
                        if($('#formfield')[0].checkValidity()){
                            $('#formfield').submit();
                        }else{
                            $('#formfield')[0].reportValidity();
                        }
                    }
                });
            });
        });
    </script>
@endsection
