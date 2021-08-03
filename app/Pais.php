<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{

    protected $table = 'dtpais';

    public static function obtenerPaises() {

		$data = Pais::select()
                
                ->get();

    	return $data;        

    }

    public static function obtenerPaises() {
        $data = Pais::select()
                
                ->get();
        
        return $data;
    }
    
}