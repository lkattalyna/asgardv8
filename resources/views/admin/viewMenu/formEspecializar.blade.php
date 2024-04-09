<form action="{{ route('admin.menu.especializar') }}" method="post">
    {!! csrf_field() !!}
    @method('POST')
    <div class="card card-default">
        <div class="card-header with-border">
            <h3 class="card-title">Formulario de Especialización de menús</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <tr>
                    <th>
                        <label for="inventario" class="text-md-right">Inventario</label>
                        <input type="text" hidden name="id_menu" value="{{$menuPadre->id}}">
                    </th>
                    <td>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-bars"></i></span>
                            </div>
                            <select class="form-control" name="inventario" id="inventario">
                                @foreach($inventarios as $inventario)
                                    <option {{ isset($menuView) ? ($menuView->inventario == $inventario->id_inventory)? 'selected':'' : ''}} value="{{$inventario->id_inventory}}">{{$inventario->id_inventory}} - {{$inventario->name_inventory}}</option>
                                @endforeach
                            </select>
                            <!-- <input class="form-control" value="{{ isset($menuView) ? $menuView->inventario : ''}}" name="inventario" id="inventario" /> -->
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="email" class="text-md-right">Grupo</label>
                    </th>
                    <td>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-check-circle"></i></span>
                            </div>
                            <!-- <input class="form-control" name="grupo" id="grupo" value="{{ isset($menuView) ? $menuView->grupo : ''}}"/> -->
                            <select class="form-control" name="grupo" id="grupo">
                            
                            </select>
                        </div>
                    </td>
                </tr>                                                                                     
                <tr>
                    <th>
                        <label for="template" class="text-md-right">id template</label>
                    </th>
                    <td>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-check-circle"></i></span>
                            </div>
                            <input class="form-control" name="template_playbook" id="template_playbook" value="{{ isset($menuView) ? $menuView->template_playbook : ''}}" />
                        </div>
                    </td>
                </tr>                                    
            </table>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-sm btn-danger">
                <i class="fa fa-save"></i> Actualizar
            </button>
        </div>
    </div>
</form>
@section('plugins.Select2', true)
@section('js')
    
<script>
    let firstTime = "{{ isset($menuView) ? true:false }}";
    $(document).ready(function() {
        

        $('#inventario').select2({
            placeholder: "--Seleccione--",
            allowClear: true
        });


        $('#grupo').select2({
            placeholder: "--Seleccione--",
            allowClear: true
        });


        $("#inventario").change(function(){
                let inventario = $(this).val();



        let parametros = {
            _token : $('meta[name="csrf-token"]').attr('content'),
            inventario

        };

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ route('global.get' ,[ 'automatizacion' => 'getGroups' ])}} ",
            type: 'post',
            data: parametros,
            success: function(data) {
                let select = "";
                for (var i=0; i<data.length;i++){
                        if(data[i]["name_group"] !== null){
                            if( firstTime ){                         
                                let seleccionado = "{{ isset($menuView) ? $menuView->grupo: '-n' }}";
                                select+=`<option value="${data[i]['id_group']}" ${ seleccionado == data[i]['id_group'] ? 'selected':'' }>${data[i]["id_group"]} - ${data[i]["name_group"]} </option>`;

                            }else{
                                select+='<option value="'+data[i]["id_group"]+'">'+data[i]["name_group"]+'</option>';
                            }
                        }
                }
                firstTime = false;
                $("#grupo").html(select);
            }
        });

        
          
        });
        
        
        
        $("#inventario").trigger("change");        
    })
</script>
@endsection
