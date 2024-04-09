@extends('adminlte::page')
@section('content')
    @can('executionLog-show')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-left">
                           <b>Fecha de ejecución en Asgard:</b>
                            {{ $executionLog->created_at }}
                </div>
                <div class="float-sm-right">
                    <button class="btn btn-sm btn-danger" onclick="intentarImprimir(this)">
                        <i class="fa fa-book"></i> PDF(Beta)
                    </button>
                    <a class="btn btn-sm btn-danger" href="{{ route('executionLogs.show', $executionLog->id) }}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        <div class="card card-default">
            <div class="card-header with-border" style="background: #dfe1e4;">
                <h3 class="card-title">Resultado del trabajo</h3>
            </div>
            <div class="card-body">
               <!-- probando -->

                {{-- {{ $executionLog->link }} --}}
                <div class="embed-responsive embed-responsive-21by9">

                    <iframe id="iframe" class="embed-responsive-item" src="{{ $executionLog->link }}"></iframe>
                </div>
            </div>

        </div>
        <script>

            function intentarImprimir(referencia){
                const oldStr = document.body.innerHTML;
                const iframe = document.querySelector("#iframe");
                const y = (iframe.contentWindow || x.contentDocument);
                let head = y.document.head.innerHTML;

                let body = y.document.body.innerHTML;
                let finalHtml = `<html><head>${head}</head><body>${body}</body></html>`;
                finalHtml = finalHtml.replaceAll("cid:att","");
                document.body.innerHTML = finalHtml;
                window.print();
                document.body.innerHTML = oldStr;
                return false;

            }

            function descargarPDF(){
                const doc = new jsPDF();
                const iframe = document.querySelector("#iframe");
                const y = (iframe.contentWindow || x.contentDocument);
                // if(y.document) y =  y.document;
                // let titulo = y.
                let head = y.document.head.innerHTML;

                let body = y.document.body.innerHTML;
                let finalHtml = `<html><head>${head}</head><body>${body}</body></html>`;
                finalHtml = finalHtml.replaceAll("cid:att","");
                // let finalHtml = "<h1>hola</h1>";
                console.log(finalHtml);
                // console.log(document.querySelector("#iframe").contentDocument.document.body.innerHTML);

                // console.log(.contentDocument.document.body.innerHTML);
                // var elementHTML = $('#content').html();
                // var specialElementHandlers = {
                //     '#elementH': function (element, renderer) {
                //         return true;
                //     }
                // };
                doc.fromHTML(finalHtml, 15, 15);

                // // Save the PDF
                doc.save('reporte.pdf');
            }
        </script>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop

