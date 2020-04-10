<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salida extends Model
{
    public function herramienta(){
        return $this->belongsTo(Herramienta::class, 'id_herramienta');
        #return $this->belongsTo( '\App\Herramienta');
        #return $this->belongsTo('App\Herramienta', 'id_herramienta');
    } 
}
