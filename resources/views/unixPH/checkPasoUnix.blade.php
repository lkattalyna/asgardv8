@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de check de paso a operación unix</h1><hr>
@stop
@section('plugins.Sweetalert2', true)
@section('plugins.Papaparse', true)
@section('content')
    @can('unixPH-run')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{ route('unixPH.checkPasoUnixStore') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de check de paso a operación unix</h3>
                </div>
                <div class="card-body" id="parsed_csv_list">
                    <input type="hidden" id="hosts" name="hosts" required>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-sm btn-danger" id="sendForm">
                        <i class="fa fa-terminal"></i> Ejecutar
                    </button>
                </div>
            </div>
        </form>
        <div class="card card-default">
            <div class="card-header with-border">
                <h3 class="card-title">Para un correcto funcionamiento del archivo se debe evitar que el mismo contenga saltos de línea o espacios vacíos</h3>
            </div>
            <form>
                <div class="card-body">
                    <table class='table table-bordered table-hover'>
                        <tr>
                            <th>
                                <label for="files">Upload a CSV formatted file:</label>
                            </th>
                            <td>
                                <input type="file" id="files" class="form-control" accept=".csv" required />
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <button type="submit" id="submit-file" class="btn btn-sm btn-danger">Upload File</button>
                </div>
            </form>
        </div>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    <script>
        $(document).ready(function() {
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
            $('#submit-file').on("click",function(e){
                e.preventDefault();
                console.log('evento lanzado');
                $('#files').parse({
                    config: {
                        delimiter: "auto",
                        complete: displayHTMLTable,
                    },
                    before: function(file, inputElem)
                    {
                        console.log("Parsing file...", file);
                    },
                    error: function(err, file)
                    {
                        console.log("ERROR:", err, file);
                    },
                    complete: function()
                    {
                        console.log("Done with all files");
                    }
                });
            });
            function displayHTMLTable(results) {
                console.log('creando tabla');
                var table = "<table class='table table-bordered table-hover'>";
                table += "<tr><th class='text-center'>Servidores sobre los cuales se ejecutara el proceso</th></tr>";
                var data = results.data;
                for (i = 0; i < data.length; i++) {
                    var row = data[i];
                    var cleanData ='';
                    var k = 0;
                    var cells = row.join(",").split(",");
                    for (j = 0; j < cells.length; j++) {
                        console.log(cells[j]);
                        if(validateIp(cells[j])){
                            if(k == 0){
                                cleanData  += cells[j];
                            }else{
                                cleanData  += ','+cells[j];
                            }
                            table += "<tr><td>";
                            table += cells[j];
                            table += "</td></tr>";
                            k++;
                        }
                    }
                }
                $("#hosts").val(cleanData);
                table += "</table>";
                $("#parsed_csv_list").append(table);
            }
            function validateIp(ip) {
                var patronIp = new RegExp(
                    "^([0-9]{1,3}).([0-9]{1,3}).([0-9]{1,3}).([0-9]{1,3})$"
                );
                var valores;
                // early return si la ip no tiene el formato correcto.
                if (ip.search(patronIp) !== 0) {
                    return false;
                }
                valores = ip.split(".");
                return (
                    valores[0] <= 255 &&
                    valores[1] <= 255 &&
                    valores[2] <= 255 &&
                    valores[3] <= 255
                );
            }
        });
    </script>
@stop


