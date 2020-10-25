<?php

namespace App\Repository;

use App\Menu;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

abstract class Repository
{
    protected $model;
    


    public function get ($select = '*', $take = '', $paginator = FALSE, $where = FALSE){
     
        $builder =($this->model)->select($select);

        if($take){
            $builder->take($take);
		}
		if($where){
			$builder->where($where[0], $where[1]);
						
		}
		
		if($paginator) {
			return $this->check($builder->paginate(2));
			
		}
        return $this->check($builder->get()); 
		
    }

	
    protected function check($result) {
		
		if($result->isEmpty()) {
			return FALSE;
		}
		
		$result->transform (function($item,$key) {
			
			if(is_string($item->img) && is_object(json_decode($item->img)) && (json_last_error() == JSON_ERROR_NONE)) {
				$item->img = json_decode($item->img);
			}
			
			

			return $item;
			
		});
		
		return $result;
		
	}
	public function one($alias,$attr = array()) {
		$result = $this->model->where('alias',$alias)->first();
		
		return $result;
	}
}