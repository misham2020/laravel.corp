<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use App\Menu;
use App\Repository\ArticlesRepository;
use App\Repository\CommentsRepository;
use App\Repository\MenusRepository;
use App\Repository\PortfoliosRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ArticlesController extends SiteController
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(PortfoliosRepository $portfoliosRepository,
     ArticlesRepository $articlesRepository, CommentsRepository $commentsRepository)
    {
       
        parent::__construct (new MenusRepository(new Menu()));
        $this->portfoliosRepository = $portfoliosRepository;
        $this->articlesRepository = $articlesRepository;
        $this->commentsRepository = $commentsRepository;

       // dd($this->articlesRepository);
        $this->bar = 'right';
        $this->template = 'layouts.articles';
    }
    


    public function index($cat_alias = FALSE)
    {
        
        $portfolios = $this->getPortfolios();
        $comments = $this->getComments(5);
        
        
        $articles = $this->getArticles($cat_alias);


        $content = view('content_articles')->with('articles',$articles)->render();
        
        $bar = view('articleBar')->with(['comments' => $comments, 'portfolios' => $portfolios])->render();
        $this->content_rightBar = view('rightBar')->with('content_rightBar',$bar)->render();

        $this->vars = (new Arr)->add($this->vars, 'rightBar', $this->content_rightBar);
        $this->vars = (new Arr)->add($this->vars, 'content', $content); 
       
       
        return $this->renderOutput();
    }
    public function show($alias = FALSE)
    {
       
        $article = $this->articlesRepository->one($alias, ['comments' => TRUE]);
        if($article){

            $article->img = json_decode($article->img);
        }
      //  dd($article->comments->groupBy('parent_id'));
        $portfolios = $this->getPortfolios();
        $comments = $this->getComments(5);
 
        
        
        $content = view('content_article')->with('article',$article)->render();
        $this->vars = (new Arr)->add($this->vars, 'content', $content);
        //dd($content); 
        $bar = view('articleBar')->with(['comments' => $comments, 'portfolios' => $portfolios])->render();
        $this->content_rightBar = view('rightBar')->with('content_rightBar',$bar)->render();

        $this->vars = (new Arr)->add($this->vars, 'rightBar', $this->content_rightBar);
      
        return $this->renderOutput();
    }

    public function getPortfolios()
    {
        $portfolios = $this->portfoliosRepository->get('*', 5, FALSE);
       
       
        return $portfolios;
    } 
    public function getArticles($alias = FALSE)
    {
        
        $where = FALSE;
  
      if($alias){
        $id = Category::select('id')->where('alias',$alias)->first()->id;
       //dd($id);
        $where = ['category_id', $id];
        
  
      }

    $articles = $this->articlesRepository->get('*', FALSE, TRUE, $where);
      

      if($articles){
        $articles->load('user', 'category', 'comments');
    } 

        return $articles;
    } 
    public function getComments($take)
    {
        $comments = $this->commentsRepository->get('*', $take);
        
        if($comments) {
			$comments->load('article','user');
		}
     
        
        return $comments;
    } 
}
