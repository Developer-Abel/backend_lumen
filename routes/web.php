<?php

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['middleware'=>'json'], function() use ($router){
	$router->post('/login','UsersController@login');
	$router->post('/registrer','UsersController@registrer');
	$router->group(['middleware'=>'auth'], function() use ($router){
		$router->get('/users','UsersController@index');
		$router->get('/create','UsersController@create');
		$router->get('/logout','UsersController@logout');
		$router->get('/usuario_empresa','UsersController@empresa');
		// Cotizacion
		$router->get('/documentosAll','DocumentoController@all');
		$router->post('/documentoDeleted','DocumentoController@deleted');
		$router->get('/documentos/{id}','DocumentoController@index');
		$router->post('/crear_documento','DocumentoController@create');
		$router->post('/editar','DocumentoController@edit');
		$router->post('/delete','DocumentoController@delete_item');
		$router->post('/actualizar','DocumentoController@actualizarItem');
		$router->post('/guardarDoc','DocumentoController@update');
		/** catalogos **/
		$router->get('/acabados','CatalogoController@acabado');
		$router->get('/tipo_papel','CatalogoController@tipo_papel');
		$router->get('/tipo_maquina','CatalogoController@tipo_maquina');
		$router->get('/pais','CatalogoController@pais');
		$router->get('/estado','CatalogoController@estado');
		/** Terceros clientes**/
		$router->get('/clientes','TerceroController@index_cli');
		$router->post('/getCliente','TerceroController@getCliente');
		$router->post('/saveCliente','TerceroController@saveCliente');
		$router->post('/editarCliente','TerceroController@editarCliente');
		$router->post('/actualizarCliente','TerceroController@actualizarCliente');
		$router->post('/eliminarCliente','TerceroController@eliminarCliente');
	});
});



