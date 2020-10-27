<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Repository\MenusRepository;
use App\Repository\PortfoliosRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PortfoliosController extends SiteController
{
    //
    public function __construct(PortfoliosRepository $portfoliosRepository)
    {
       
        parent::__construct (new MenusRepository(new Menu()));
        $this->portfoliosRepository = $portfoliosRepository;
      

       // dd($this->articlesRepository);
     
        $this->template = 'layouts.portfolios';
    }
    public function index()
    {
      
        $portfolios = $this->getPortfolios('*', TRUE, FALSE);
       
        $content = view('content_portfolios')->with('portfolios',$portfolios)->render();
        
        $this->vars = (new Arr)->add($this->vars, 'content', $content); 
       
       
        return $this->renderOutput();
    }
    public function getPortfolios($take = FALSE, $paginate = TRUE)
    {
        $portfolios = $this->portfoliosRepository->get('*',$take,$paginate);
        if ($portfolios) {
            $portfolios->load('filter');
        }
       
        return $portfolios;
    }
        public function show($alias = FALSE)
    {
       
        $portfolio = $this->portfoliosRepository->one($alias);
        if($portfolio){

            $portfolio->img = json_decode($portfolio->img);
        }
      
        $portfolios = $this->getPortfolios(8, FALSE);
 
        $content = view('content_portfolio')
        ->with(['portfolio' =>$portfolio, 'portfolios'=> $portfolios])->render();
        $this->vars = (new Arr)->add($this->vars, 'content', $content);
       // dd($portfolios); 
        return $this->renderOutput();
    }
}
