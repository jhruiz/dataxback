<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{

    protected $table = 'ingrupo';

    /**
     * Obtiene todos los grupos padre registrados en la base de datos de datax
     */
    public static function obtenerGruposPadre(){

		  $data = Grupo::select()
                ->where('ingrupo.clase_gru', 'T')
                ->get();

    	return $data;        

    }

    /**
     * Obtiene los grupos padre relacionados en el arreglo
     */
    public static function obtenerGruposPorCodigos($cods) {
		  $data = Grupo::select()
                ->where('ingrupo.clase_gru', 'T')
                ->whereIn('ingrupo.tipo_gru', $cods)
                ->get();

    	return $data;         
    }

    /**
     * Se obtiene la información de los grupos
     */
    public static function obtenerInfoGrupos() {
      $data = Grupo::select()
                  ->get();
      return $data;
    }
    
}