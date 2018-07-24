<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'HomeController@index');


Route::group(['prefix'=> 'users', 'where'=>['id'=>'0-9+']], function () {
    
//Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.    #adminlte_routes
Route::get('', ['as' => 'users.index', 'uses' => 'UserController@index']);
        Route::get('/list',['as' => 'users.list', 'uses' => 'UserController@listar']);
        Route::post('/create', ['as' => 'users.store', 'uses' => 'UserController@store']);
        Route::get('/edit', ['as' => 'users.update', 'uses' => 'UserController@update']);
        Route::post('/delete', ['as' => 'users.destroy', 'uses' => 'UserController@destroy',]);
        Route::post('/ativar', ['as' => 'users.ativar', 'uses' => 'UserController@ativar',]);
        Route::get('/load', ['as' => 'users.load', 'uses' => 'UserController@loadPapeis']);
        Route::get('/loadName', ['as' => 'users.loadName', 'uses' => 'UserController@loadNomePapel']);
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
