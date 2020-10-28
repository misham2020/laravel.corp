<?php

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
	
	
	
});

 Auth::routes(); 

	Route::get('/auth', 'HomeController@index')->name('home');






