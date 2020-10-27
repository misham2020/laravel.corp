<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Menu;
use App\Repository\MenusRepository;
use Illuminate\Support\Facades\Mail;

class ContactController extends SiteController
{
    //
    public function __construct() {
    	
    	parent::__construct (new MenusRepository(new Menu()));
    	
    	
    	$this->bar = 'left';
    	
    	$this->template = ('layouts.contact');
		
	}

    public function index(Request $request)
    {
		
		if ($request->isMethod('post')) {
            $messages = [
            'require' => "Поле :attribute обязательно для ввода",
            'email' => "Поле :attribute является емэйлом"
                        ];
        
            $this->validate($request,
                [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'text' => 'required'
                ],
				$messages);
				
			$data = $request->all();
			
       

            Mail::send('email', ['data' => $data], function ($message) use ($data) {
                $message->to($data['email'], $data['name']);
                $message->from('admin@mail.ru')->subject('Your Reminder!');
            });
        }

        $content = view('content_contact')->render();
        $this->vars = (new Arr)->add($this->vars,'content',$content);
        
        $this->contentLeftBar = view('contact_bar')->render();
 
        return $this->renderOutput();
    }
}
