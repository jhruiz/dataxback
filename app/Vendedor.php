<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{

    protected $table = 'cgvend';

    /**
     * Obtiene todas las ciudades registradas en la aplicación
     */
    public static function obtenerVendedores(){

		$data = Vendedor::select()
                
                ->get();

    	return $data;        

    }

    /**
     * Obtiene la información de una ciudad filtrando por su id
     */
    public static function obtenerVendedor( $id ){

		$data = Vendedor::select()
                
                ->get();

    	return $data;        

    }
    
}