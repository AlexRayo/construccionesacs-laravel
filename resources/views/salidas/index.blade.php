@extends('layouts.app')

@section('content')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<h2 align="center">Salidas de bodega</h2><br />
   <div class="panel panel-default">
    <!--<div class="panel-heading">Realizar una búsqueda</div>-->
    <div class="panel-body">
     <div class="form-group">
      <input type="text" name="search" id="search" class="form-control" placeholder="Realizar una búsqueda..." />
     </div>
     <div class="table-responsive">      
      <table class="table table-striped table-bordered">
       <thead>
        <tr>
         <th>Cantidad retirada</th>
         <th>Pendientes de regresar</th>
         <th>Descripción</th>
         <th>Solicitante</th>
         <th>Fecha de salida</th>
         <th>Fecha de retorno</th>
         <th>Editar</th>
        </tr>
       </thead>
       <tbody>

       </tbody>
      </table>
      <h4 align="center">Total de registros : <b><span id="total_records"></b></span></h4>
     </div>
    </div>    
   </div>



<script>
$(document).ready(function(){
 fetch_customer_data();

 function fetch_customer_data(query = '')
 {
  $.ajax({
   url:"{{ route('live_search_salidas.action') }}",
   method:'GET',
   data:{query:query},
   dataType:'json',
   success:function(data)
   {
    $('tbody').html(data.table_data);
    $('#total_records').text(data.total_data);
   }
  })
 }

 $(document).on('keyup', '#search', function(){
  var query = $(this).val();
  fetch_customer_data(query);
 });
});
</script>      
@endsection