<?php

namespace App\Repository;

use App\Menu;
use App\Repository\Repository;
use Illuminate\Support\Facades\DB;

class MenusRepository extends Repository
{
    public function __construct(Menu $menu)
    {
       
//dd($menu);
        $this->model = $menu;
        
        
    }
}