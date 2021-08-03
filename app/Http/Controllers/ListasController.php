<?php

namespace App\Http\Controllers;

use App\Lista;
use Illuminate\Http\Request;

class ListasController extends Controller
{
    
    public function obtenerListas()
    {
    $lista = LIsta::obtenerListas();           
    }

    public function obtenerLista( $id = null ) {
        
    }
}