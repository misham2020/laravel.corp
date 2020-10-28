<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;

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
