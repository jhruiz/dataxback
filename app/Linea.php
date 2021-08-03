<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Linea extends Model
{

    protected $table = 'inlinea';

    /**
     * Obtiene todas las lineas de los productos registradas en la aplicación
     */
    public static function obtenerLineas(){

		$data = Linea::select()
                ->get();

    	return $data;        

    }

    /**
     * Obtiene la información de una linea filtrando por su id
     */
    public static function obtenerLinea( $id ){

		$data = Linea::select()
                
                ->get();

    	return $data;        

    }
    
}