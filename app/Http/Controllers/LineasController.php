<?php

namespace App\Http\Controllers;

use App\Impuesto;
use Illuminate\Http\Request;

class LineasController extends Controller
{
    
    public function obtenerLineas()
    {
        $linea = Linea::obtenerLineas();           
    }

    public function obtenerLinea( $id = null ) {
        
    }
}