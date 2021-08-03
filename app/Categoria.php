<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{

    protected $table = 'inctgria';

    /**
     * Obtiene la información de todas las categorias registradas en la base de datos
     */
    public static function obtenerCategorias(){

		  $data = Categoria::select()
                ->orderBy('ct_desc', 'ASC')                
                ->get();

    	return $data;        

    }
    
}