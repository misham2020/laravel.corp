<?php

namespace App\Repository;

use App\Portfolio;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Image;
use Illuminate\Support\Str;

class PortfoliosRepository extends Repository
{
    public function __construct(Portfolio $portfolio)
    {
       
        $this->model = $portfolio;
        
        
    }
    public function addPortfolio($request) {

		// if(Gate::denies('save', $this->model)) {
		// 	abort(403);
		// }
		
		$data = $request->except('_token','image');
		
		if(empty($data)) {
			return array('error' => 'Нет данных');
		}
		
		if(empty($data['alias'])) {
			$data['alias'] = $this->transliterate($data['title']);
		}
		
		if($this->one($data['alias'],FALSE)) {
			$request->merge(array('alias' => $data['alias']));
			$request->flash();
			
			return ['error' => 'Данный псевдоним уже успользуется'];
		}
		
		if($request->hasFile('image')) {
			$image = $request->file('image');
			
			if($image->isValid()) {
				
				$str = Str::random(8);
				
				$obj = new \stdClass;
				
				$obj->mini = $str.'_mini.jpg';
				$obj->max = $str.'_max.jpg';
				$obj->path = $str.'.jpg';
				
				$img = Image::make($image);
				
				$img->fit(Config::get('settings.image')['width'],
						Config::get('settings.image')['height'])->save(public_path().'/site/images/projects/'.$obj->path); 
				
				$img->fit(Config::get('settings.articles_img')['maxP']['width'],
						Config::get('settings.articles_img')['maxP']['height'])->save(public_path().'/site/images/projects/'.$obj->max); 
				
				$img->fit(Config::get('settings.articles_img')['miniP']['width'],
						Config::get('settings.articles_img')['miniP']['height'])->save(public_path().'/site/images/projects/'.$obj->mini);

				
				$data['img'] = json_encode($obj);  
				
				/* $this->model->fill($data); 
				
				if($request->portfolio()->save($this->model)) {
					return ['status' => 'Материал добавлен'];
				} */     
				if ($this->model->fill($data)->save()) {
					return ['status'=>'Ссылка добавлена'];
				}                     
				
			}
			
		}
	
	}
	public function updatePortfolio($request, $portfolio) {

		
		$data = $request->except('_token','image','_method');
		
		if(empty($data)) {
			return array('error' => 'Нет данных');
		}
		
		if(empty($data['alias'])) {
			$data['alias'] = $this->transliterate($data['title']);
		}
		
		$result = $this->one($data['alias'],FALSE);
		
		if(isset($result->id) && ($result->id != $portfolio->id)) {
			$request->merge(array('alias' => $data['alias']));
			$request->flash();
			
			return ['error' => 'Данный псевдоним уже успользуется'];
		}
		
		if($request->hasFile('image')) {
			$image = $request->file('image');
			
			if($image->isValid()) {
				
				$str = Str::random(8);
				
				$obj = new \stdClass;
				
				$obj->mini = $str.'_mini.jpg';
				$obj->max = $str.'_max.jpg';
				$obj->path = $str.'.jpg';
				
				$img = Image::make($image);
				
				$img->fit(Config::get('settings.image')['width'],
						Config::get('settings.image')['height'])->save(public_path().'/'.env('THEME').'/images/articles/'.$obj->path); 
				
				$img->fit(Config::get('settings.articles_img')['max']['width'],
						Config::get('settings.articles_img')['max']['height'])->save(public_path().'/'.env('THEME').'/images/articles/'.$obj->max); 
				
				$img->fit(Config::get('settings.articles_img')['mini']['width'],
						Config::get('settings.articles_img')['mini']['height'])->save(public_path().'/'.env('THEME').'/images/articles/'.$obj->mini); 
						
				
				$data['img'] = json_encode($obj);  
				
				                         
				
			}
			
			
			
		}
		
		$portfolio->fill($data); 
				
		if($portfolio->update()) {
			return ['status' => 'Материал обновлен'];
		} 

	}
	
	
	public function deletePortfolio($portfolio) {
		
		
		if($portfolio->delete()) {
			return ['status' => 'Материал удален'];
		}
		
	}
}