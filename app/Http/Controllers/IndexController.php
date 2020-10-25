<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Repository\MenusRepository;
use App\Repository\PortfoliosRepository;
use App\Repository\ArticlesRepository;
use Illuminate\Http\Request;
use App\Repository\SlidersRepository;
use Illuminate\Support\Arr;

class IndexController extends SiteController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(SlidersRepository $slidersRepository,
     PortfoliosRepository $portfoliosRepository, ArticlesRepository $articlesRepository)
    {
       
        parent::__construct (new MenusRepository(new Menu()));
        $this->portfoliosRepository = $portfoliosRepository;
        $this->slidersRepository = $slidersRepository;
        $this->articlesRepository = $articlesRepository;
       // dd($this->articlesRepository);
        $this->bar = 'right';
        $this->template = 'layouts.index';
    }
    


    public function index()
    {
        $slidersItem = $this->getSliders();
        $portfolios = $this->getPortfolios();
        $articles = $this->getArticles();


        //dd($articles);
        $sliders = view('sliders')->with('sliders',$slidersItem)->render();
        $content = view('content')->with('portfolios',$portfolios)->render();
        $this->contentRightBar = view('indexBar')->with('articles',$articles)->render();

        $this->vars = (new Arr)->add($this->vars, 'sliders', $sliders); 
        $this->vars = (new Arr)->add($this->vars, 'content', $content); 
         

        return $this->renderOutput();
    }
     public function getSliders()
    {
        $sliders = $this->slidersRepository->get('*', FALSE, FALSE);
       
        //dd($sliders);
        return $sliders;
    } 
    public function getPortfolios()
    {
        $portfolios = $this->portfoliosRepository->get('*', 5, FALSE);
       
        //dd($sliders);
        return $portfolios;
    } 
    public function getArticles()
    {
        $articles = $this->articlesRepository->get('*', 3, FALSE);
       
        //dd($sliders);
        return $articles;
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
    public function edit($id)
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
