<?php

namespace App\Providers;

use App\Article;
use App\Comment;
use App\Portfolio;
use App\User;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;


class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/admin';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //
		
		//$router->pattern('alias','[\w-]+');
		
        parent::boot();
        
         Route::bind('menus', function ($value) {
        	return \App\Menu::where('id', $value)->first();
        });
        
        Route::bind('users', function ($value) {
        	return User::where('id', $value)->first();
        });  
        Route::bind('port', function ($value) {
        	return Portfolio::where('alias', $value)->first();
        });
        
        Route::bind('article', function ($value) {
        	return Article::where('alias', $value)->first();
        });
        Route::bind('comment', function ($value) {
        	return Comment::where('id', $value)->first();
        });  
       
   
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
