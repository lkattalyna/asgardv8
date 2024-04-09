@extends('adminlte::page')
@section('content_header')
    <h1> Configuración de reporte de monitoreo de estado de puertos</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    @can('san-run')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right" id="btn_table">
                    <a href="#" data-toggle="modal" data-target="#edit-modal">
                        <button class="btn btn-sm btn-danger">
                            <i class="fa fa-edit"></i>Editar Umbrales
                        </button>
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.messages')
        @include('layouts.formError')
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header">
                <h3 class="card-title">Configuración de reporte de monitoreo de estado de puertos</h3>
            </div>
            <!-- /.card-body -->
            <div class="card-body">
                <!-- /.table-responsive -->
                <table id="example1" class="table table-striped table-bordered" style="width:100%">
                    <tr>
                        <th>Frames_tx</th>
                        <td>{{ $data->frames_tx }}</td>
                    </tr>
                    <tr>
                        <th>Frames_rx</th>
                        <td>{{ $data->frames_rx }}</td>
                    </tr>
                    <tr>
                        <th>Enc_in</th>
                        <td>{{ $data->enc_in }}</td>
                    </tr>
                    <tr>
                        <th>Crc_err</th>
                        <td>{{ $data->crc_err }}</td>
                    </tr>
                    <tr>
                        <th>Crc_g_eof</th>
                        <td>{{ $data->crc_g_eof }}</td>
                    </tr>
                    <tr>
                        <th>Too_shrt</th>
                        <td>{{ $data->too_shrt }}</td>
                    </tr>
                    <tr>
                        <th>Too_long</th>
                        <td>{{ $data->too_long }}</td>
                    </tr>
                    <tr>
                        <th>Bad_eof</th>
                        <td>{{ $data->bad_eof }}</td>
                    </tr>
                    <tr>
                        <th>Enc_out</th>
                        <td>{{ $data->enc_out }}</td>
                    </tr>
                    <tr>
                        <th>Disc_c3</th>
                        <td>{{ $data->disc_c3 }}</td>
                    </tr>
                    <tr>
                        <th>Link_fail</th>
                        <td>{{ $data->link_fail }}</td>
                    </tr>
                    <tr>
                        <th>Loss_sync</th>
                        <td>{{ $data->loss_sync }}</td>
                    </tr>
                    <tr>
                        <th>Loss_sig</th>
                        <td>{{ $data->loss_sig }}</td>
                    </tr>
                    <tr>
                        <th>Frjt</th>
                        <td>{{ $data->frjt }}</td>
                    </tr>
                    <tr>
                        <th>Fbsy</th>
                        <td>{{ $data->fbsy }}</td>
                    </tr>
                    <tr>
                        <th>C3_timeout_tx</th>
                        <td>{{ $data->c3_timeout_tx }}</td>
                    </tr>
                    <tr>
                        <th>C3_timeout_rx</th>
                        <td>{{ $data->c3_timeout_rx }}</td>
                    </tr>
                    <tr>
                        <th>Pcs_err</th>
                        <td>{{ $data->pcs_err }}</td>
                    </tr>
                    <tr>
                        <th>Uncor_err</th>
                        <td>{{ $data->uncor_err }}</td>
                    </tr>
                    <tr>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- Attachment Modal -->
        <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="edit-modal-label">Editar umbrales de configuración del reporte</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body" id="attachment-body-content">
                <form id="edit-form" class="form-horizontal" method="POST" action="{{ route('san.configPortReportStore') }}">
                    {!! csrf_field() !!}
                    <div class="card mb-0">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="col-form-label" for="frames_tx">frames_tx</label>
                            <input type="number" name="frames_tx" class="form-control" id="frames_tx" value="{{ $data->frames_tx }}" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="frames_rx">frames_rx</label>
                            <input type="number" name="frames_rx" class="form-control" id="frames_rx" value="{{ $data->frames_rx }}" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="enc_in">enc_in</label>
                            <input type="number" name="enc_in" class="form-control" id="enc_in" value="{{ $data->enc_in }}" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="crc_err">crc_err</label>
                            <input type="number" name="crc_err" class="form-control" id="crc_err" value="{{ $data->crc_err }}" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="crc_g_eof">crc_g_eof</label>
                            <input type="number" name="crc_g_eof" class="form-control" id="crc_g_eof" value="{{ $data->crc_g_eof }}" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="too_shrt">too_shrt</label>
                            <input type="number" name="too_shrt" class="form-control" id="too_shrt" value="{{ $data->too_shrt }}" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="too_long">too_long</label>
                            <input type="number" name="too_long" class="form-control" id="too_long" value="{{ $data->too_long }}" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="bad_eof">bad_eof</label>
                            <input type="number" name="bad_eof" class="form-control" id="bad_eof" value="{{ $data->bad_eof }}" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="enc_out">enc_out</label>
                            <input type="number" name="enc_out" class="form-control" id="enc_out" value="{{ $data->enc_out }}" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="disc_c3">disc_c3</label>
                            <input type="number" name="disc_c3" class="form-control" id="disc_c3" value="{{ $data->disc_c3 }}" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="link_fail">link_fail</label>
                            <input type="number" name="link_fail" class="form-control" id="link_fail" value="{{ $data->link_fail }}" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="loss_sync">loss_sync</label>
                            <input type="number" name="loss_sync" class="form-control" id="loss_sync" value="{{ $data->loss_sync }}" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="loss_sig">loss_sig</label>
                            <input type="number" name="loss_sig" class="form-control" id="loss_sig" value="{{ $data->loss_sig }}" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="frjt">frjt</label>
                            <input type="number" name="frjt" class="form-control" id="frjt" value="{{ $data->frjt }}" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="fbsy">fbsy</label>
                            <input type="number" name="fbsy" class="form-control" id="fbsy" value="{{ $data->fbsy }}" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="c3_timeout_tx">c3_timeout_tx</label>
                            <input type="number" name="c3_timeout_tx" class="form-control" id="c3_timeout_tx" value="{{ $data->c3_timeout_tx }}" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="c3_timeout_rx">c3_timeout_rx</label>
                            <input type="number" name="c3_timeout_rx" class="form-control" id="c3_timeout_rx" value="{{ $data->c3_timeout_rx }}" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="pcs_err">pcs_err</label>
                            <input type="number" name="pcs_err" class="form-control" id="pcs_err" value="{{ $data->pcs_err }}" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="uncor_err">uncor_err</label>
                            <input type="number" name="uncor_err" class="form-control" id="uncor_err" value="{{ $data->uncor_err }}" required>
                        </div>
                    </div>
                    </div>
                </form>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="btn-ok">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
            </div>
        </div>
        <!-- /Attachment Modal -->
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
<script>
    $(document).ready(function () {
        $('#edit-modal').on('show.bs.modal', function (e) {
            $(this).find('#btn-ok').on('click', function () {
                if($('#edit-form')[0].checkValidity()){
                    $("#edit-form").submit();
                }else{
                    $('#edit-form')[0].reportValidity();
                }

            });
        });
    });
</script>
@stop
