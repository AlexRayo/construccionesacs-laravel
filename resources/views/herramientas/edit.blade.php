@extends('layouts.app')
@section('content')
    
<div class="col-md-6 text-center">
    <h1>Editar registro</h1>
    <h3>Herramienta: <b>{{$herramienta->descripcion}}</b></h3>
</div>        
<div class="col-md-6 thumbnail"> 
    @if (!Auth::guest())               
        @if (Auth::user()->name == "Admin")        
        <p onclick="showValidationWindow()" class="fa fa-trash  btn btn-danger pull-right" id="delBtn" title="Borrar el registro"></p>
                    
        <div id="validationWindow" style="display: none;" class="col-lg-12 thumbnail pull-right">        
            <h4 style="color:crimson"><b>Se eliminará todo el registro</b></h4 style="color:crimson">
            <div>
                <p id="hideValWin" onclick="hideValidationWindow()"class="okBtn DefBtn btn btn-primary pull-right">Cancelar</p>
                <form action="{{route('herramientas.destroy', $herramienta->id)}}" method="POST" enctype="multipart/form-data">
                    
                {{ method_field('DELETE') }}
                <input type="submit" class="btn btn-default" value="Eliminar">
                {{ csrf_field()}}
                </form>
            </div>
        </div><br><br> 
        @endif
    @endif             
    <form action="{{route('herramientas.update', $herramienta->id)}}" method="POST" enctype="multipart/form-data">
        <label>Cantidad actual</label>
        <input value="{{$herramienta->cant_actual}}" min="{{$cant_salida}}" type="number" name="cant_actual" class="form-control" placeholder="Cantidad" required><br>
       
        <label>Descripción</label>
        <input value="{{$herramienta->descripcion}}" type="text" value="Pendiente" name="descripcion" class="form-control" placeholder="Descripción" id="phone" required><br>
        
        <label>Precio unitario</label>
        <input value="{{$herramienta->precio}}" type="text" value="0.00" name="precio" class="form-control" placeholder="Precio" id="phone" required><br>
                
        <label>Marca</label>
        <input value="{{$herramienta->marca}}" type="text" value="Pendiente" name="marca" class="form-control" placeholder="Marca" required><br>
        
        <label>Modelo</label>
        <input value="{{$herramienta->modelo}}" type="text" value="Pendiente" name="modelo" class="form-control" placeholder="Modelo" id="phone" required><br>
        
        <label>Descuento</label>
        <input value="{{$herramienta->descuento}}" type="text" value="0.00" name="descuento" class="form-control" placeholder="Descuento" id="phone" required><br>
        
        <label>Notas</label>
        <input value="{{$herramienta->notas}}" type="text" value="Pendiente" name="notas" class="form-control" placeholder="Notas" id="phone" required><br>
        <input type="hidden" _method value="PUT">
        <button class="btn btn-primary"><span class="fa fa-save"></span>&nbsp; Guardar</button>
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

    /*
BEGIN

UPDATE herramientas h
   SET h.disponible_bodega = h.disponible_bodega -
    (SELECT SUM(cantidad) 
       FROM salidas
      WHERE id_herramienta = h.id)
 WHERE h.id = NEW.id;

END
    */
</script>
@endsection