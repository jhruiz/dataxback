<?php

use Illuminate\Support\Facades\Route;

// Rutas para obtener información de clientes
Route::get('get-clients', 'App\Http\Controllers\ClientesController@obtenerClientes');
Route::get('get-client/{identificacion}/{email}', 'App\Http\Controllers\ClientesController@obtenerInfoCliente');

// Rutas para obtener la información de los productos
Route::get('get-products', 'App\Http\Controllers\ProductosController@obtenerProductos');
Route::get('get-product', 'App\Http\Controllers\ProductosController@obtenerProducto');
Route::get('get-info-items/{pagina}/{cantidad}', 'App\Http\Controllers\ProductosController@obtenerInfoProductos');
Route::get('get-details-item/{idItem}', 'App\Http\Controllers\ProductosController@obtenerDetallesProducto');
Route::get('get-items-by-cods/{cods}', 'App\Http\Controllers\ProductosController@obtenerProductosPorCodigo');
Route::get('get-items-by-namebc/{descBarCode}', 'App\Http\Controllers\ProductosController@obtenerProductosPorNombreBarcode');
Route::get('get-items-by-cod/{codGru}', 'App\Http\Controllers\ProductosController@obtenerProductosPorGrupo');
Route::get('get-item-price/{codBenf}/{codItem}', 'App\Http\Controllers\ProductosController@obtenerPrecioItemLista');
Route::get('get-available-units/{codsItems}', 'App\Http\Controllers\ProductosController@obtenerUnidadesDisponiblesItems');


// Rutas para obtener la información de los grupos
Route::get('get-groups', 'App\Http\Controllers\GruposController@obtenerGrupos');
Route::get('get-info-groups/{cods}', 'App\Http\Controllers\GruposController@obtenerInfoGrupos');

// Rutas para gestionar la información del pedido
Route::get('save-order', 'App\Http\Controllers\PedidosController@guardarPedido');

