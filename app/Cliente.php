<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{

    protected $table = 'cgbenf';


    /**
     * Obtiene la información de todos los clientes
     */
    public static function obtenerClientes(){

        $data = Cliente::select()
                    ->get();
        return $data;       
    }

    /**
     * Obtiene la información de un cliente por su email e identificación
     */
    public static function obtenerInfoCliente($identificacion, $email) {
        $data = Cliente::select()
                        ->where('cgbenf.email_benf', '=', $email)
                        ->where('cgbenf.nit_benf', '=', $identificacion)
                        ->get();
        return $data;
    }

    /**
     * Obtiene la información del cliente por código
     */
    public static function obtenerClientePorCodigo( $codBenf ) {
        $data = Cliente::select()
                        ->where('cgbenf.cod_benf', '=', $codBenf)
                        ->get();
        return $data;
    }
    
}