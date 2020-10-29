<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repository\ArticlesRepository;
use Illuminate\Http\Request;

class ArticlesController extends AdminController
{
    

    public function __construct(ArticlesRepository $articlesRepository) {
		
		parent::__construct();
		
		/* if(Gate::denies('VIEW_ADMIN_ARTICLES')) {
			abort(403);
		} */
		
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
        //
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
    public function edit()
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
