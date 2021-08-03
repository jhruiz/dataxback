<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Http\Request;

class ClientesController extends Controller
{

    /**
     * obtiene la informacion de todos los clientes registrados en la aplicacion.
     */
    public function obtenerClientes() {
        
        $resp = array( 'estado' => false, 'data' => null, 'mensaje' => '' );

        try {

            // se obtienen las ciudades
            $clientes = Cliente::obtenerClientes();

            // valida si se encontro el registro
            if( !empty( $clientes ) ) {

                $resp['estado'] = true;
                $resp['data'] = $clientes;

            } else {

                $resp['mensaje'] = 'No se encontro informacion de clientes';

            }

        } catch(Throwable $e) {

            return array( 'estado' => false, 'data' => null, 'mensaje' => $e );
            
        }

        return $resp;
    }
    
    /**
     * Se obtiene un cliente específico por código, registrado en la base de datos
     */
    public function obtenerCliente( $cod_cliente = null )
    {        
        
        $resp = array( 'estado' => false, 'data' => null, 'mensaje' => '' );

        try {

            // valida si el código del cliente no está vacio
            if( !empty( $cod_cliente ) ) {

                // se obtienen las ciudades
                $cliente = Cliente::obtenerCliente( $cod_cliente );

                // valida si se encontro el registro
                if( !empty( $cliente ) ) {

                    $resp['estado'] = true;
                    $resp['data'] = $cliente;

                } else {

                    $resp['mensaje'] = 'No se encontro informacion del cliente';

                }
            } else {

                $resp['mensaje'] = 'Debe ingresar el codigo del cliente';

            }

        } catch(Throwable $e) {

            return array( 'estado' => false, 'data' => null, 'mensaje' => $e );
            
        }

        return $resp;
    }

    /**
     * Obtiene la información de un cliente por identificación y el email
     */
    public function obtenerInfoCliente($identificacion, $email) {
        
        $resp = array( 'estado' => false, 'data' => null, 'mensaje' => '' );

        try {

            // valida si el código del cliente no está vacio
            if( !empty( $identificacion ) && !empty( $email ) ) {

                // se obtienen las ciudades
                $cliente = Cliente::obtenerInfoCliente( $identificacion, $email );
                

                // valida si se encontro el registro
                if( !empty( $cliente['0'] ) ) {

                    $resp['estado'] = true;
                    $resp['data'] = $cliente;

                } else {

                    $resp['mensaje'] = 'No se encontro informacion del cliente';

                }
            } else {

                $resp['mensaje'] = 'Debe ingresar el codigo del cliente';

            }

        } catch(Throwable $e) {

            return array( 'estado' => false, 'data' => null, 'mensaje' => $e );
            
        }

        return $resp;
    }

}