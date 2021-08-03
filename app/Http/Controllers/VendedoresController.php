<?php

namespace App\Http\Controllers;

use App\Vendedor;
use Illuminate\Http\Request;

class VendedoresController extends Controller
{
    
    public function index()
    {
        /** Se obtienen todos los clientes */
        $vendedores = Vendedor::getVendedor();        
        
    }
    
    public function obtenerVendedor( $id = null ) {
        
    }
}