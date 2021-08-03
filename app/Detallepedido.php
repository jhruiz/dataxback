<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detallepedido extends Model
{

    protected $table = 'inped2';

    /**
     * Guarda la información del pedido en la tabla principal
     */
    public static function guardarDetallePedido($data) {
        return Detallepedido::insert($data);	        
    }
    
}