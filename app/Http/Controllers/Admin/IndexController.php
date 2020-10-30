<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Policies\ArticlePolicy;
use App\User;

class IndexController extends \App\Http\Controllers\Admin\AdminController
{
    public function __construct() {
		
		parent::__construct();
	
		
		$this->template = ('admin.index');
		
	}
	
	public function index() {
		
		$this->title = 'Панель администратора';
		return $this->renderOutput();
		
	}
}
