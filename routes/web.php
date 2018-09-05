<?php


Route::get('/', 'HomeController@index');
Route::auth();
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function() {
	
	//Rotas de Usuário
	Route::group(['prefix'=> 'users', 'where'=>['id'=>'0-9+'],'middleware' => ['role:Administrador']], function () {
		Route::get('', ['as' => 'users.index', 'uses' => 'UserController@index']);
	    Route::get('/list',['as' => 'users.list', 'uses' => 'UserController@listar']);
	    Route::post('/create', ['as' => 'users.store', 'uses' => 'UserController@store']);
	    Route::post('/edit', ['as' => 'users.update', 'uses' => 'UserController@update']);
	    Route::post('/delete', ['as' => 'users.destroy', 'uses' => 'UserController@destroy',]);
	    Route::post('/ativar', ['as' => 'users.ativar', 'uses' => 'UserController@ativar',]);
	});

	//Rotas de Ambiente
	Route::group(['prefix'=> 'ambiente', 'where' => ['id'=>'0-9+'], 'middleware' => ['role:Administrador|Funcionário']],function (){
		Route::get('/',['as' => 'ambiente.index', 'uses' => 'AmbienteController@index']);
		Route::get('/list',['as' => 'ambiente.list', 'uses' => 'AmbienteController@list']);
		Route::post('/create', ['as' => 'ambiente.create', 'uses' => 'AmbienteController@store'])->middleware('role:Administrador');
		Route::post('/edit',['as' => 'ambiente.edit', 'uses' => 'AmbienteController@update'])->middleware('role:Administrador');
		Route::post('/delete',['as' => 'ambiente.destroy', 'uses'=> 'AmbienteController@destroy'])->middleware('role:Administrador');
		Route::post('/ativar',['as'=>'ambiente.ativar', 'uses' => 'AmbienteController@ativar'])->middleware('role:Administrador');
	});

	//Rotas de Locais
	Route::group(['prefix'=> 'locais', 'where' => ['id'=>'0-9+'], 'middleware' => ['role:Administrador|Funcionário']], function (){
		Route::get('/',['as' => 'locais.index', 'uses' => 'LocaisController@index']);
		Route::get('/list',['as' => 'locais.list', 'uses' => 'LocaisController@list']);
		Route::post('/create', ['as' => 'locais.create', 'uses' => 'LocaisController@store'])->middleware('role:Administrador');
		Route::post('/edit',['as' => 'locais.edit', 'uses' => 'LocaisController@update'])->middleware('role:Administrador');
		Route::post('/delete',['as' => 'locais.destroy', 'uses'=> 'LocaisController@destroy'])->middleware('role:Administrador');
	});

	//Rotas Tipo de equipamentos
	Route::group(['prefix'=> 'tipoEquipamento', 'where' => ['id'=>'0-9+'], 'middleware' => ['role:Administrador|Funcionário']], function (){
		Route::get('/',['as' => 'tipoEquipamento.index', 'uses' => 'TipoEquipamentoController@index']);
		Route::get('/list',['as' => 'tipoEquipamento.list', 'uses' => 'TipoEquipamentoController@list']);
		Route::post('/create', ['as' => 'tipoEquipamento.create', 'uses' => 'TipoEquipamentoController@store'])->middleware('role:Administrador');
		Route::post('/edit',['as' => 'tipoEquipamento.edit', 'uses' => 'TipoEquipamentoController@update'])->middleware('role:Administrador');
		Route::post('/delete',['as' => 'tipoEquipamento.destroy', 'uses'=> 'TipoEquipamentoController@destroy'])->middleware('role:Administrador');
	});

	//Rotas de equipamentos
	Route::group(['prefix'=> 'equipamentos', 'where' => ['id'=>'0-9+'], 'middleware' => ['role:Administrador|Funcionário']], function (){
		Route::get('/',['as' => 'equipamentos.index', 'uses' => 'EquipamentosController@index']);
		Route::get('/list',['as' => 'equipamentos.list', 'uses' => 'EquipamentosController@list']);
		Route::post('/create', ['as' => 'equipamentos.create', 'uses' => 'EquipamentosController@store'])->middleware('role:Administrador');
		Route::post('/edit',['as' => 'equipamentos.edit', 'uses' => 'EquipamentosController@update'])->middleware('role:Administrador');
		Route::post('/delete',['as' => 'equipamentos.destroy', 'uses'=> 'EquipamentosController@destroy'])->middleware('role:Administrador');
	});

});

