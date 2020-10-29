<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class IndexController extends \App\Http\Controllers\Admin\AdminController
{
    public function __construct() {
		
		parent::__construct();
	
		 /* if(Gate::denies('view_admin')) {
			abort(403);
		}   */
	
		
		
		$this->template = ('admin.index');
		
	}
	
	public function index() {
		
		$this->title = 'Панель администратора';
		
		return $this->renderOutput();
		
	}
}
