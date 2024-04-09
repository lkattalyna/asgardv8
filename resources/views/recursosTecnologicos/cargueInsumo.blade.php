@extends('adminlte::page')
@section('content_header')
    <h2>Cargue Insumos</h2>
@stop
@section('plugins.Papaparse', true)
@section('content')
    @can('unixEN-run')
        <div class="card card-default">
            <div class="card-header with-dorder">
                <h4 class="card-title">Cargue Insumo</h4>
            </div>
            <form>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>
                                <label for="files">Upload:</label>
                            </th>
                            <td>
                                <input type="file" id="files" class="form-control" accept="xlsx" required>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <button type="submit" id="submit-file" class="btn btn-sm btn-danger">Upload File</button>
                </div>
            </form>
        </div>
    @endcan
@stop

@section('js')
    <script>
        $('#submit-file').on('click',function(e){
            e.preventDefault();
            console.log('Evento lanzado.');
            $('#files').parse({
                config:{
                    delimiter:"auto",
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
    </script>
@stop
