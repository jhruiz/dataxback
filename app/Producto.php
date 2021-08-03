<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{

    protected $table = 'initem';

    /**
     * Obtiene todas los productos registrados en la aplicación
     */
    public static function obtenerProductos(){

		  $data = Producto::select('cod_item', 'referencia', 'descrip', 'itm_linea', 'grupo')
                      ->get();

    	return $data;        

    }

    /**
     * Obtiene la información de un producto filtrando por su id
     */
    public static function obtenerProducto( $id ){

		  $data = Producto::select()
                      ->leftjoin('inlinea', 'inlinea.cod_linea', '=', 'initem.itm_linea')
                      ->where('initem.cod_item', $id) 
                      ->get();

    	return $data;        

    }   

    /**
     * Obtiene la información completa de los productos registrados
     */
    public static function obtenerInfoProductos($skip, $take) {
      $data = Producto::select( 'initem.cod_item', 'initem.referencia', 'initem.descrip', 'initem.tasa_iva',
                                'initem.tasaivavta', 'initem.itm_linea', 'initem.grupo', 'initem.itm_extens',
                                'inlista.precio1', 'inlista.iva_inc_p1', 'inlista.precio1_ad', 'inlista.iva_pv1_ad',
                                'inlista.precio2', 'inlista.iva_inc_p2', 'inlista.precio2_ad', 'inlista.iva_pv2_ad',
                                'inlista.precio3', 'inlista.iva_inc_p3', 'inlista.precio3_ad', 'inlista.iva_pv3_ad',
                                'insaldo.actual_sdo', Producto::raw('(insaldo.actual_sdo - (insaldo.pdv_sdo + insaldo.sdo_asigpd)) as saldo_disponible')
                                )
                      ->leftjoin('inlista', 'inlista.cod_lis', '=', 'initem.cod_item')
                      ->join('insaldo', 'insaldo.cod_sdo', '=', 'initem.cod_item')     
                      ->havingRaw('saldo_disponible > ?', [0])
                      ->skip($skip)->take($take)
                      ->get();

      return $data;         
    }

    /**
     * Retorna la cantidad de registros en la base de datos
     */
    public static function obtenerCantProds() {
      $data = Producto::select(Producto::raw('(insaldo.actual_sdo - (insaldo.pdv_sdo + insaldo.sdo_asigpd)) as saldo_disponible')) 
                      ->leftjoin('inlista', 'inlista.cod_lis', '=', 'initem.cod_item')
                      ->join('insaldo', 'insaldo.cod_sdo', '=', 'initem.cod_item')
                      ->havingRaw('saldo_disponible > ?', [0])
                      ->count();
                      
      return $data;
    }    

    /**
     * Obtiene la informacion de los productos y las listas de precios que les corresponden
     */
    public static function obtenerDetallesProducto($itemId) {
      $data = Producto::select()
                      ->leftjoin('inlista', 'inlista.cod_lis', '=', 'initem.cod_item') 
                      ->where('initem.cod_item', $itemId) 
                      ->get();

      return $data;  
    }  

    /**
     * Obtiene un listado de productos de cantidad específica de un grupo
     */
    public static function obtenerProductosPorGrupo($grupo, $idItem, $cantItems){
      $data = Producto::select( 'initem.cod_item', 'initem.referencia', 'initem.descrip', 'initem.tasa_iva',
                                'initem.tasaivavta', 'initem.itm_linea', 'initem.grupo', 'initem.itm_extens',
                                'inlista.precio1', 'inlista.iva_inc_p1', 'inlista.precio1_ad', 'inlista.iva_pv1_ad',
                                'inlista.precio2', 'inlista.iva_inc_p2', 'inlista.precio2_ad', 'inlista.iva_pv2_ad',
                                'inlista.precio3', 'inlista.iva_inc_p3', 'inlista.precio3_ad', 'inlista.iva_pv3_ad',
                                'insaldo.actual_sdo', Producto::raw('(insaldo.actual_sdo - (insaldo.pdv_sdo + insaldo.sdo_asigpd)) as saldo_disponible')
                              )
                      ->leftjoin('inlista', 'inlista.cod_lis', '=', 'initem.cod_item') 
                      ->join('insaldo', 'insaldo.cod_sdo', '=', 'initem.cod_item')
                      ->havingRaw('saldo_disponible > ?', [0])
                      ->where('initem.grupo', $grupo)
                      ->whereNotIn('initem.cod_item', $idItem)
                      ->take($cantItems) 
                      ->get();

      return $data;  
    }

    /**
     * Obtiene un listado de productos de cantidad especifica de una linea
     */
    public static function obtenerProductosPorLinea($linea, $idItem, $cantItems) {

      $data = Producto::select()
                      ->leftjoin('inlista', 'inlista.cod_lis', '=', 'initem.cod_item') 
                      ->where('initem.itm_linea', $linea)
                      ->whereNotIn('initem.cod_item', $idItem)
                      ->take($cantItems) 
                      ->get();

      return $data;        
    }

    /**
     * Obtiene los productos relacionados a los codigos
     */
    public static function obtenerProductosPorCodigo($cods) {
      $data = Producto::select( 'initem.cod_item', 'initem.referencia', 'initem.descrip', 'initem.tasa_iva',
                                'initem.tasaivavta', 'initem.itm_linea', 'initem.grupo', 'initem.itm_extens',
                                'inlista.precio1', 'inlista.iva_inc_p1', 'inlista.precio1_ad', 'inlista.iva_pv1_ad',
                                'inlista.precio2', 'inlista.iva_inc_p2', 'inlista.precio2_ad', 'inlista.iva_pv2_ad',
                                'inlista.precio3', 'inlista.iva_inc_p3', 'inlista.precio3_ad', 'inlista.iva_pv3_ad',
                                'insaldo.actual_sdo', Producto::raw('(insaldo.actual_sdo - (insaldo.pdv_sdo + insaldo.sdo_asigpd)) as saldo_disponible')
                                )
                      ->leftjoin('inlista', 'inlista.cod_lis', '=', 'initem.cod_item') 
                      ->join('insaldo', 'insaldo.cod_sdo', '=', 'initem.cod_item')
                      ->havingRaw('saldo_disponible > ?', [0])
                      ->whereIn('initem.cod_item', $cods)
                      ->get();

      return $data;                
    }

    /**
     * Obtiene los productos relacionados con el nombre o con el codigo de barras
     */
    public static function obtenerProductosPorNomBarCode( $nomBarcode ) {
      $data = Producto::select( 'initem.cod_item', 'initem.referencia', 'initem.descrip', 'initem.tasa_iva',
                                'initem.tasaivavta', 'initem.itm_linea', 'initem.grupo', 'initem.itm_extens',
                                'inlista.precio1', 'inlista.iva_inc_p1', 'inlista.precio1_ad', 'inlista.iva_pv1_ad',
                                'inlista.precio2', 'inlista.iva_inc_p2', 'inlista.precio2_ad', 'inlista.iva_pv2_ad',
                                'inlista.precio3', 'inlista.iva_inc_p3', 'inlista.precio3_ad', 'inlista.iva_pv3_ad',
                                'insaldo.actual_sdo', Producto::raw('(insaldo.actual_sdo - (insaldo.pdv_sdo + insaldo.sdo_asigpd)) as saldo_disponible')
                                )
                      ->leftjoin('inlista', 'inlista.cod_lis', '=', 'initem.cod_item') 
                      ->join('insaldo', 'insaldo.cod_sdo', '=', 'initem.cod_item')
                      ->havingRaw('saldo_disponible > ?', [0])
                      ->where('initem.descrip', 'LIKE', "%$nomBarcode%")
                      ->orWhere('inlista.l_codebar', $nomBarcode)
                      ->get();

      return $data;         
    }

    /**
     * Obtiene un producto de un grupo específico
     */
    public static function obtenerProductoPorGrupo($tipo_gru) {
      $data = Producto::select()
                      ->where('initem.grupo', 'LIKE', "$tipo_gru%")
                      ->take(1) 
                      ->get();
      return $data;  
    }

    /**
     * Obtiene todos los productos de un grupo
     */
    public static function obtenerProductosPorTipoGrupo( $grupo ) {
      $data = Producto::select( 'initem.cod_item', 'initem.referencia', 'initem.descrip', 'initem.tasa_iva',
                                'initem.tasaivavta', 'initem.itm_linea', 'initem.grupo', 'initem.itm_extens',
                                'inlista.precio1', 'inlista.iva_inc_p1', 'inlista.precio1_ad', 'inlista.iva_pv1_ad',
                                'inlista.precio2', 'inlista.iva_inc_p2', 'inlista.precio2_ad', 'inlista.iva_pv2_ad',
                                'inlista.precio3', 'inlista.iva_inc_p3', 'inlista.precio3_ad', 'inlista.iva_pv3_ad',
                                'insaldo.actual_sdo', Producto::raw('(insaldo.actual_sdo - (insaldo.pdv_sdo + insaldo.sdo_asigpd)) as saldo_disponible')
                                )
                      ->leftjoin('inlista', 'inlista.cod_lis', '=', 'initem.cod_item') 
                      ->join('insaldo', 'insaldo.cod_sdo', '=', 'initem.cod_item')
                      ->havingRaw('saldo_disponible > ?', [0])
                      ->where('initem.grupo', 'LIKE', "$grupo%")
                      ->get();
      return $data;         
    }

    /**
     * Obtiene las unidades disponibles de un grupo de codigos de items
     */
    public static function obtenerUnidadesDisponibles( $codsItems ) {
      $data = Producto::select('initem.cod_item', Producto::raw('(insaldo.actual_sdo - (insaldo.pdv_sdo + insaldo.sdo_asigpd)) as saldo_disponible'))
                      ->join('insaldo', 'insaldo.cod_sdo', '=', 'initem.cod_item')
                      ->whereIn('initem.cod_item', $codsItems)
                      ->get();
      return $data;        
    }


}