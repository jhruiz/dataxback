<?php

namespace App\Http\Controllers;

use App\Pais;
use Illuminate\Http\Request;

class PaisController extends Controller
{
    
    public function index()
    {
        /** Se obtienen todos los clientes */
        $paises = Pais::getInstore();        
        
    }
    
    public function obtenerPaises( $id = null ) {
        
    }
}