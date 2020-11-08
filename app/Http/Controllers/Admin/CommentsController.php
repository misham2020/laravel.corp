<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Comment;
use App\Http\Controllers\Controller;
use App\Repository\CommentsRepository;
use App\User;
use Illuminate\Http\Request;

class CommentsController extends AdminController
{
    public function __construct(CommentsRepository $commentsRepository) {
		
		parent::__construct();
		
		 
        

		$this->commentsRepository = $commentsRepository;
		
		
		$this->template = 'admin.comments';
		
	}
    public function index()
    {
        //
        
        $this->title = 'Менеджер комментариев';
        
        $comments = $this->getComments();

        $article = Article::select('*')->first();
        $user = User::select('*')->first();
        //dd($article);

        $this->content = view('admin.coments_content')->with(['comments'=>$comments, 'article' => $article, 'user' => $user])->render();
        
       
        
        return $this->renderOutput(); 
        
        
    }
    public function getComments()
    {
        //
        
        return $this->commentsRepository->get();
        
        
    }
    public function destroy(Comment $comment)
    {
        //
      
        $result = $this->commentsRepository->deleteComment($comment);
		//dd($result);
		if(is_array($result) && !empty($result['error'])) {
			return back()->with($result);
		}
		return back()->with($result);
		//return redirect('/')->with($result);
    }
}
