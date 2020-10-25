<?php
namespace App\Repository;

use App\Slider;
use App\Repository\Repository;

use Illuminate\Support\Facades\DB;

class SlidersRepository extends Repository
{
     public function __construct(Slider $slider)
    {
    
        $this->model = $slider;
        
        
     
    } 
}