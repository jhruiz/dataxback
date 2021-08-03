<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Linea extends Model
{

    protected $table = 'inlista';

    /**
     * Obtiene todas las ciudades registradas en la aplicación
     */
    public static function obtenerListas(){

		$data = Lista::select()
                
                ->get();

    	return $data;        

    }

    /**
     * Obtiene la información de una ciudad filtrando por su id
     */
    public static function obtenerLista( $id ){

		$data = Linea::select()
                
                ->get();

    	return $data;        

    }
    
}