<?php

namespace App\Http\Controllers\Admin;

use App\Filter;
use App\Http\Controllers\Controller;
use App\Http\Requests\PortfoliosRequest;
use App\Portfolio;
use App\Repository\PortfoliosRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;

class PortfoliosController extends AdminController
{
    //
    public function __construct(PortfoliosRepository $portfoliosRepository) {
		
		parent::__construct();
		
		 
        

		$this->portfoliosRepository = $portfoliosRepository;
		
		
		$this->template = 'admin.portfolios';
		
    }
    public function index()
    {
        //
        
        $this->title = 'Менеджер портфолио';
        
        $portfolios = $this->getPortfolios();
        $this->content = view('admin.portfolios_content')->with('portfolios', $portfolios)->render();
        
       /* if((new Gate)::denies('viewAdminPortfolios', new Portfolio)) {
			abort(403);
		}   */ 
        
        return $this->renderOutput();  
    }
    public function getPortfolios()
    {
        //
        
        return $this->portfoliosRepository->get();
        
        
    }
    public function create()
    {
        
        /* if((new Gate)::denies('save', new Portfolio)) {
			abort(403);
		}  */
        
        
        $this->title = "Добавить новый материал";

        $filter = Filter::select('id','title','alias')->get()->reduce(function ($returnFilters, $filter) {
		    $returnFilters[$filter->alias] = $filter->title;
		    return $returnFilters;
		});
		
		
		$this->content = view('admin.portfolios_create_content')->with(['filter' => $filter])->render();
		
		return $this->renderOutput();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PortfoliosRequest $request)
    {
        //
        $result = $this->portfoliosRepository->addPortfolio($request);

		
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
    public function edit(Portfolio $portfolio)
    {
        //
        
    // $portfolio = $this->portfoliosRepository->one($alias);
       
        /* if((new Gate)::denies('edit', new Portfolio)) {
			abort(403);
		} */ 
	
		$portfolio->img = json_decode($portfolio->img);
		
  /*       $filters = Filter::select(['title','alias','id'])->get();
        $lists = array();
        $lists = (new Arr)->add($lists,'0','фильтры');

        foreach($filters as $filter) {
			
				$lists[$filter->title] = array();
			} */
        
            $filter = Filter::select('id','title','alias')->get()->reduce(function ($returnFilters, $filter) {
                $returnFilters[$filter->alias] = $filter->title;
                return $returnFilters;
            }, ['parent_id' => 'Раздел портфолио']);
		
		$this->title = 'Редактирование материала - '. $portfolio->title;
		
		
		$this->content = view('admin.portfolios_create_content')->with(['filter' => $filter, 'portfolio' => $portfolio])->render();
		
		return $this->renderOutput();
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PortfoliosRequest $request, Portfolio $portfolio)
    {
        //
        $result = $this->portfoliosRepository->updatePortfolio($request, $portfolio);
		
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
    public function destroy(Portfolio $portfolio)
    {
       
       
        $result = $this->portfoliosRepository->deletePortfolio($portfolio);
		
		if(is_array($result) && !empty($result['error'])) {
			return back()->with($result);
		}
		
		return redirect('/admin')->with($result);
        
        
    }
}
