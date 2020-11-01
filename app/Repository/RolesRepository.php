<?php

namespace App\Repository;

use App\Repository\Repository;
use App\Role;


class RolesRepository extends Repository
{
    public function __construct(Role $role)
    {
       

        $this->model = $role;
        
        
    }
}