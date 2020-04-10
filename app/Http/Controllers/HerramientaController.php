<?php

namespace App\Http\Controllers;

use App\Herramienta;
use Illuminate\Http\Request;
use DB;
use Carbon;

class HerramientaController extends Controller
{
    /* Autenticación para ingresar al sistema */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('herramientas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('herramientas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $herramienta = new Herramienta;        
        $herramienta->cant_inicial= $request->input('cant_inicial');
        $herramienta->cant_actual= $request->input('cant_inicial');
        $herramienta->disponible_bodega= $request->input('cant_inicial');
        $herramienta->marca= $request->input('marca');
        $herramienta->modelo= $request->input('modelo');
        $herramienta->descripcion= $request->input('descripcion');
        $herramienta->fecha_compra= $request->input('fecha_compra');
        $herramienta->precio= $request->input('precio');
        $herramienta->descuento= $request->input('descuento');
        $herramienta->notas= $request->input('notas');
        $herramienta->save();

        return redirect('/herramientas')->with('success', 'Agregado nuevo registro');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Herramienta  $herramienta
     * @return \Illuminate\Http\Response
     */
    public function show(Herramienta $herramienta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Herramienta  $herramienta
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $herramienta = Herramienta::find($id);
        $cant_salida = DB::table('salidas')->where('id_herramienta', $id)->sum('pendiente_entrega');

        return view('herramientas.edit', compact(['herramienta','cant_salida']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Herramienta  $herramienta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $herramienta = Herramienta::find($id);
        $nuevaCantidad = $request->input('cant_actual');
        $disponible = $herramienta->disponible_bodega;
        $cantActual = $herramienta->cant_actual;

        $herramienta->marca= $request->input('marca');
        $herramienta->modelo= $request->input('modelo');
        $herramienta->descripcion= $request->input('descripcion');
        $herramienta->precio= $request->input('precio');
        $herramienta->descuento= $request->input('descuento');
        $herramienta->notas= $request->input('notas');
        
        if ($nuevaCantidad < $cantActual) {
            $difCantidad = $cantActual - $nuevaCantidad;
            if ($difCantidad < 0) {
                $herramienta->disponible_bodega = 0;
            }
            else
            $herramienta->disponible_bodega = $disponible - $difCantidad;
            $herramienta->cant_actual = $nuevaCantidad;
        }
        elseif($nuevaCantidad > $cantActual) {
            $difCantidad = $nuevaCantidad - $herramienta->cant_actual;
            $herramienta->disponible_bodega = $disponible + $difCantidad;
            $herramienta->cant_actual = $nuevaCantidad;
        }

        $herramienta->save();
        return redirect('/herramientas')->with('success', 'Datos actualizados');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Herramienta  $herramienta
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $herramienta = Herramienta::find($id);

        $herramienta->delete();
        return redirect('/herramientas')->with('success', 'Registro eliminado');
    }

    function action(Request $request)
    {
     if($request->ajax())
     {
      $output = '';
      $query = $request->get('query');
      if($query != '')
      {
          #si un campo no existe, no se mostrará ningún dato
       $data = DB::table('herramientas')
         ->where('cant_actual', 'like', '%'.$query.'%')
         ->orWhere('marca', 'like', '%'.$query.'%')
         ->orWhere('modelo', 'like', '%'.$query.'%')
         ->orWhere('descripcion', 'like', '%'.$query.'%')
         ->orWhere('precio', 'like', '%'.$query.'%')
         ->orderBy('created_at', 'desc')
         ->get();
         
      }
      else
      {
       $data = DB::table('herramientas')
         ->orderBy('created_at', 'desc')
         ->get();
      }
      $total_row = $data->count();
      if($total_row > 0)
      {
       foreach($data as $row)
       {
        $output .= '
        <tr>
         <td>'.$row->cant_actual.'</td>
         <td>'.$row->disponible_bodega.'</td>
         <td>'.$row->descripcion.'</td>
         <td>'.$row->precio.'&nbsp;€</td> 
         <td>'.\Carbon\Carbon::parse($row->fecha_compra)->format('d/m/Y').'</td>
         <td>'.$row->marca.'</td>      
         <td><a href="/herramientas/'.$row->id.'/edit" class="fa fa-pencil btn btn-primary" title="Ver/Editar"></a>
            <a href="/salidas/'.$row->id.'/create" class="fa fa-external-link btn btn-warning" title="Nueva salida"></a>
         </td>
        </tr>
        ';
       }
      }
      else
      {
       $output = '
       <tr>
        <td align="center" colspan="5">No hay registros</td>
       </tr>
       ';
      }
      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($data);
     }
    }
}
