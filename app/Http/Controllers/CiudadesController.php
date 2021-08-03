<?php

namespace App\Http\Controllers;

use App\Ciudad;
use Illuminate\Http\Request;

class CiudadesController extends Controller
{
    
    /**
     * Se obtiene la información de las ciudades registradas en la base de datos
     * relacionadas a un departamento
     */
    public function obtenerCiudades( $cod_dpto = null )
    {

        $resp = array( 'estado' => false, 'data' => null, 'mensaje' => '' );

        try {

            // valida si el código del departamento no está vacio
            if( !empty( $cod_dpto ) ) {

                // se obtienen las ciudades
                $ciudades = Ciudad::obtenerCiudades($cod_dpto);

                // valida si se econtraron registros
                if( !empty( $ciudades ) ) {

                    $resp['estado'] = true;
                    $resp['data'] = $ciudades;

                } else {

                    $resp['mensaje'] = 'No se encontraron ciudades registradas';

                }
            } else {

                $resp['mensaje'] = 'Debe seleccionar un departamento';

            }

        } catch(Throwable $e) {

            return array( 'estado' => false, 'data' => null, 'mensaje' => $e );
            
        }

        return $resp;
        
    }

}