<?php

namespace App\Http\Controllers;

use App\Impuesto;
use Illuminate\Http\Request;

class ImpuestosController extends Controller
{
    
    public function obtenerImpuestos()
    {
        $impuesto = Impuesto::obtenerImpuestos();           
    }

    public function obtenerImpuesto( $id = null ) {
        
    }
}