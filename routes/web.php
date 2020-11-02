<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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



Route::get('/', 'IndexController@index')->name('home');
Route::get('/articles', 'ArticlesController@index')->name('articles');
Route::get('/portfolios', 'PortfoliosController@index')->name('portfolio');
Route::get('/articles/cat/{cat_alias?}', 'ArticlesController@index')->name('articlesCat');
Route::get('/articles/{alias}', 'ArticlesController@show')->name('articles.show');
Route::get('/portfolios/{alias}','PortfoliosController@show')->name('portfolios.show');
Route::resource('comment','CommentController',['only'=>['store']]);
Route::match(['get', 'post'],'/contacts', 'ContactController@index')->name('contacts');

//admin
Route::group(['prefix' => 'admin','middleware'=> 'auth' ],function() {
	
	//admin
	Route::get('/',['uses' => 'Admin\IndexController@index','as' => 'adminIndex']);
	
	Route::get('/articles',['uses' => 'Admin\ArticlesController@index','as' => 'admin.articles.index']);
	//Route::resource('/articles','Admin\ArticlesController');
	Route::get('/articles/edit/{alias?}',['uses' => 'Admin\ArticlesController@edit', 'as' => 'admin.articles.edit']);
	Route::DELETE('/articles/destroy/{alias}',['uses' => 'Admin\ArticlesController@destroy', 'as' => 'admin.articles.destroy']);
	Route::get('/articles/create/',['uses' => 'Admin\ArticlesController@create', 'as' => 'admin.articles.create']); 
	Route::post('/articles/store/',['uses' => 'Admin\ArticlesController@store', 'as' => 'admin.articles.store']);  
	Route::put('/articles/update/{alias}',['uses' => 'Admin\ArticlesController@update', 'as' => 'admin.articles.update']);  
	
	Route::get('/permissions',['uses' => 'Admin\PermissionsController@index','as' => 'admin.permissions.index']);
	Route::post('/permissions/store/',['uses' => 'Admin\PermissionsController@store', 'as' => 'admin.permissions.store']);
	Route::get('/menus',['uses' => 'Admin\MenusController@index','as' => 'admin.menus.index']);
	Route::get('/menus/create',['uses' => 'Admin\MenusController@create','as' => 'admin.menus.create']);
	Route::get('/menus/edit/{alias?}',['uses' => 'Admin\MenusController@edit', 'as' => 'admin.menus.edit']);
	Route::DELETE('/menus/destroy/{alias?}',['uses' => 'Admin\MenusController@destroy', 'as' => 'admin.menus.destroy']);
	Route::post('/menus/store/',['uses' => 'Admin\MenusController@store', 'as' => 'admin.menus.store']);
});

 Auth::routes(); 

	Route::get('/auth', 'HomeController@index')->name('home');






