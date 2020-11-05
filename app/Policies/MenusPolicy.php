<?php

namespace App\Policies;

use App\Menu;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenusPolicy
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
    public function admin(User $user) {

        return $user->canDo('admin_role');
        
    } 
    
}
