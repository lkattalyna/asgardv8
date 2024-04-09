@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('content_header')
    <h1>UCMDB Topology</h1>
@stop
@section('content')
        <h5>CIS</h5>
        <div id="tableCisHere"></div>
        <h5>RELATIONS</h5>
        <div id="tableRelationHere"></div>
@stop

@section('js')
<script>
    const data = @json($data);
    console.log(data);

    $(document).ready(
    function(){
            showTableCis();
            showTableRelation();
            createTable();
        }
   );
   function showTableCis(){
        let html = ` `;
            html += `<table id="tableCis" class="table table-striped table-bordered" style="width:100%">`;
            html += `    <thead>`;
            html += `       <tr>`;
            html += `           <th>ucmdbId</th>`;
            html += `           <th>type</th>`;
            html += `           <th>properties</th>`;
            html += `           <th>label</th>`;
            html += `           <th>globalId</th>`;
            html += `           <th>displayLabel</th>`;
            html += `           <th>attributesQualifiers</th>`;
            html += `       </tr>`;
            html += `    </thead>`;
            html += `    <tbody>`;
            for(let item of data.cis){
                html += `   <tr>`;
                html += `       <td>${item.ucmdbId}</td>`;
                html += `       <td>${item.type}</td>`;
                html += `       <td>${item.properties.display_label}</td>`;
                html += `       <td>${item.label}</td>`;
                html += `       <td>${item.globalId}</td>`;
                html += `       <td>${item.displayLabel}</td>`;
                html += `       <td>${item.attributesQualifiers}</td>`;
                html += `   </tr>`;
            }
            html += `    </tbody>`;
            html += `</table>`;
        $('#tableCisHere').html(html);
    }
    function showTableRelation(){
        let html = ` `;
            html += `<table id="tableRelations" class="table table-striped table-bordered" style="width:100%">`;
            html += `    <thead>`;
            html += `       <tr>`;
            html += `           <th>ucmdbId</th>`;
            html += `           <th>type</th>`;
            html += `           <th>properties</th>`;
            html += `           <th>label</th>`;
            html += `           <th>globalId</th>`;
            html += `           <th>end1Id</th>`;
            html += `           <th>end2Id</th>`;
            html += `           <th>displayLabel</th>`;
            html += `           <th>attributesQualifiers</th>`;
            html += `       </tr>`;
            html += `    </thead>`;
            html += `    <tbody>`;
            for(let item of data.relations){
                html += `   <tr>`;
                html += `       <td>${item.ucmdbId}</td>`;
                html += `       <td>${item.type}</td>`;
                html += `       <td>${item.properties.display_label}</td>`;
                html += `       <td>${item.label}</td>`;
                html += `       <td>${item.globalId}</td>`;
                html += `       <td>${item.end1Id}</td>`;
                html += `       <td>${item.end2Id}</td>`;
                html += `       <td>${item.displayLabel}</td>`;
                html += `       <td>${item.attributesQualifiers}</td>`;
                html += `   </tr>`;
            }
            html += `    </tbody>`;
            html += `</table>`;
        $('#tableRelationHere').html(html);
    }
    function createTable(){
       $('#tableCis').DataTable({
           scrollX: true,
           lengthMenu:[3,10,50,100]
       });
       $('#tableRelations').DataTable({
           scrollX:true,
           lengthMenu:[3,10,50,100]
       });
   }
</script>
@stop
