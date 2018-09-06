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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/cunha', function () {
	return view('cunha');
});

Auth::routes();

//Route::get('/home', 'HomeController@index');
//
Route::get('/', 'PostController@index')->name('home');

Route::resource('users', 'UserController');

Route::resource('roles', 'RoleController');

Route::resource('permissions', 'PermissionController');

Route::resource('posts', 'PostController');

Route::resource('countries', 'CountryController');

Route::resource('votes', 'VoteController');

Route::get('/sian', 'SianController@index');
Route::get('/sian/{id}/status/{status?}', 'SianController@analisar')->name('sian');


Route::get('/aprove', 'SianController@aproveOrder');
Route::get('/boleto', 'SianController@boleto')->name('boleto');
Route::post('/isentar', 'SianController@isentar');
Route::get('/comparativo', 'SianController@comparativo');
Route::post('/comparativo', 'SianController@comparativo');
Route::post('/apagar', 'SianController@apagar')->name('apagar');
Route::get('/apagar', 'SianController@apagar')->name('apagar');
Route::get('/sugestao', 'SianController@sugestaoCompra')->name('sugestao');
Route::get('/conta', 'SianController@testeConta');
Route::get('/localiza/{id}', 'SianController@find');
Route::get('/editar/{id}', 'SianController@editar');
Route::get('/media', 'MediaController@media');
Route::post('/media', 'MediaController@media');
Route::get('/zera-combo/{id}/combo/{combo}/retira/{retira?}', 'MediaController@zeraCombo');
Route::get('usersian', 'UserPasswordController@index');
Route::post('usersiangrava', 'UserPasswordController@store')->name('usersiangrava');
Route::get('/formteste', 'MediaController@formTeste');
Route::get('/sian/visit/{id}', 'Sian\VisitController@index');





Route::get('/home', 'HomeController@index');
