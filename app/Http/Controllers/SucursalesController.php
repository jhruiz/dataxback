<?php

namespace App\Http\Controllers;

use App\Sucursal;
use Illuminate\Http\Request;

class SucursalesController extends Controller
{
    
    public function index()
    {
        /** Se obtienen todos los clientes */
        $sucursales = Sucursal::getInstore();        
        
    }
    
    public function obtenerSucursal( $id = null ) {
        
    }
}