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
	$router->post('/', ['uses' => 'ClienteController@create']);
	$router->delete('/{id}', ['uses' => 'ClienteController@delete']);
	$router->put('/{id}', ['uses' => 'ClienteController@update']);
});

$router->group(['prefix' => 'compra'], function () use ($router) 
{
	$router->get('/{tienda_id}', ['uses' => 'CompraController@readAll']);
	$router->get('/{tienda_id}/{id}', ['uses' => 'CompraController@read']);
	$router->post('/', ['uses' => 'CompraController@create']);
});

$router->group(['prefix' => 'compraLina'], function () use ($router) 
{
	$router->get('/{tienda_id}', ['uses' => 'CompraController@readAll']);
	$router->get('/{tienda_id}/{compra_id}', ['uses' => 'CompraController@read']);
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
	$router->get('/{tienda_id}/{producto_id}', ['uses' => 'StockController@read']);
	$router->get('/', ['uses' => 'StockController@readAllShops']);
	$router->get('/{tienda_id}', ['uses' => 'StockController@readOneShop']);
	$router->post('/', ['uses' => 'StockController@createAll']);
	$router->put('/', ['uses' => 'StockController@update']);
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


//Generar key
$router->get('/key', function () {
    return str_random(32);
});