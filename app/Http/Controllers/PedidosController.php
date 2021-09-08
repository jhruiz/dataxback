<?php

namespace App\Http\Controllers;

use App\Pedido;
use App\Configuracion;
use App\Cliente;
use App\Producto;
use App\Detallepedido;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class PedidosController extends Controller
{

    /**
     * Guarda el detalle del pedido
     */
    public function guardarDetallePedido($pdweb, $fechaAct, $pedido, $benef) {

        $cont = 1;
        foreach ( $pedido as $key => $val ) {

            // se obtiene la informacion del item
            $item = Producto::obtenerProducto( $val->cod_item );

            $data = array(
                'pd2_pdweb' => $pdweb,
                'pd2_fecha' => $fechaAct,
                'pd2_cliente' => $val->cod_benf,
                'pd2_reg' => $cont,
                'pd2_cod' => $val->cod_item,
                'pd2_cant' => $val->cantidad,
                'pd2_fecing' => $fechaAct,
                'pd2_pventa' => $val->precioventaunit,
                'pd2_impto' => $val->tasaiva,
                'pd2_vlriva' => $val->tasaiva,
                'pd2_color' => $item['0']->itm_color,
                'pd2_ventas' => !empty(trim($benef['0']->vende_benf)) ? trim($benef['0']->vende_benf) : '01'
                'exp_datax' => '0'
            );

            // guarda el detalle del pedido
            Detallepedido::guardarDetallePedido($data);

            $cont++;;
        }      

    }

    /**
     * Organiza la información del pedido principal
     */
    public function guardarPedidoPpal($pedido, $fechaAct, $benef) {

        // se obtiene el tipo de pago
        $tipoPago = Configuracion::obtenerTipoPago();

        // se obtienen los dias de credito
        $diasCredito = Configuracion::obtenerDiasCredito();

        // cod pedido web
        $pedWeb = $pedido['0']->usuario_id . $pedido['0']->pedido_id . date("is");
        // genera el arreglo para crear el pedido principal
        $data = array(
            'nro_pdweb' => $pedWeb,
            'pd_fecha' => $fechaAct,
            'pd_cliente' => $pedido['0']->cod_benf,
            'pd_qreg' => count($pedido),
            'pd_ventas' => !empty(trim($benef['0']->vende_benf)) ? trim($benef['0']->vende_benf) : '01',
            'pd_detalle' => 'Venta web',
            'pd_fec_ing' => $fechaAct,
            'pd_pago' => $tipoPago,
            'pd_credito' => $diasCredito,
            'pd_lista' => $benef['0']->lista_benf,
            'pd_sucBenf' => $benef['0']->suc_benf,
            'exp_datax' => '0'
        );

        // guarda el pedido
        if( Pedido::guardarPedido($data) ) {
            return $pedWeb;
        } else {
            return null;
        }
        
    }

    /**
     * Guardar el pedido
     */
    public function guardarPedido(Request $request) {

        $resp = array( 'estado' => false, 'data' => null, 'mensaje' => '' );

        $userId = $request['userId'];

        try {

            // se obtienen los pedidos
            if( !empty($userId) ) {

                $urlCotools = Configuracion::urlCotools();

                // obtiene el precio configurado para el cliente desde datax
                $client = new Client();
                $response = $client->request('GET', $urlCotools . 'get-simple-info-order/' . $userId);

                if($response->getStatusCode() == '200') {
                    $content = (string) $response->getBody()->getContents();
                    $pedido = json_decode($content);

                    // obtiene la fecha actual
                    $fechaAct = date('Y-m-d h:i:s');

                    // se obtiene la información del beneficiario
                    $benef = Cliente::obtenerClientePorCodigo( $pedido['0']->cod_benf );

                    // guarda la información del pedido 1
                    $pdweb = $this->guardarPedidoPpal($pedido, $fechaAct, $benef);

                    // valida si se guardó la información del pedido 1
                    if( !empty($pdweb) ) {
                        // guarda la información del detalle del pedido
                        $this->guardarDetallePedido($pdweb, $fechaAct, $pedido, $benef);
                    }

                    $resp['estado'] = true;
                    $resp['data'] = $pdweb;
                } else {
                    $resp['estado'] = false;
                }

            } else {
                $resp['mensaje'] = 'Debe realizar un pedido con un usuario registrado en la aplicación.';
            }
            

        } catch(Throwable $e) {
            return array( 'estado' => false, 'data' => null, 'mensaje' => $e );
        }

        return $resp;        
    }
}