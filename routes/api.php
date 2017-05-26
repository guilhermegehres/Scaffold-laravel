<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');




//CRUD para entidade 'produtos' do banco
//Seu respectivo controller é 'ProdutosController'
//Seu respectivo model é 'Produtos'

Route::get('/produtos/{id?}', ['alias' => '/produtos' , 'uses' => 'ProdutosController@getProdutos']);
Route::post('/produtos', ['alias' => '/produtos' , 'uses' => 'ProdutosController@storeProdutos']);
Route::post('/produtos/update/{id}', ['alias' => '/produtos' , 'uses' => 'ProdutosController@storeProdutos']);
Route::post('/produtos/filtro', ['alias' => '/produtos' , 'uses' => 'ProdutosController@getProdutosByFiltro']);
Route::delete('/produtos/{id}', ['alias' => '/produtos' , 'uses' => 'ProdutosController@deleteProdutos']);


//CRUD para entidade 'produtos' do banco
//Seu respectivo controller é 'ProdutosController'
//Seu respectivo model é 'Produtos'

Route::get('/produtos/{id?}', ['alias' => '/produtos' , 'uses' => 'ProdutosController@getProdutos']);
Route::post('/produtos', ['alias' => '/produtos' , 'uses' => 'ProdutosController@storeProdutos']);
Route::post('/produtos/update/{id}', ['alias' => '/produtos' , 'uses' => 'ProdutosController@storeProdutos']);
Route::post('/produtos/filtro', ['alias' => '/produtos' , 'uses' => 'ProdutosController@getProdutosByFiltro']);
Route::delete('/produtos/{id}', ['alias' => '/produtos' , 'uses' => 'ProdutosController@deleteProdutos']);


//CRUD para entidade 'produtos' do banco
//Seu respectivo controller é 'ProdutosController'
//Seu respectivo model é 'Produtos'

Route::get('/produtos/{id?}', ['alias' => '/produtos' , 'uses' => 'ProdutosController@getProdutos']);
Route::post('/produtos', ['alias' => '/produtos' , 'uses' => 'ProdutosController@storeProdutos']);
Route::post('/produtos/update/{id}', ['alias' => '/produtos' , 'uses' => 'ProdutosController@storeProdutos']);
Route::post('/produtos/filtro', ['alias' => '/produtos' , 'uses' => 'ProdutosController@getProdutosByFiltro']);
Route::delete('/produtos/{id}', ['alias' => '/produtos' , 'uses' => 'ProdutosController@deleteProdutos']);

//**ROTAS**
