<?php

namespace App\Providers;

use App\Article;
use App\Policies\ArticlePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\User;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
       Article::class => ArticlePolicy::class,
        //'App\Admin\ArticlesController' => 'App\Policies\ArticlePolicy',
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //

         /* Gate::define('view_admin', function ($user) {
        	return $user->canDo('view_admin', FALSE);
        }); 
          
         Gate::define('view_admin_articles', function ($user) {
        	return $user->canDo('view_admin_articles', FALSE);
        });  */
    }
}
