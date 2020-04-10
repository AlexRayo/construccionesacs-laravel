@extends('layouts.app')
@section('content')
    
<div class="col-md-6 text-center">
    <h1>Editar registro</h1>
    <h3>Herramienta: <b>{{$salida->descripcion}}</b></h3>
</div>        
<div class="col-md-6 thumbnail"> 
    @if (!Auth::guest())               
        @if (Auth::user()->name == "Admin")        
        <p onclick="showValidationWindow()" class="fa fa-trash  btn btn-danger pull-right" id="delBtn" title="Borrar el registro"></p>
                    
        <div id="validationWindow" style="display: none;" class="col-lg-12 thumbnail pull-right">        
            <h4 style="color:crimson"><b>Se eliminará todo el registro</b></h4 style="color:crimson">
            <div>
                <p id="hideValWin" onclick="hideValidationWindow()"class="okBtn DefBtn btn btn-primary pull-right">Cancelar</p>
                <form action="{{route('salidas.destroy', $salida->id)}}" method="POST" enctype="multipart/form-data">
                    
                {{ method_field('DELETE') }}
                <input type="submit" class="btn btn-default" value="Eliminar">
                {{ csrf_field()}}
                </form>
            </div>
        </div><br><br> 
        @endif
    @endif             
    <form action="{{route('salida.update', $salida->id)}}" method="POST" enctype="multipart/form-data">
        <h4>Pendientes por regresar: <b>{{$salida->pendiente_entrega}}</b></h4>
        <input value="{{$salida->id_herramienta}}" type="hidden" name="id_herramienta" class="form-control" required>
        <input value="{{$salida->pendiente_entrega}}" type="hidden" name="pendiente_entrega" class="form-control" required>
        <input value="{{$salida->herramienta->disponible_bodega}}" type="hidden" name="disponible_bodega" class="form-control" required><br>
        @if ($salida->pendiente_entrega >0)
            <label>Cantidad de herramientas que regresan a bodega</label>
            <input type="number" name="cantidad" class="form-control" placeholder="Cantidad" required min="1" max="{{$salida->pendiente_entrega}}"><br>
            <label>Notas</label>
            <textarea name="notas" class="form-control" cols="30" rows="2" placeholder="Notas" required>{{$salida->notas}}</textarea>
            
            <input type="hidden" _method value="PUT">
            <button class="btn btn-primary"><span class="fa fa-save"></span>&nbsp; Guardar</button>
            @else
            <h3>Se han entregado todas las herramientas</h3><br>
        @endif
        
        
        {{ csrf_field()}} 

    </form>
</div>

<style>select{height: 40px !important;}</style>
<script>
	function showValidationWindow() {
		var validationWindow = document.getElementById("validationWindow");
		validationWindow.style.display = "block";
		var delBtn = document.getElementById("delBtn");
		delBtn.style.display = "none";
	}
	function hideValidationWindow() {
		var validationWindow = document.getElementById("validationWindow");
		validationWindow.style.display = "none";
		var delBtn = document.getElementById("delBtn");
		delBtn.style.display = "block";
	}
</script>
@endsection