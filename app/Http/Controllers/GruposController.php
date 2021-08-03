<?php

namespace App\Http\Controllers;

use App\Grupo;
use App\Producto;
use Illuminate\Http\Request;

class GruposController extends Controller
{
    
    /** 
     * Obtiene todos los grupos padre registrados en datax
    */
    public function obtenerGrupos()
    {
        $resp = array( 'estado' => false, 'data' => null, 'mensaje' => '' );

        try {

            // se obtienen las ciudades
            $grupos = Grupo::obtenerGruposPadre();

            // valida si se encontro el registro
            if( !empty( $grupos ) ) {

                $resp['estado'] = true;
                $resp['data'] = $grupos;

            } else {

                $resp['mensaje'] = 'No se encontro informacion de los grupos';

            }

        } catch(Throwable $e) {

            return array( 'estado' => false, 'data' => null, 'mensaje' => $e );
            
        }

        return $resp;
    }

    /**
     * Obtiene informacion completa de los grupos padre de la aplicación
     */
    public function obtenerInfoGrupos($cods) {

        $grupos = [];

        if( !empty( $cods ) ) {
            // obtiene los grupos padre configurados en datax
            $grupos = Grupo::obtenerGruposPorCodigos(json_decode($cods));

            // valida que existan grupos padre
            if( !empty( $grupos['0'] ) ) {

                // recorre los grupos padre
                foreach ( $grupos as $key => $val ) {
                    // obtiene un item relacionado al grupo
                    $resp = Producto::obtenerProductoPorGrupo($val->tipo_gru);
                    $grupos[$key]->item = $resp['0']->cod_item;                    
                }

            }
        }

        return $grupos;

    }
}