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
			Route::get('/cidade/{estado}',['as' => 'user.cidade','uses' => 'UserController@selectCidade']);
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

		//Rotas Tipo de Ambiente
		Route::group(['prefix'=> 'tipoAmbiente', 'where' => ['id'=>'0-9+'], 'middleware' => ['role:Administrador|Funcionário']], function (){
			Route::get('/',['as' => 'tipoAmbiente.index', 'uses' => 'TipoAmbienteController@index']);
			Route::get('/list',['as' => 'tipoAmbiente.list', 'uses' => 'TipoAmbienteController@list']);
			Route::post('/create', ['as' => 'tipoAmbiente.create', 'uses' => 'TipoAmbienteController@store'])->middleware('role:Administrador');
			Route::post('/edit',['as' => 'tipoAmbiente.edit', 'uses' => 'TipoAmbienteController@update'])->middleware('role:Administrador');
			Route::post('/delete',['as' => 'tipoAmbiente.destroy', 'uses'=> 'TipoAmbienteController@destroy'])->middleware('role:Administrador');
		});

		//Rotas de equipamentos
		Route::group(['prefix'=> 'equipamentos', 'where' => ['id'=>'0-9+'], 'middleware' => ['role:Administrador|Funcionário']], function (){
			Route::get('/',['as' => 'equipamentos.index', 'uses' => 'EquipamentosController@index']);
			Route::get('/list',['as' => 'equipamentos.list', 'uses' => 'EquipamentosController@list']);
			Route::post('/create', ['as' => 'equipamentos.create', 'uses' => 'EquipamentosController@store'])->middleware('role:Administrador');
			Route::post('/edit',['as' => 'equipamentos.edit', 'uses' => 'EquipamentosController@update'])->middleware('role:Administrador');
			Route::post('/delete',['as' => 'equipamentos.destroy', 'uses'=> 'EquipamentosController@destroy'])->middleware('role:Administrador');
		});

		//Rotas de Manutenção
		Route::group(['prefix'=> 'manutencoes', 'where' => ['id'=>'0-9+'], 'middleware' => ['role:Administrador|Funcionário']], function (){
			Route::get('/',['as' => 'manutencoes.index', 'uses' => 'ManutencoesController@index']);
			Route::get('/list',['as' => 'manutencoes.list', 'uses' => 'ManutencoesController@list']);
			Route::post('/create', ['as' => 'manutencoes.create', 'uses' => 'ManutencoesController@store'])->middleware('role:Administrador');
			Route::post('/edit',['as' => 'manutencoes.edit', 'uses' => 'ManutencoesController@update'])->middleware('role:Administrador');
			Route::post('/delete',['as' => 'manutencoes.destroy', 'uses'=> 'ManutencoesController@destroy'])->middleware('role:Administrador');
		});

		//Rotas de Reservas de ambiente
		Route::group(['prefix'=> 'reserva-ambiente', 'where' => ['id'=>'0-9+']], function (){
			Route::get('/',['as' => 'reserva-ambiente.index', 'uses' => 'ReservaAmbienteController@index']);
			Route::get('/list',['as' => 'reserva-ambiente.list', 'uses' => 'ReservaAmbienteController@list']);
			Route::post('/create', ['as' => 'resereva-ambiente.create', 'uses' => 'ReservaAmbienteController@store']);
			Route::post('/edit',['as' => 'reserva-ambiente.edit', 'uses' => 'ReservaAmbienteController@update'])->middleware('role:Administrador|Funcionário');
			Route::post('/cancelar',['as' => 'reserva-ambiente.cancelar', 'uses'=> 'ReservaAmbienteController@cancelar']);
			Route::post('/delete',['as' => 'reserva-ambiente.destroy', 'uses'=> 'ReservaAmbienteController@destroy']);
			Route::get('/reservados/{dados}',['as' => 'reserva-ambiente.reservados', 'uses' => 'ReservaAmbienteController@reservados']);
			Route::post('/feedback',['as' => 'reserva-ambiente.feedback', 'uses'=> 'ReservaAmbienteController@feedback']);
		});


	
	
});

