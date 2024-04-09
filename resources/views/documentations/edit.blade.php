@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de edición de documentación</h1><hr>
@stop
@section('plugins.Select2', true)
@section('content')
    @can('documentation-edit')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('documentations.index')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @if($documentation->approval_status == 0 || Illuminate\Support\Facades\Auth::user()->id == $documentation->regImprovement->serviceLayer->leader_id ||
            \Illuminate\Support\Facades\Auth::user()->id == $documentation->regImprovement->serviceLayer->coordinator_id)
            @include('layouts.formError')
            <form action="{{ route('documentations.update', $documentation->id) }}" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}
                @method('PUT')
                <div class="card card-default">
                    <div class="card-header with-border">
                        <p>Este formulario permitirá editar la documentación básica y relevante
                            de cada una de las automatizaciones publicadas sobre el portal ASGARD.</p>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th>
                                    <label class="text-md-right">Id de la automatización</label>
                                </th>
                                <td>
                                    {{ $documentation->regImprovement->id }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label class="text-md-right">Nombre de la automatización</label>
                                </th>
                                <td>
                                    {{ $documentation->regImprovement->playbook_name }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label class="text-md-right">Descripción de la automatización</label>
                                </th>
                                <td>
                                    {{ $documentation->regImprovement->description }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label class="text-md-right">Objetivo de la automatización</label>
                                </th>
                                <td>
                                    {{ $documentation->regImprovement->objetive }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label class="text-md-right">Alcance de la automatización</label>
                                </th>
                                <td>
                                    {{ $documentation->regImprovement->scope }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="result" class="text-md-right">Resultado esperado</label>
                                </th>
                                <td>
                                    <div class="input-group">
                                        <textarea name="result" id="result" class="form-control" placeholder="Resultado esperado"
                                                  maxlength="200" rows="2" required>{{ $documentation->result }}</textarea>
                                        <div class="input-group-append">
                                            <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left"
                                                  title="Ayuda" data-content="Por favor describa de manera precisa qué es lo que se espera obtener o conseguir con la automatización a publicar.">
                                                <i class="fas fa-question-circle"></i>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="components" class="text-md-right">Componentes</label>
                                </th>
                                <td>
                                    <div class="input-group">
                                        <textarea name="components" id="components" class="form-control" placeholder="Ej: VMware, SQL Server, Power BI, etc."
                                                  maxlength="200" rows="2" required>{{ $documentation->components }}</textarea>
                                        <div class="input-group-append">
                                            <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left"
                                                  title="Ayuda" data-content="Por favor relacione los componentes tecnológicos que involucra la automatización a publicar.">
                                                <i class="fas fa-question-circle"></i>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="consumedService" class="text-md-right">Servicios consumidos</label>
                                </th>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left"
                                                  title="Ayuda" data-content="Si no esta registrado el servicio consumido en la lista por favor solicítelo via email
                                                   con el responsable de la documentación">
                                                <i class="fas fa-question-circle"></i>
                                            </span>
                                        </div>
                                        <select class="form-control" name="consumedService" id="consumedService" required>
                                            @foreach($consumedServices as $consumedService)
                                                <option value="{{ $consumedService->id }}" @if($documentation->consumed_service_id == $consumedService->id) selected @endif >{{ $consumedService->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="unrelated" class="text-md-right">Capas no relacionadas</label>
                                </th>
                                <td>
                                    <div class="input-group">
                                        <textarea name="unrelated" id="unrelated" class="form-control" placeholder="Si no se requiere consignar CAPA involucrada, escriba: Ninguna"
                                                  maxlength="200" rows="2" required>{{ $documentation->unrelated_layers }}</textarea>
                                        <div class="input-group-append">
                                            <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left"
                                                  title="Ayuda" data-content="Consigne nombre de la CAPA de servicio involucrada, cuando no esté relacionada en el punto anterior.">
                                                <i class="fas fa-question-circle"></i>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="parameterFlag" class="text-md-right">Parámetros</label>
                                </th>
                                <td>
                                    <select class="form-control" name="parameterFlag" id="parameterFlag" required>
                                        <option value="0" @if($documentation->parameters_flag == 0) selected @endif >No</option>
                                        <option value="1" @if($documentation->parameters_flag == 1) selected @endif >Si</option>
                                    </select>
                                </td>
                            </tr>
                            <tr id="parameterTR" @if(!$documentation->parameters_flag) style="display: none;" @endif>
                                <th>
                                    <label for="parameters" class="text-md-right">Nombre de los parámetros</label>
                                </th>
                                <td>
                                    <input type="text" name="parameters" id="parameters" class="form-control" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{2,}"
                                           placeholder="Ej: NombreVM, Hora, vCenter, etc." maxlength="100" value="{{ $documentation->parameters }}"
                                            @if(!$documentation->parameters_flag) disabled @endif>
                                </td>
                            </tr>
                            @if($documentation->approval_status == 0)
                                <tr>
                                    <th>
                                        <label for="docFlag" class="text-md-right">Se incluirá manual técnico</label>
                                    </th>
                                    <td>
                                        <select class="form-control" name="docFlag" id="docFlag" required>
                                            <option value="0" @if($documentation->tech_manual == 0) selected @endif >No</option>
                                            <option value="1" @if($documentation->tech_manual == 1) selected @endif >Si</option>
                                        </select>
                                    </td>
                                </tr>
                                @if($documentation->tech_manual == 1 && $documentation->tech_manual_link != 'N/A')
                                    <tr>
                                        <th>
                                            <label class="text-md-right">Manual técnico cargado</label>
                                        </th>
                                        <td>
                                            <a href="{{ route('documentations.file',$documentation->tech_manual_link) }}" title="Ver documento" target="_blank">
                                                <button class="btn btn-sm btn-default">
                                                    <i class="fa fa-eye" style="color: #0d6aad"></i>
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                                <tr id="trFile" @if($documentation->tech_manual == 0) style="display: none" @endif>
                                    <th>
                                        <label for="docFile" class="text-md-right">Agregar archivo</label>
                                    </th>
                                    <td>
                                        <input id="docFile" name="docFile" type="file" class="form-control" accept="application/pdf"
                                               @if($documentation->tech_manual == 0) value="N/A" @endif>

                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fa fa-save"></i> Guardar
                        </button>
                    </div>
                </div>
            </form>
        @endif
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    <script>
        $(document).ready(function(){
            $('[data-toggle="popover"]').popover();
            $("#parameterFlag").change(function(){
                var selected = $(this).val();
                if(selected == 0){
                    $("#parameterTR").hide();
                    $("#parameters").hide();
                    $("#parameters").prop('disabled',true);
                }else{
                    $("#parameterTR").show();
                    $("#parameters").show();
                    $("#parameters").prop('disabled',false);
                }
            });
            $("#docFlag").change(function(){
                var selectFile = $(this).val();
                if(selectFile == 0){
                    $("#trFile").hide();
                    $("#docFile").hide();
                }else{
                    $("#trFile").show();
                    $("#docFile").show();
                }
            });
        });
    </script>
@endsection

