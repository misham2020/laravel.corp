<?php

namespace App\Http\Controllers;


use App\Repository\MenusRepository;
use App\Repository\SlidersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Lavary\Menu\Menu as LavMenu;

class SiteController extends Controller
{
    protected $menusRepository;
    protected $portfolioRepository;
    protected $commentsRepository;
    protected $articlesRepository;
    protected $slidersRepository;
    protected $contentRightBar = FALSE;
	protected $contentLeftBar = FALSE;
    protected $template;
    protected $vars;
    protected $bar = 'no';

    public function __construct(MenusRepository $menusRepository)
    {
        $this->menusRepository = $menusRepository;
        
    }

    public function renderOutput(){

    $menu = $this->getMenu(); 
    $nav = view('nav')->with('menu',$menu)->render();
    $this->vars = (new Arr)->add($this->vars, 'nav', $nav);

    $footer = view('footer')->render();
    $this->vars = (new Arr)->add($this->vars, 'footer', $footer);

    if($this->contentRightBar) {

        $rightBar = view('rightBar')->with('content_rightBar',$this->contentRightBar)->render();
        $this->vars = (new Arr)->add($this->vars, 'rightBar', $rightBar); 
    }

    if($this->contentLeftBar) {

        $leftBar = view('leftBar')->with('content_leftBar',$this->contentLeftBar)->render();
        $this->vars = (new Arr)->add($this->vars, 'leftBar', $leftBar); 
    } 
    $this->vars = (new Arr)->add($this->vars,'bar',$this->bar);
    
     return view($this->template)->with($this->vars);
    }
    
   public function getMenu() {
		
   $menu = $this->menusRepository->get('*', FALSE, FALSE);
    
    $mBuilder = (new LavMenu)->make('MyNav', function($m) use ($menu) {
        
        foreach($menu as $item){
            /*
             * Для родительского пункта меню формируем элемент меню в корне
             * и с помощью метода id присваиваем каждому пункту идентификатор
             */
            if($item->parent_id == 0){
                $m->add($item->title, $item->path)->id($item->id);
            }
            //иначе формируем дочерний пункт меню
            else {
                //ищем для текущего дочернего пункта меню в объекте меню ($m)
                //id родительского пункта (из БД)
                if($m->find($item->parent_id)){
                    $m->find($item->parent_id)->add($item->title, $item->path)->id($item->id);
               }
            }
        }
    });
   return $mBuilder;
    
}	
}
