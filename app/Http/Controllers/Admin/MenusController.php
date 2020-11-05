<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Menu;
use App\Filter;
use App\Http\Controllers\Controller;
use App\Http\Requests\MenusRequest;
use App\Repository\ArticlesRepository;
use App\Repository\MenusRepository;
use App\Repository\PortfoliosRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Lavary\Menu\Menu as LavMenu;
use App\Policies\MenusPolicy;

class MenusController extends AdminController
{
    
    protected $menusRepository;
    
    
    public function __construct(MenusRepository $menusRepository, ArticlesRepository $articlesRepository, PortfoliosRepository $portfoliosRepository)
    {
        parent::__construct();
        
        
        
        $this->menusRepository = $menusRepository;
        $this->articlesRepository = $articlesRepository;
        $this->portfoliosRepository = $portfoliosRepository;
        
        $this->template = 'admin.menus';
        
        //
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if((new Gate)::denies('admin', new Menu)) {
			abort(403);
		} 
        $menu = $this->getMenus();
        
        $this->content = view('admin.menus_content')->with('menus',$menu)->render();
        
        return $this->renderOutput();
    }
    
    public function getMenus()
    {
        //
        
        $menu = $this->menusRepository->get();
        
        if($menu->isEmpty()) {
			return FALSE;
		}
		
		return (new LavMenu)->make('forMenuPart', function($m) use($menu) {
			
			foreach($menu as $item) {
				if($item->parent_id == 0) {
					$m->add($item->title,$item->path)->id($item->id);
				}
				
				else {
					if($m->find($item->parent_id)) {
						$m->find($item->parent_id)->add($item->title,$item->path)->id($item->id);
					}
				}
			}
			
		});
		

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	
    	$this->title = 'Новый пункт меню';
    	
    	$tmp = $this->getMenus()->roots();
    	
    	//null
    	$menus = $tmp->reduce(function($returnMenus, $menu) {
    		
    		$returnMenus[$menu->id] = $menu->title;
    		return $returnMenus;	
    		
    	},['0' => 'Родительский пункт меню']);
    	
    	$categories = Category::select(['title','alias','parent_id','id'])->get();
    	
    	$list = array();
    	$list = (new Arr)->add($list,'0','Не используется');
    	$list = (new Arr)->add($list,'parent','Раздел блог');
    	
    	foreach($categories as $category) {
			if($category->parent_id == 0) {
				$list[$category->title] = array();
			}
			else {
				$list[$categories->where('id',$category->parent_id)->first()->title][$category->alias] = $category->title;
			}
		}
    	
    	$articles = $this->articlesRepository->get(['id','title','alias']);
    	
    	$articles = $articles->reduce(function ($returnArticles, $article) {
		    $returnArticles[$article->alias] = $article->title;
		    return $returnArticles;
		}, []);
		
		
		$filters = Filter::select('id','title','alias')->get()->reduce(function ($returnFilters, $filter) {
		    $returnFilters[$filter->alias] = $filter->title;
		    return $returnFilters;
		}, ['parent' => 'Раздел портфолио']);
		
 		$portfolios = $this->portfoliosRepository->get(['id','alias','title'])->reduce(function ($returnPortfolios, $portfolio) {
		    $returnPortfolios[$portfolio->alias] = $portfolio->title;
		    return $returnPortfolios;
		}, []); 
		
		$this->content = view('admin.menus_create_content')->with(['menus'=>$menus,'categories'=>$list,'articles'=>$articles,'filters' => $filters,'portfolios' => $portfolios])->render();
		
		
		
		return $this->renderOutput();
		
 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenusRequest $request)
    {
        //
        $result = $this->menusRepository->addMenu($request);
		
		if(is_array($result) && !empty($result['error'])) {
			return back()->with($result);
		}
		
		return redirect('/admin')->with($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        
       // dd($menu);
       $this->title = 'Редактирование ссылки - '.$menu->title;
        
        $type = FALSE;
        $option = FALSE;
        
        //path - http://corporate.loc/articles
        $route = app('router')->getRoutes()->match(app('request')->create($menu->path));       
        
        $aliasRoute = $route->getName();
        $parameters = $route->parameters();
        
       // dump($aliasRoute);
       // dump($parameters);
        
        if($aliasRoute == 'articles.index' || $aliasRoute == 'articlesCat') {
			$type = 'blogLink';
			$option = isset($parameters['cat_alias']) ? $parameters['cat_alias'] : 'parent';
		}
		
		else if($aliasRoute == 'articles.show') {
			$type = 'blogLink';
			$option = isset($parameters['alias']) ? $parameters['alias'] : '';
		
		}
		
		else if($aliasRoute == 'portfolios.index') {
			$type = 'portfolioLink';
			$option = 'parent';
		
		}
		
		else if($aliasRoute == 'portfolios.show') {
			$type = 'portfolioLink';
			$option = isset($parameters['alias']) ? $parameters['alias'] : '';
		
		}
		
		else {
			$type = 'customLink';
		}
		
		
    	
    	//dd($type);
    	$tmp = $this->getMenus()->roots();
    	
    	//null
    	$menus = $tmp->reduce(function($returnMenus, $menu) {
    		
    		$returnMenus[$menu->id] = $menu->title;
    		return $returnMenus;	
    		
    	},['0' => 'Родительский пункт меню']);
    	
    	$categories = Category::select(['title','alias','parent_id','id'])->get();
    	
    	$list = array();
    	$list = (new Arr)->add($list,'0','Не используется');
    	$list = (new Arr)->add($list,'parent_id','Раздел блог');
    	
    	foreach($categories as $category) {
			if($category->parent_id == 0) {
				$list[$category->title] = array();
			}
			else {
				$list[$categories->where('id',$category->parent_id)->first()->title][$category->alias] = $category->title;
			}
		}
    	
    	$articles = $this->articlesRepository->get(['id','title','alias']);
    	
    	$articles = $articles->reduce(function ($returnArticles, $article) {
		    $returnArticles[$article->alias] = $article->title;
		    return $returnArticles;
		}, []);
		
		
		$filters = Filter::select('id','title','alias')->get()->reduce(function ($returnFilters, $filter) {
		    $returnFilters[$filter->alias] = $filter->title;
		    return $returnFilters;
		}, ['parent_id' => 'Раздел портфолио']);
		
		$portfolios = $this->portfoliosRepository->get(['id','alias','title'])->reduce(function ($returnPortfolios, $portfolio) {
		    $returnPortfolios[$portfolio->alias] = $portfolio->title;
		    return $returnPortfolios;
		}, []);
		
		$this->content = view('admin.menus_create_content')->with(['menu' => $menu,'type' => $type,'option' => $option,'menus'=>$menus,'categories'=>$list,'articles'=>$articles,'filters' => $filters,'portfolios' => $portfolios])->render();
		
		
		
		return $this->renderOutput();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Menu $menu)
    {
        //
        $result = $this->menusRepository->updateMenu($request,$menu);
		
		if(is_array($result) && !empty($result['error'])) {
			return back()->with($result); 
		}
		
		return redirect('/admin')->with($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        //
        
        //
        $result = $this->menusRepository->deleteMenu($menu);
		
		if(is_array($result) && !empty($result['error'])) {
			return back()->with($result);
		}
		
		return redirect('/admin')->with($result);
    }
}


