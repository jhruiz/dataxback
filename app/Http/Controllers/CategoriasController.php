<?php

namespace App\Http\Controllers;

use App\Categoria;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    
    /**
     * Retorna la información de todas las categorías registradas en la base de datos
     */
    public function obtenerCategorias()
    {

        $resp = array( 'estado' => false, 'data' => null, 'mensaje' => '' );

        try {

            // se obtienen las categorias
            $categorias = Categoria::obtenerCategorias();           

            // valida si se econtraron registros
            if( !empty( $categorias ) ) {
                $resp['estado'] = true;
                $resp['data'] = $categorias;
            } else {
                $resp['mensaje'] = 'No se encontraron categorias registradas';
            }

        } catch(Throwable $e) {
            return array( 'estado' => false, 'data' => null, 'mensaje' => $e );
        }

        return $resp;

    }
}