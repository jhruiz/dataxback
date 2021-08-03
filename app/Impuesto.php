<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Impuesto extends Model
{

    protected $table = 'inimpto';

    /**
     * Obtiene todas las ciudades registradas en la aplicación
     */
    public static function obtenerImpuestos(){

		$data = Impuesto::select()
                
                ->get();

    	return $data;        

    }

    /**
     * Obtiene la información de una ciudad filtrando por su id
     */
    public static function obtenerImpuesto( $id ){

		$data = Impuesto::select()
                
                ->get();

    	return $data;        

    }
    
}