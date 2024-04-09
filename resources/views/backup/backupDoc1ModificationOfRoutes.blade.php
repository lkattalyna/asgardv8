@extends('adminlte::page')
@section('content_header')
    <h4>Modificación Rutas Política Backup DOC1</h4><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('backup-run')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{ route('backup.backupDoc1ModificationOfRoutesStore') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <div class="alert alert-info" role="alert">
                    Ingrese las rutas a respaldar, dar clic en el signo "+" para adicionar más de una ruta o dar clic en el signo "-" para eliminar una ruta.
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <td>
                                <label for="host">{{ __('Ruta(s)') }}</label>
                            </td>
                            <td>
                                <div class="input-content" id="input-content">
                                    <div class="input-group">
                                        <input type="text" name="RUTAS[]" id="destino" class="form-control"  style="width: 70%" placeholder="Ejemplo: /users/doc1v56/produccion-red/doc1fact/ciclos/20220344" required>
                                        <a class="btn btn-info" id="btn-add-input" style="float: right; color: white">+</a>
                                        <a class="btn btn-light ocultar btn-delete-input" id="btn-delete-input">-</a>
                                    </div>
                                </div>
                                <div id="divElements"></div>
                            </td>
                        </tr>
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
@section('css')
    <style>
        .ocultar{
        display:none;
    }
    </style>
@stop
@section('js')
  <script>

      function cambiarTipo(comboBox){
        let value = comboBox.value;
        const puertoNAME = document.querySelector("#puertoNAME");
        const puertoTR = document.querySelector("#puertoTR");
            $("#puertoNAME").val('');
            puertoNAME.toggleAttribute('disabled');
            puertoNAME.toggleAttribute('required');
            puertoTR.classList.toggle('d-none');
      }
        $(document).ready(function() {


            $('#group').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });
            $('#host').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });
            $("#group").change(function(){
                var grupo = $(this).val()
                $.get('getHosts/'+{{ $inventario }}+'/'+grupo+'/local', function(data){
                //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
                    var select = '<option value="'+grupo+'">Todos</option>'
                    for (var i=0; i<data.length;i++){
                        if(data[i] !== null){
                            select+='<option value="'+data[i]+'">'+data[i]+'</option>';
                        }
                    }
                    $("#host").html(select);
                });
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
            let $addInput = document.getElementById('btn-add-input');
            let $divElements = document.getElementById('divElements');

            $addInput.addEventListener('click',event=>{
                event.preventDefault();
                let $clonado = document.querySelector('.input-content');
                let $clon = $clonado.cloneNode(true);
                $divElements.appendChild($clon).classList.remove('input-content');
                let $remover = $divElements.lastChild.childNodes[1].querySelectorAll('a');
                let $clearInput = $divElements.lastChild.childNodes[1].querySelectorAll('input');
                $remover[0].classList.add('ocultar');
                $remover[1].classList.remove('ocultar');
                $clearInput[0].value="";
            });

            $divElements.addEventListener('click',event=>{
                event.preventDefault();

                if(event.target.classList.contains('btn-delete-input')){
                    let $contenedor= event.target.parentNode;
                    $contenedor.parentNode.removeChild($contenedor);
                }
            });
        });
    </script>
@stop



