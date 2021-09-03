<?php

namespace App\Http\Controllers;

use App\Producto;
use App\Grupo;
use App\Linea;
use App\Cliente;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    
    /**
     * Obtiene todos los productos registrados en la base de datos de Datax
     */
    public function obtenerProductos()
    {
        $resp = array( 'estado' => false, 'data' => null, 'mensaje' => '' );

        try {

            // se obtienen los productos
            $productos = Producto::obtenerProductos();
            
            // se obtienen los grupos
            $grupos = Grupo::obtenerInfoGrupos();
            $arrListGrp = [];

            // se recorren los grupo para armar el listado de estos
            foreach($grupos as $grp) {
                $arrListGrp[$grp->tipo_gru . $grp->codigo_gru] = $grp->desc_gru;
            }

            // se obtienen las lineas
            $linea = Linea::obtenerLineas();
            $arrListLn = [];

            // se recorren las lineas para armar el listado de estas
            foreach($linea as $ln) {
                $arrListLn[$ln->cod_linea] = $ln->des_linea;
            }

            // valida si se econtraron registros
            if( !empty( $productos ) ) {
                $resp['estado'] = true;
                $resp['data'] = $productos;
                $resp['datagrp'] = $arrListGrp;
                $resp['dataln'] = $arrListLn;

            } else {
                $resp['mensaje'] = 'No se encontraron productos registrados';
            }

        } catch(Throwable $e) {
            return array( 'estado' => false, 'data' => null, 'mensaje' => $e );
        }

        return $resp;         
    }

    /**
     * Obtiene un producto específico registrado en Datax
     */
    public function obtenerProducto( Request $request ) {

        $productoId = $request['itemId'];

        $resp = array( 'estado' => false, 'data' => null, 'mensaje' => '' );

        try {

            if(!empty($productoId)){
                
                // se obtienen los productos
                $producto = Producto::obtenerProducto($productoId);
                
                // se obtienen los grupos
                $grupos = Grupo::obtenerInfoGrupos();
                $arrListGrp = [];
                // se recorren los grupo para armar el listado de estos
                foreach($grupos as $grp) {
                    $arrListGrp[$grp->tipo_gru . $grp->codigo_gru] = $grp->desc_gru;
                }                

                // valida si se econtraron registros
                if( !empty( $producto ) ) {
                    $producto['0']->desc_gru = ''; //!empty($producto['0']->grupo) ? $arrListGrp[$producto['0']->grupo] : '';
                    $resp['estado'] = true;
                    $resp['data'] = $producto;
                } else {
                    $resp['mensaje'] = 'No se encontró información del producto.';
                }
            }

        } catch(Throwable $e) {
            return array( 'estado' => false, 'data' => null, 'mensaje' => $e );
        }

        return $resp;
        
    }

    /**
     * Obtiene una cantidad especifica de productos con un inicio y un fin
     */
    public function obtenerInfoProductos($pagina, $cantidad) {

        $resp = array( 'estado' => false, 'data' => null, 'mensaje' => '', 'cantidad' => 0 );

        try {

            // se calcula en cuanto inicia la consulta
            $skip = ($pagina * $cantidad) - $cantidad;

            // se obtienen la información de los items
            $items = Producto::obtenerInfoProductos($skip, $cantidad);

            // se obtiene la cantidad total de productos disponibles
            $cantTtal = Producto::obtenerCantProds();

            // valida si se encontro el registro
            if( !empty( $items ) ) {

                $resp['estado'] = true;
                $resp['data'] = $items;
                $resp['cantidad'] = $cantTtal;

            } else {
                $resp['mensaje'] = 'No se encontro informacion de productos';
            }

        } catch(Throwable $e) {

            return array( 'estado' => false, 'data' => null, 'mensaje' => $e );
            
        }

        return $resp; 
    }

    /**
     * Obtiene los detalles de un producto asi como los relacionados por grupo y linea
     */
    public function obtenerDetallesProducto($itemId) {

        $resp = array( 'estado' => false, 'data' => null, 'mensaje' => '' );
        $cantidadItems = 8;

        try {

            if(!empty($itemId)){
                
                // se obtienen los productos
                $producto = Producto::obtenerDetallesProducto($itemId);               

                // valida si se econtraron registros
                if( !empty( $producto ) ) {

                    $arrItemsId = array($itemId);
                    $arrInfoCompleta = [];

                    //se obtienen productos relacionados con el producto principal por medio de su grupo
                    $pdrGrupo = Producto::obtenerProductosPorGrupo($producto['0']->grupo, $arrItemsId, $cantidadItems);

                    $nPdrGrp = [];
                    foreach($pdrGrupo as $prdGrp) {
                        $nPdrGrp[] = $this->procesarProductos($prdGrp);
                    }

                    //se obtienen productos relacionados con el producto principal por medio de su linea
                    // $pdrLinea = Producto::obtenerProductosPorLinea($producto['0']->itm_linea, $arrItemsId, $cantidadItems);

                    $nPdrLin = [];
                    // foreach($pdrLinea as $pdrLin) {
                    //     $nPdrLin[] = $this->procesarProductos($pdrLin);
                    // }

                    // Se agrupa la información consultada en un arreglo general
                    $arrInfoCompleta['principal'] = $this->procesarProductos($producto['0']);
                    $arrInfoCompleta['grupo'] = $nPdrGrp;
                    $arrInfoCompleta['linea'] = $nPdrLin;

                    $resp['estado'] = true;
                    $resp['data'] = $arrInfoCompleta;
                } else {
                    $resp['mensaje'] = 'No se encontró información del producto.';
                }
            }

        } catch(Throwable $e) {
            return array( 'estado' => false, 'data' => null, 'mensaje' => $e );
        }

        return $resp;        
    }    

    /**
     * Obtiene los items que se encuentren entre los codigos recibidos por parametros
     */
    public function obtenerProductosPorCodigo($cods) {

        $prods = [];

        if(!empty($cods)) {
            $resp = Producto::obtenerProductosPorCodigo(json_decode($cods));

            if( !empty( $resp['0'] )) {
                foreach( $resp as $val ) {
                    $prods[] = $this->procesarProductos($val);
                }
            }
        }

        return $prods;
    }

    /**
     * Obtiene los productos por nombre o por codigo de barras
     */
    public function obtenerProductosPorNombreBarcode( $nomBarcode ) {
        $prods = [];

        if( !empty( $nomBarcode ) ) {
            $resp = Producto::obtenerProductosPorNomBarCode( $nomBarcode );

            if( !empty( $resp['0'] ) ) {
                foreach( $resp as $val ) {
                    $prods[] = $this->procesarProductos( $val );
                }
            }
        }

        return $prods;
    }

    /**
     * Obtiene la información de los items relacionados a un grupo
     */
    public function obtenerProductosPorGrupo( $codGru ) {
        $prods = [];

        if( !empty( $codGru ) ) {
            $resp = Producto::obtenerProductosPorTipoGrupo( $codGru );

            if( !empty( $resp['0'] ) ) {
                foreach( $resp as $val ) {
                    $prods[] = $this->procesarProductos( $val );
                }
            }
        }

        return $prods;
    }

    /**
     * Obtiene el precio del producto correspondiente a la lista de 
     * precios asignada al cliente
     */
    public function obtenerPrecioItemLista( $codBenf, $codItem ) {

        $resp = null;

        // verifica que llegue toda la información necesaria
        if( !empty( $codBenf ) && !empty($codItem) ) {

            // se obtiene la información del cliente
            $cliente = Cliente::obtenerClientePorCodigo( $codBenf );

            // valida que exista el cliente
            if( !empty($cliente['0']->cod_benf ) ) {

                // obtiene la información del producto y su lista de precios
                $item = Producto::obtenerDetallesProducto( $codItem );

                // valida si existe el producto con la lista de precios
                if( !empty($item['0']->cod_item ) ) {

                    $lPrecio = 0;
                    $ivaInc = 1;
                    // obtiene el precio que le corresponde segun la lista del cliente
                    if( $cliente['0']->lista_benf == '1' ) {
                        $resp = array(
                            'precio' => $item['0']->precio1,
                            'ivaInc' => $item['0']->iva_inc_p1,
                            'tasaIva' => $item['0']->tasa_iva
                        );                        
                    } else if( $cliente['0']->lista_benf == '1' ) {
                        $resp = array(
                            'precio' => $item['0']->precio2,
                            'ivaInc' => $item['0']->iva_inc_p2,
                            'tasaIva' => $item['0']->tasa_iva
                        );         
                    } else {
                        $resp = array(
                            'precio' => $item['0']->precio3,
                            'ivaInc' => $item['0']->iva_inc_p3,
                            'tasaIva' => $item['0']->tasa_iva
                        );                                
                    }

                    return $resp;
                }                
            }
        }
        return $resp;
    }

    /**
     * Obtiene las inidades disponibles del pedido que se esta validando
     */
    public function obtenerUnidadesDisponiblesItems( $codsItems ) {
        $resp = [];

        // valida que existan codigos de los items
        if( !empty( $codsItems ) ) {
            // obtiene las unidades disponibles de los items
            $unidades = Producto::obtenerUnidadesDisponibles( json_decode($codsItems) );

            foreach( $unidades as $key => $val ) {
                $resp[$val->cod_item] = $val->saldo_disponible;
            }
        }

        return $resp;
    }

    /**
     * Busca el producto por código de barras, nombre o palabra clave
     */
    public function buscarProductos( $description ) {
        $prods = [];

        if( !empty( $description ) ) {

            // busca el producto por codigo de barras
            $resp = Producto::buscarProductoCodBar( $description );

            if( empty( $resp['0']->cod_item ) ){
                $resp = Producto::buscarProductos( $description );
            }      

            if( !empty( $resp['0'] ) ) {
                foreach( $resp as $val ) {
                    $prods[] = $this->procesarProductos( $val );
                }
            }
        }

        return $prods;
    }

    /**
     * Procesa el objeto para obtener un array del producto
     */
    public function procesarProductos($producto) {
        return [
            'cod_item' => $producto->cod_item,
            'referencia' => $producto->referencia,
            'descrip' => $producto->descrip,
            'descr_abr' => $producto->descr_ab,
            'grupo' => $producto->grupo,
            'itm_linea' => $producto->itm_linea,
            'itm_extens' => $producto->itm_extens,
            'precio1' => $producto->precio1,
            'iva_inc_p1' => $producto->iva_inc_p1,
            'precio1_ad' => $producto->precio1_ad,
            'iva_pv1_ad' => $producto->iva_pv1_ad,
            'precio2' => $producto->precio2,
            'iva_inc_p2' => $producto->iva_inc_p2,
            'precio2_ad' => $producto->precio2_ad,
            'iva_pv2_ad' => $producto->iva_pv2_ad,
            'precio3' => $producto->precio3,
            'iva_inc_p3' => $producto->iva_inc_p3,
            'precio3_ad' => $producto->precio3_ad,
            'iva_pv3_ad' => $producto->iva_pv3_ad,
            'uni_factor' => $producto->uni_factor,
            'l_barcode' => $producto->l_codebar
        ];
    }
}