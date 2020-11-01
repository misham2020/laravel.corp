<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Repository\ArticlesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ArticlesController extends AdminController
{
    

    public function __construct(ArticlesRepository $articlesRepository) {
		
		parent::__construct();
		
		 
        

		$this->articlesRepository = $articlesRepository;
		
		
		$this->template = 'admin.articles';
		
	}
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
        $this->title = 'Менеджер статей';
        
        $articles = $this->getArticles();
        $this->content = view('admin.articles_content')->with('articles',$articles)->render();
        
       if((new Gate)::denies('viewAdminArticles', new Article)) {
			abort(403);
		}   
        
        return $this->renderOutput(); 
        
        
    }
    
    
     public function getArticles()
    {
        //
        
        return $this->articlesRepository->get();
        
        
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        if((new Gate)::denies('save', new Article)) {
			abort(403);
		} 
        
        
        $this->title = "Добавить новый материал";
		
		$categories = Category::select(['title','alias','parent_id','id'])->get();
		
		$lists = array();
		
		foreach($categories as $category) {
			if($category->parent_id == 0) {
				$lists[$category->title] = array();
			}
			else {
				$lists[$categories->where('id',$category->parent_id)->first()->title][$category->id] = $category->title;    
			}
		}
		
		$this->content = view('admin.articles_create_content')->with('categories', $lists)->render();
		
		return $this->renderOutput();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        //
		$result = $this->articlesRepository->addArticle($request);
		
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
    public function edit($alias)
    {
        //
        
        $article = $this->articlesRepository->one($alias);
        if((new Gate)::denies('edit', new Article)) {
			abort(403);
		} 
	
		$article->img = json_decode($article->img);
		
		
		$categories = Category::select(['title','alias','parent_id','id'])->get();
		
		$lists = array();
		
		foreach($categories as $category) {
			if($category->parent_id == 0) {
				$lists[$category->title] = array();
			}
			else {
				$lists[$categories->where('id',$category->parent_id)->first()->title][$category->id] = $category->title;    
			}
		}
		
		$this->title = 'Редактирование материала - '. $article->title;
		
		
		$this->content = view('admin.articles_create_content')->with(['categories' =>$lists, 'article' => $article])->render();
		
		return $this->renderOutput();
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, $alias)
    {
        //
        $article = $this->articlesRepository->one($alias);
        $result = $this->articlesRepository->updateArticle($request, $article);
		
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
    public function destroy($id)
    {
        //
    }
}
