@extends('layouts.app')
@section('content')
    
<div class="col-md-6 text-center">
<h1>Nuevo registro de salida</h1>
</div>        
<div class="col-md-6 thumbnail">            
    <form action="{{route('salidas.store')}}" method="POST" enctype="multipart/form-data">
        @if ($herramienta->disponible_bodega > 0)
        <h4>Disponibles <b>{{$herramienta->disponible_bodega}} {{$herramienta->descripcion}}</b> en bodega</h4>
        <label>Cantidad de salida</label>
        <input type="number" name="cantidad" class="form-control" placeholder="Cantidad" required max="{{$herramienta->disponible_bodega}}"><br>

        <label>Nombre de quien solicita</label>
        <input name="solicitante" class="form-control" placeholder="Nombre del solicitante" required><br>
        
        <input name="herramienta" type="hidden" value="{{$herramienta->descripcion}}" class="form-control" required readonly>

        <input name="id_herramienta" value="{{$herramienta->id}}" class="form-control" type="hidden" readonly required>
        <input name="disponible_bodega" value="{{$herramienta->disponible_bodega}}" class="form-control" type="" readonly required><br>

        

        <label class="col-md-6 control-label" for="fecha_inicio">Fecha de salida</label>
        <div class="col-md-5">
            <input type="date" name="fecha_salida" class="form-control input-md" required value=<?php echo '"' . date('Y-m-d') . '"';?>/>
        </div><br><br>

        <label class="col-md-6 control-label" for="fecha_inicio">Fecha de retorno</label>
        <div class="col-md-5">
            <input type="date" name="fecha_retorno" class="form-control input-md" required value=<?php echo '"' . date('Y-m-d') . '"';?>/>
        </div><br><br>                    

        <label>Notas</label>
        <input type="text" value="Ninguna" name="notas" class="form-control" placeholder="Notas" id="phone" required><br>
        
        <button class="btn btn-primary"><span class="fa fa-save"></span>&nbsp; Guardar</button>
        @else <h3>No hay {{$herramienta->descripcion}} disponibles en bodega</h3>
        @endif
        
        {{ csrf_field()}} <!--Cross Site Request Forgery genera un token de tipo csrf para cada sección
        de usuario autenticado por motivos de seguridad; esto es un campo ocultos -->

    </form>
</div>

<style>select{height: 40px !important;}</style>

@endsection