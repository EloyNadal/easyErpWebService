<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->post('/registrar', 'UsuarioAdminController@registrar');
$router->post('/login', 'UsuarioAdminController@login');

$router->group(['prefix' => 'categoria'], function () use ($router) 
{
	$router->get('/', ['uses' => 'CategoriaController@readAll']);
	$router->get('/{id}', ['uses' => 'CategoriaController@read']);
	$router->post('/', ['uses' => 'CategoriaController@create']);
	$router->delete('/{id}', ['uses' => 'CategoriaController@delete']);
	$router->put('/{id}', ['uses' => 'CategoriaController@update']);
});

$router->group(['prefix' => 'cliente'], function () use ($router) 
{
	$router->get('/', ['uses' => 'ClienteController@readAll']);
	$router->get('/{id}', ['uses' => 'ClienteController@read']);
	$router->post('/{metodo}', ['uses' => 'ClienteController@readQuery']);
	$router->post('/', ['uses' => 'ClienteController@create']);
	$router->delete('/{id}', ['uses' => 'ClienteController@delete']);
	$router->put('/{id}', ['uses' => 'ClienteController@update']);
});

$router->group(['prefix' => 'compra'], function () use ($router) 
{
	$router->get('/{id}', ['uses' => 'CompraController@read']);
	$router->post('/{metodo}', ['uses' => 'CompraController@readQuery']);
	$router->post('/', ['uses' => 'CompraController@create']);
	$router->put('/{id}', ['uses' => 'CompraController@update']);
});

$router->group(['prefix' => 'compralinea'], function () use ($router) 
{
	$router->get('/{id}', ['uses' => 'CompraLineaController@read']);
	$router->put('/{compra_id}', ['uses' => 'CompraLineaController@update']);
});

$router->group(['prefix' => 'grupocliente'], function () use ($router) 
{
	$router->get('/', ['uses' => 'GrupoClienteController@readAll']);
	$router->get('/{id}', ['uses' => 'GrupoClienteController@read']);
	$router->post('/', ['uses' => 'GrupoClienteController@create']);
	$router->delete('/{id}', ['uses' => 'GrupoClienteController@delete']);
	$router->put('/{id}', ['uses' => 'GrupoClienteController@update']);
});

$router->group(['prefix' => 'proveedor'], function () use ($router) 
{
	$router->get('/', ['uses' => 'ProveedorController@readAll']);
	$router->get('/{id}', ['uses' => 'ProveedorController@read']);
	$router->post('/{metodo}', ['uses' => 'ProductoController@readQuery']);
	$router->post('/', ['uses' => 'ProveedorController@create']);
	$router->delete('/{id}', ['uses' => 'ProveedorController@delete']);
	$router->put('/{id}', ['uses' => 'ProveedorController@update']);
});

$router->group(['prefix' => 'tienda'], function () use ($router) 
{
	$router->get('/', ['uses' => 'TiendaController@readAll']);
	$router->get('/{id}', ['uses' => 'TiendaController@read']);
	$router->post('/', ['uses' => 'TiendaController@create']);
	$router->delete('/{id}', ['uses' => 'TiendaController@delete']);
	$router->put('/{id}', ['uses' => 'TiendaController@update']);
});


$router->group(['prefix' => 'stock'], function () use ($router) 
{
	$router->get('/{id}', ['uses' => 'StockController@read']);
	$router->get('/', ['uses' => 'StockController@readAll']);
	$router->post('/{metodo}', ['uses' => 'StockController@readQuery']);
	$router->post('/', ['uses' => 'StockController@create']);
	$router->post('/[/init/]', ['uses' => 'StockController@createAll']);
	$router->put('/{id}', ['uses' => 'StockController@update']);
});

$router->group(['prefix' => 'tasa'], function () use ($router) 
{
	$router->get('/', ['uses' => 'TasaController@readAll']);
	$router->get('/{id}', ['uses' => 'TasaController@read']);
	$router->post('/', ['uses' => 'TasaController@create']);
	$router->delete('/{id}', ['uses' => 'TasaController@delete']);
	$router->put('/{id}', ['uses' => 'TasaController@update']);
});

$router->group(['prefix' => 'producto'], function () use ($router) 
{
	$router->get('/', ['uses' => 'ProductoController@readAll']);
	$router->get('/{id}', ['uses' => 'ProductoController@read']);
	$router->post('/{metodo}', ['uses' => 'ProductoController@readQuery']);
	$router->post('/', ['uses' => 'ProductoController@create']);
	$router->delete('/{id}', ['uses' => 'ProductoController@delete']);
	$router->put('/{id}', ['uses' => 'ProductoController@update']);
});

$router->group(['prefix' => 'grupousuario'], function () use ($router) 
{
	$router->get('/', ['uses' => 'GrupoUsuario@readAll']);
	$router->get('/{id}', ['uses' => 'GrupoUsuario@read']);
	$router->post('/', ['uses' => 'GrupoUsuario@create']);
	$router->delete('/{id}', ['uses' => 'GrupoUsuario@delete']);
	$router->put('/{id}', ['uses' => 'GrupoUsuario@update']);
});

$router->group(['prefix' => 'empleado'], function () use ($router) 
{
	$router->get('/', ['uses' => 'EmpleadoController@readAll']);
	$router->get('/{id}', ['uses' => 'EmpleadoController@read']);
	$router->post('/{metodo}', ['uses' => 'EmpleadoController@readQuery']);
	$router->post('/', ['uses' => 'EmpleadoController@create']);
	$router->delete('/{id}', ['uses' => 'EmpleadoController@delete']);
	$router->put('/{id}', ['uses' => 'EmpleadoController@update']);
});

$router->group(['prefix' => 'venta'], function () use ($router) 
{	
	$router->get('/{id}', ['uses' => 'VentaController@readAll']);
	$router->post('/{metodo}', ['uses' => 'VentaController@readQuery']);
	$router->post('/', ['uses' => 'VentaController@create']);
});

$router->group(['prefix' => 'ventalinea'], function () use ($router) 
{
	$router->get('/{id}', ['uses' => 'ventaLineaController@read']);
	$router->get('/', ['uses' => 'ventaLineaController@readByProduct']);
	$router->post('/{metodo}', ['uses' => 'ventaLineaController@readQuery']);
});

$router->group(['prefix' => 'productoproveedor'], function () use ($router) 
{
	$router->get('/', ['uses' => 'ProductoProveedorController@readAll']);
	$router->get('/{id}', ['uses' => 'ProductoProveedorController@read']);
	$router->post('/', ['uses' => 'ProductoProveedorController@create']);
	$router->delete('/{id}', ['uses' => 'ProductoProveedorController@delete']);
	$router->put('/{id}', ['uses' => 'ProductoProveedorController@update']);
});


//Generar key
$router->get('/key', function () {
    return str_random(32);
});