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
	    Route::get('/load', ['as' => 'users.load', 'uses' => 'UserController@loadPapeis']);
	    Route::get('/loadName', ['as' => 'users.loadName', 'uses' => 'UserController@loadNomePapel']);
	});

	//Rotas de Ambiente
	Route::group(['prefix'=> 'ambiente', 'where' => ['id'=>'0-9+'], 'middleware' => ['role:Administrador']],function (){
		Route::get('/',['as' => 'ambiente.index', 'uses' => 'AmbienteController@index']);
		Route::get('/list',['as' => 'ambiente.list', 'uses' => 'AmbienteController@list']);
		Route::post('/create', ['as' => 'ambiente.create', 'uses' => 'AmbienteController@store']);
		Route::post('/edit',['as' => 'ambiente.edit', 'uses' => 'AmbienteController@update']);
		Route::post('/delete',['as' => 'ambiente.destroy', 'uses'=> 'AmbienteController@destroy']);
		Route::post('/ativar',['as'=>'ambiente.ativar', 'uses' => 'AmbienteController@ativar']);
	});

	//Rotas de Locais
	Route::group(['prefix'=> 'locais', 'where' => ['id'=>'0-9+'], 'middleware' => ['role:Administrador']], function (){
		Route::get('/',['as' => 'locais.index', 'uses' => 'LocaisController@index']);
		Route::get('/list',['as' => 'locais.list', 'uses' => 'LocaisController@list']);
		Route::post('/create', ['as' => 'locais.create', 'uses' => 'LocaisController@store']);
		Route::post('/edit',['as' => 'locais.edit', 'uses' => 'LocaisController@update']);
		Route::post('/delete',['as' => 'locais.destroy', 'uses'=> 'LocaisController@destroy']);
	});

	//Rotas Tipo de equipamentos
	Route::group(['prefix'=> 'tipoEquipamento', 'where' => ['id'=>'0-9+'], 'middleware' => ['role:Administrador']], function (){
		Route::get('/',['as' => 'locais.index', 'uses' => 'TipoEquipamentoController@index']);
		Route::get('/list',['as' => 'locais.list', 'uses' => 'TipoEquipamentoController@list']);
		Route::post('/create', ['as' => 'locais.create', 'uses' => 'TipoEquipamentoController@store']);
		Route::post('/edit',['as' => 'locais.edit', 'uses' => 'TipoEquipamentoController@update']);
		Route::post('/delete',['as' => 'locais.destroy', 'uses'=> 'TipoEquipamentoController@destroy']);
	});
});

