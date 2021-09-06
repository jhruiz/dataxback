<?php

namespace App;

class Configuracion
{
    /**
     * Retorna la url de cotools
     */
    public static function urlCotools() {

    	// return 'http://localhost:85/cotoolsback/public/';
    	return 'https://cotoolsback.cotools.co/public/';

    }

    /**
     * Retorna el tipo de pago configurado para el pedido
     */
    public static function obtenerTipoPago() {
        return '2'; // 1 -> contado, 2 -> credito.
    }

    /**
     * Retorna los dias de credito configurados
     */
    public static function obtenerDiasCredito() {
        return '30';
    }
    
}