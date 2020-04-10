<?php

namespace App\Http\Controllers;

use App\Salida;
use App\Herramienta;
use DB;
use Illuminate\Http\Request;

class SalidaController extends Controller
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
        $salidas = Salida::orderBy('updated_at','desc')->paginate(10);
        return view('salidas.index', compact(['salidas']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $herramienta = Herramienta::find($id);
        return view('salidas.create', compact(['herramienta']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $salida = new Salida;        
        $salida->id_herramienta= $request->input('id_herramienta');
        $salida->cantidad= $request->input('cantidad');
        $salida->descripcion= $request->input('herramienta');
        $salida->solicitante= $request->input('solicitante');
        $salida->pendiente_entrega= $request->input('cantidad');
        $salida->fecha_salida= $request->input('fecha_salida');
        $salida->fecha_retorno= $request->input('fecha_retorno');
        $salida->notas= $request->input('notas');
        $salida->save();

        $disponible = $salida->herramienta->disponible_bodega;
        $cantSalida = $salida->cantidad;
        $new = $disponible - $cantSalida;

        DB::table('herramientas')
        ->where("herramientas.id", '=',  $request->input('id_herramienta'))
        ->update(['herramientas.disponible_bodega'=> "$new"]);

        return redirect('/salidas')->with('success', 'Agregado nuevo registro');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Salida  $salida
     * @return \Illuminate\Http\Response
     */
    public function show(Salida $salida)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Salida  $salida
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $salida = Salida::find($id);
        return view('salidas.edit', compact(['salida']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Salida  $salida
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $salida = Salida::find($id);       
        $salida->notas= $request->input('notas');        

        $regresadas = $request->input('cantidad');
        $pendienteEntrega = $salida->pendiente_entrega;
        $newPE = $pendienteEntrega - $regresadas;
        $salida->pendiente_entrega = $newPE;

        $disponibleBodega = $salida->herramienta->disponible_bodega;
        $newDB = $disponibleBodega + $regresadas;



        DB::table('herramientas')
        ->where("herramientas.id", '=',  $salida->id_herramienta)
        ->update(['herramientas.disponible_bodega'=> "$newDB"]);

        $salida->save();
        return redirect('/salidas')->with('success', 'Datos actualizados');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Salida  $salida
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $salida = Salida::find($id);

        $disponible = $salida->herramienta->disponible_bodega;
        $cantSalida = $salida->pendiente_entrega;
        $new = $disponible + $cantSalida;

        DB::table('herramientas')
        ->where("herramientas.id", '=',  $salida->id_herramienta)
        ->update(['herramientas.disponible_bodega'=> "$new"]);

        $salida->delete();
        return redirect('/salidas')->with('success', 'Registro eliminado');
    }

    function action(Request $request)
    {
     if($request->ajax())
     {
      $output = '';
      $query = $request->get('query');
      if($query != '')
      {
       $data = DB::table('salidas')
         ->where('cantidad', 'like', '%'.$query.'%')
         ->orWhere('descripcion', 'like', '%'.$query.'%')
         ->orWhere('solicitante', 'like', '%'.$query.'%')
         ->orderBy('updated_at', 'desc')
         ->get();
         
      }
      else
      {
       $data = DB::table('salidas')
         ->orderBy('updated_at', 'desc')
         ->get();
      }
      $total_row = $data->count();
      if($total_row > 0)
      {
       foreach($data as $row)
       {
        $output .= '
        <tr>
         <td>'.$row->cantidad.'</td>
         <td>'.$row->pendiente_entrega.'</td>  
         <td>'.$row->descripcion.'</td>
         <td>'.$row->solicitante.'</td>
         <td>'.\Carbon\Carbon::parse($row->fecha_salida)->format('d/m/Y').'</td>
         <td>'.\Carbon\Carbon::parse($row->fecha_retorno)->format('d/m/Y').'</td>       
         <td><a href="/salidas/'.$row->id.'/edit" class="fa fa-pencil btn btn-primary" title="Ver/Editar"></a></td>
        </tr>
        ';
       }
      }
      else
      {
       $output = '
       <tr>
        <td align="center" colspan="5">Aún no hay salidas</td>
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
