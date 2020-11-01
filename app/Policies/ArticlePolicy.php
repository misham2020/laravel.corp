<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
     public function save(User $user) {

        return $user->canDo('add_articles');
        
    } 
    public function viewAdminArticles(User $user) {

        return $user->canDo('view_admin_articles');
        
    } 
    public function edit(User $user) {

        return $user->canDo('update_articles');
        
    } 
    public function destroy(User $user) {
		return $user->canDo('delete_articles');
	}
}
