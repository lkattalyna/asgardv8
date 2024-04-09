@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de creación de requerimientos de desarrollo</h1><hr>
@stop
@section('content')
    @can('devRequest-create')
        @if(\Illuminate\Support\Facades\Auth::user()->id == $devRequest->client_id)
            @include('layouts.messages')
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Campos del requerimiento</h3>
                </div>
                <div class="card-body">
                    @if($devRequest->fields->count() > 0)
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th>Titulo</th>
                                <th>Tipo</th>
                                <th>Nombre</th>
                                <th>Acciones</th>
                            </tr>
                            @foreach($devRequest->fields as $field)
                                <tr>
                                    <td>{{ $field->title }}</td>
                                    <td>{{ $field->field_type }}</td>
                                    <td>{{ $field->name }}</td>
                                    <td>
                                        <a title="Eliminar" href="{{ route('devRequestFields.remove',[$devRequest->id,$field->field_id]) }}">
                                            <i class="fa fa-trash" style="color: #ff0000;"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        El requerimiento no tiene campos asignados aún
                    @endif
                </div>
            </div>
            @include('layouts.formError')
            <form action="{{ route('devRequestFields.store',$devRequest->id) }} " method="post">
                {!! csrf_field() !!}
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Agregar campo</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th>
                                    <label for="title" class="text-md-right">Titulo</label>
                                </th>
                                <td>
                                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" placeholder="Titulo" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{2,50}" maxlength="50" required>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="name" class="text-md-right">Nombre</label>
                                </th>
                                <td>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="Nombre" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{2,20}" maxlength="20" required>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="type" class="text-md-right">Tipo de campo</label>
                                </th>
                                <td>
                                    <select name="type" id="type" class="form-control" required>
                                        <option value="CheckBox">CheckBox</option>
                                        <option value="Email">Email</option>
                                        <option value="Number">Number</option>
                                        <option value="Otro">Otro</option>
                                        <option value="Radio">Radio</option>
                                        <option value="Select">Select</option>
                                        <option value="Select Multiple">Select Multiple</option>
                                        <option value="Text">Text</option>
                                        <option value="TextArea">TextArea</option>
                                        <option value="Variable">Variable</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="comment" class="text-md-right">Comentarios</label>
                                </th>
                                <td>
                                    <textarea name="comment" id="comment" class="form-control" placeholder="Comentarios (Opcional)"
                                              maxlength="150" rows="2">{{ old('comment') }}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label class="text-md-right">Campo requerido</label>
                                </th>
                                <td>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="requiredF" name="required" value="0" checked>
                                        <label for="requiredF" class="custom-control-label">No</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="requiredT" name="required" value="1">
                                        <label for="requiredT" class="custom-control-label">Si</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label class="text-md-right">Campo es variable</label>
                                </th>
                                <td>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="variableF" name="variable" value="0" checked>
                                        <label for="variableF" class="custom-control-label">No</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="variableT" name="variable" value="1">
                                        <label for="variableT" class="custom-control-label">Si</label>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fa fa-save"></i> Guardar campo
                        </button>
                    </div>
                </div>
            </form>
            <form action="{{ route('devRequests.update',$devRequest->id) }} " method="post">
                {!! csrf_field() !!}
                @method('PUT')
                <div class="card card-default">
                    <div class="card-body">
                        Finalizar el requerimiento
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fa fa-save"></i> Finalizar y guardar el requerimiento
                        </button>
                    </div>
                </div>
            </form>
        @else
            @include('layouts.forbidden_1')
        @endif
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop


