<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{

    protected $table = 'cgsucur';

    /**
     * Obtiene todas las ciudades registradas en la aplicación
     */
    public static function obtenerSucursales(){

		$data = Sucursal::select()
                
                ->get();

    	return $data;        

    }

    /**
     * Obtiene la información de una ciudad filtrando por su id
     */
    public static function obtenerSucursal( $id ){

		$data = Sucursal::select()
                
                ->get();

    	return $data;        

    }
    
}