<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Filter;
use App\Http\Controllers\Controller;
use App\Repository\ArticlesRepository;
use App\Repository\MenusRepository;
use App\Repository\PortfoliosRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Lavary\Menu\Menu as LavMenu;

class MenusController extends AdminController
{
    
    protected $menusRepository;
    
    
    public function __construct(MenusRepository $menusRepository, ArticlesRepository $articlesRepository, PortfoliosRepository $portfolioRepository)
    {
        parent::__construct();
        
        /* if(Gate::denies('VIEW_ADMIN_MENU')) {
			abort(403);	
		} */ 
        
        $this->menusRepository = $menusRepository;
        $this->articlesRepository = $articlesRepository;
        $this->portfolioRepository = $portfolioRepository;
        
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
		
		$portfolios = $this->portfolioRepository->get(['id','alias','title'])->reduce(function ($returnPortfolios, $portfolio) {
		    $returnPortfolios[$portfolio->alias] = $portfolio->title;
		    return $returnPortfolios;
		}, []);
		
		$this->content = view(env('THEME').'.admin.menus_create_content')->with(['menus'=>$menus,'categories'=>$list,'articles'=>$articles,'filters' => $filters,'portfolios' => $portfolios])->render();
		
		
		
		return $this->renderOutput();
		
 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($alias)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
