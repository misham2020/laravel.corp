<?php

namespace App\Repository;

use App\Portfolio;

class PortfoliosRepository extends Repository
{
    public function __construct(Portfolio $portfolio)
    {
       
        $this->model = $portfolio;
        
        
    }
}