<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{

    protected $table = 'cgciudad';

    /**
     * Se obtiene la información de todas las ciudades registradas en la base de datos
     * que pertenecen a un departamento
     */
    public static function obtenerCiudades( $cod_dpto ){

		  $data = Ciudad::select()
                ->where('cod_dpto', $cod_dpto)
                ->orderBy('nom_ciudad', 'ASC')
                ->get();

    	return $data;        

    }
   
}