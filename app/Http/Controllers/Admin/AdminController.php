<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Lavary\Menu\Menu as LavMenu;

class AdminController extends \App\Http\Controllers\Controller
{
     
    protected $portfolioRepository;
    
    protected $articlesRepository;
    
    protected $user;
    
    protected $template;
    
    protected $content = FALSE;
    
    protected $title;
    
    protected $vars;
    
    public function __construct() {
		
		$this->user =(new Auth)::user();
		

	}
	
	public function renderOutput() {
		$this->vars = (new Arr)->add($this->vars,'title',$this->title);
		
		$menu = $this->getMenu();
		
		$navigation = view('admin.navigation')->with('menu',$menu)->render();
		$this->vars = (new Arr)->add($this->vars,'navigation',$navigation);
		
		if($this->content) {
			$this->vars = (new Arr)->add($this->vars,'content',$this->content);
		}
		
		$footer = view('admin.footer')->render();
		$this->vars = (new Arr)->add($this->vars,'footer',$footer);
		
		return view($this->template)->with($this->vars);
		
	}
	
	public function getMenu() {
		return (new LavMenu)->make('adminMenu', function($menu) {
			
			$menu->add('Статьи',array('route' => 'admin.articles.index'));

            if ((new Gate)::allows('admin', new User())) {
            
                $menu->add('Портфолио', array('route'  => 'admin.portfolios.index'));
                $menu->add('Меню', array('route'  => 'admin.menus.index'));
                $menu->add('Пользователи', array('route'  => 'admin.users.index'));
                $menu->add('Привилегии', array('route'  => 'admin.permissions.index'));
                $menu->add('главная', array('route'  => 'index'));
                $menu->add('Комментарии', array('route'  => 'admin.comments.index'));
            }
			
		});
	}
}
