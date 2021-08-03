<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{

    protected $table = 'inped1';

    public static function obtenerPedidos() {

		$data = Pedido::select()
                
                ->get();

    	return $data;        

    }

    public static function obtenerPedido() {
        $data = Pedido::select()
                
                ->get();
        
        return $data;
    }

    /**
     * Guarda la información del pedido en la tabla principal
     */
    public static function guardarPedido($data) {
        return Pedido::insert($data);	        
    }
    
}