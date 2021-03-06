<?php

namespace App\Providers;

use App\Article;
use App\Menu;
use App\Permission;
use App\Policies\ArticlePolicy;
use App\Policies\MenusPolicy;
use App\Policies\UserPolicy;
use App\Policies\PermissionsPolicy;
use App\Policies\PortfoliosPolicy;
use App\Portfolio;
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
       Permission::class => PermissionsPolicy::class,
       Menu::class => MenusPolicy::class,
       User::class => UserPolicy::class,
       Portfolio::class => PortfoliosPolicy::class,
        
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

       /*  Gate::define('admin_role', function ($user) {
        	return $user->canDo('admin_role', FALSE);
        }); 
          
         Gate::define('view_admin_articles', function ($user) {
        	return $user->canDo('view_admin_articles', FALSE);
        });   */
    }
}
