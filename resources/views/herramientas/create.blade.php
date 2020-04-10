@extends('layouts.app')
@section('content')
    
<div class="col-md-6 text-center">
    <h1>Nuevo registro</h1>
</div>        
<div class="col-md-6 thumbnail">            
    <form action="{{route('herramientas.store')}}" method="POST" enctype="multipart/form-data">
        <label>Cantidad</label>
        <input type="number" name="cant_inicial" class="form-control" placeholder="Cantidad" required><br>

        <label>Descripción</label>
        <input type="text" value="Pendiente" name="descripcion" class="form-control" placeholder="Descripción" id="phone" required><br>
        
        <label>Precio unitario</label>
        <input type="text" value="0.00" name="precio" class="form-control" placeholder="Precio" id="phone" required><br>
        
        <label class="col-md-6 control-label" for="fecha_inicio">Fecha de compra</label>
        <div class="col-md-5">
            <input id="fecha_inicio" type="date" name="fecha_compra" class="form-control input-md" required value=<?php echo '"' . date('Y-m-d') . '"';?>/>
        </div><br><br>          
        
        <label>Marca</label>
        <input type="text" value="Sin especificar" name="marca" class="form-control" placeholder="Marca" required><br>
        
        <label>Modelo</label>
        <input type="text" value="Sin especificar" name="modelo" class="form-control" placeholder="Modelo" id="phone" required><br>
        
        <label>Descuento</label>
        <input type="text" value="0.00" name="descuento" class="form-control" placeholder="Descuento" id="phone" required><br>
        
        <label>Notas</label>
        <input type="text" value="Ninguna" name="notas" class="form-control" placeholder="Notas" id="phone" required><br>
        
        <button class="btn btn-primary"><span class="fa fa-save"></span>&nbsp; Guardar</button>
        {{ csrf_field()}} <!--Cross Site Request Forgery genera un token de tipo csrf para cada sección
        de usuario autenticado por motivos de seguridad; esto es un campo ocultos -->

    </form>
</div>

    <style>select{height: 40px !important;}</style>
@endsection