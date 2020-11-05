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



Route::get('/', 'IndexController@index')->name('index');
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
	Route::get('/articles/edit/{article?}',['uses' => 'Admin\ArticlesController@edit', 'as' => 'admin.articles.edit']);
	Route::DELETE('/articles/destroy/{article?}',['uses' => 'Admin\ArticlesController@destroy', 'as' => 'admin.articles.destroy']);
	Route::get('/articles/create/',['uses' => 'Admin\ArticlesController@create', 'as' => 'admin.articles.create']); 
	Route::post('/articles/store/',['uses' => 'Admin\ArticlesController@store', 'as' => 'admin.articles.store']);  
	Route::put('/articles/update/{article?}',['uses' => 'Admin\ArticlesController@update', 'as' => 'admin.articles.update']);  
	
	Route::get('/permissions',['uses' => 'Admin\PermissionsController@index','as' => 'admin.permissions.index']);
	Route::post('/permissions/store/',['uses' => 'Admin\PermissionsController@store', 'as' => 'admin.permissions.store']);

	 Route::get('/menus',['uses' => 'Admin\MenusController@index','as' => 'admin.menus.index']);
	Route::get('/menus/create',['uses' => 'Admin\MenusController@create','as' => 'admin.menus.create']);
	Route::get('/menus/edit/{menus?}',['uses' => 'Admin\MenusController@edit', 'as' => 'admin.menus.edit']);
	Route::DELETE('/menus/destroy/{menus?}',['uses' => 'Admin\MenusController@destroy', 'as' => 'admin.menus.destroy']);
	Route::post('/menus/store/',['uses' => 'Admin\MenusController@store', 'as' => 'admin.menus.store']); 
	Route::put('/menus/update/{menus?}',['uses' => 'Admin\ArticlesController@update', 'as' => 'admin.menus.update']);

	Route::get('/users',['uses' => 'Admin\UsersController@index','as' => 'admin.users.index']);
	Route::get('/users/create',['uses' => 'Admin\UsersController@create','as' => 'admin.users.create']);
	Route::get('/users/edit/{users?}',['uses' => 'Admin\UsersController@edit', 'as' => 'admin.users.edit']);
	Route::DELETE('/users/destroy/{users?}',['uses' => 'Admin\UsersController@destroy', 'as' => 'admin.users.destroy']);
	Route::post('/users/store/',['uses' => 'Admin\UsersController@store', 'as' => 'admin.users.store']); 
	Route::put('/users/update/{users?}',['uses' => 'Admin\UsersController@update', 'as' => 'admin.users.update']);
	
	Route::get('/portfolios',['uses' => 'Admin\PortfoliosController@index','as' => 'admin.portfolios.index']);
	Route::get('/portfolios/create',['uses' => 'Admin\PortfoliosController@create','as' => 'admin.portfolios.create']);
	Route::get('/portfolios/edit/{port?}',['uses' => 'Admin\PortfoliosController@edit', 'as' => 'admin.portfolios.edit']);
	Route::DELETE('/portfolios/destroy/{port}',['uses' => 'Admin\PortfoliosController@destroy', 'as' => 'admin.portfolios.destroy']);
	Route::post('/portfolios/store',['uses' => 'Admin\PortfoliosController@store', 'as' => 'admin.portfolios.store']); 
	Route::put('/portfolios/update/{port?}',['uses' => 'Admin\PortfoliosController@update', 'as' => 'admin.portfolios.update']);
});

 Auth::routes(); 

	Route::get('/auth', 'HomeController@index')->name('home');






