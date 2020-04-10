@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12 thumbnail" style="margin-bottom: 50px">
        <a href="/clientes/{{$showCliente->id}}/edit" class="btn btn-primary pull-right fa fa-pencil" title="Editar"></a>
        <h2><b>{{$showCliente->nombres}}</b></h2>        
        <p>Zona: <b>{{$showCliente->zona}}</b></p> <p>Dirección: <b>{{$showCliente->direccion}}</b></p>
        <p>Teléfono: <b>{{$showCliente->telefono}}</b></p>
        <br>          
    </div>
    
    <h2>Préstamos solicitados <a href="/prestamos/{{$showCliente->id}}/create" class="btn btn-success fa fa-plus" title="Agregar préstamo"></a></h2>
<div class="table-responsive thumbnail">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Monto solicitado</th>
                <th scope="col">Cuota mensual</th>
                <th scope="col">Saldo del capital</th>
                <th scope="col">Fecha de Solicitud</th>
                <th scope="col">Ajustes</th>
            </tr>
        </thead>
        <tbody>
    @foreach ($prestamos as $prestamo)
    <tr>           
            <td>{{$prestamo->monto}}</td>
            <td>{{$prestamo->valorCuota}}</td>
            <td>{{$prestamo->saldo}}</td>
            <td>{{ \Carbon\Carbon::parse($prestamo->fechaSolicitud)->format('d/m/Y')}}</td>
            <td>
                <a href="/prestamos/{{$prestamo->id}}" class="fa fa-gear btn btn-primary" title="Ver/Editar"></a>&nbsp;&nbsp;&nbsp;&nbsp;
            </td>
    </tr>        
    @endforeach 
</div> 

@endsection